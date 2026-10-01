#!/bin/bash
#
# Anonymous security checks, executed inside the wiki container.
#
# Requests to the container's own IP are not treated as local (only
# 127.0.0.1 is allowed to read, see LocalSettings.Permissions.php), so they
# are anonymous. Test data is created via 127.0.0.1 and maintenance scripts.
#
# WIKI_PUBLIC_FILES=true in the container switches to the expectations for
# public wikis (direct file access allowed).

set -uo pipefail

IP_URL="http://$(hostname -i | awk '{print $1}')"
LOCAL_URL="http://127.0.0.1"
PUBLIC=false
[ "${WIKI_PUBLIC_FILES:-}" = "true" ] && PUBLIC=true

failures=0

status() {
	curl -s -o /dev/null -w '%{http_code}' "$@"
}

expect() {
	local expected="$1" label="$2"
	shift 2
	local actual
	actual="$(status "$@")"
	if [[ "$actual" =~ ^($expected)$ ]]; then
		echo "ok      $label ($actual)"
	else
		echo "FAILED  $label: expected $expected, got $actual"
		failures=$((failures + 1))
	fi
}

expect_header_absent() {
	local header="$1" pattern="$2" value
	value="$(curl -sI "$IP_URL/load.php" | grep -i "^$header:" || true)"
	if grep -qiE "$pattern" <<<"$value"; then
		echo "FAILED  header $header discloses version: $value"
		failures=$((failures + 1))
	else
		echo "ok      header $header: ${value:-<absent>}"
	fi
}

# ---- test data: a file with a thumbnail -----------------------------------

name="SecurityCheck$$.png"
dir="$(mktemp -d)"
chown www-data: "$dir"
# shellcheck disable=SC2016
php -r '$i = imagecreatetruecolor(400, 400); imagepng($i, $argv[1]);' "$dir/$name"
chown www-data: "$dir/$name"
su www-data -s /bin/bash -c "cd /var/www/html && php maintenance/importImages.php --overwrite '$dir'" >/dev/null

rendered="$(curl -s "$LOCAL_URL/api.php" \
	--data-urlencode 'action=parse' --data-urlencode 'format=json' \
	--data-urlencode 'contentmodel=wikitext' --data-urlencode 'prop=text' \
	--data-urlencode "text=[[File:$name|50px]]" --data-urlencode 'disablelimitreport=1')"
thumb_path="$(echo "$rendered" | grep -oE 'src=\\"[^"\\]*thumb[^"\\]*' | head -1 | sed 's/^src=\\"//; s/&amp;/\&/g')"
rm -rf "$dir"

if [ -z "$thumb_path" ]; then
	echo "FAILED  could not determine thumbnail URL of the test file"
	echo "$rendered" | head -c 600
	exit 1
fi
hash_dir="$(echo "$thumb_path" | sed -E 's#.*/thumb/([^/]+/[^/]+)/.*#\1#')"
base_path="${thumb_path%%/thumb/*}"
direct_thumb="/images/thumb/${thumb_path#*/thumb/}"
direct_file="/images/$hash_dir/$name"
echo "thumbnail URL used by the wiki: $thumb_path"

# ---- uploads and thumbnails -------------------------------------------------

if $PUBLIC; then
	expect 200 "public: direct file" "$IP_URL$direct_file"
	expect 200 "public: direct thumbnail" "$IP_URL$direct_thumb"
else
	case "$thumb_path" in
		*img_auth.php*) echo "ok      thumbnail URL is served via img_auth.php" ;;
		*) echo "FAILED  thumbnail URL does not use img_auth.php"; failures=$((failures + 1)) ;;
	esac
	expect 403 "anonymous: thumbnail via wiki URL" "$IP_URL$thumb_path"
	expect 403 "anonymous: file via img_auth.php" "$IP_URL$base_path/$hash_dir/$name"
	expect 403 "anonymous: direct file" "$IP_URL$direct_file"
	expect 403 "anonymous: direct thumbnail" "$IP_URL$direct_thumb"
	expect 403 "anonymous: thumb.php" "$IP_URL/thumb.php?f=$name&w=50"
	expect 403 "anonymous: thumb_handler.php" "$IP_URL/thumb_handler.php/thumb/${direct_thumb#/images/thumb/}"
	expect 200 "local (127.0.0.1): thumbnail via wiki URL" "$LOCAL_URL$thumb_path"
fi
expect 403 "images listing" "$IP_URL/images/"

# ---- files in the web root --------------------------------------------------

for f in composer.json composer.local.json composer.lock docker-compose.yml \
	README.md SECURITY CREDITS COPYING mediawiki-core-version.txt openresearch-stack-version.txt jsduck.json jsdoc.json \
	LocalSettings.Include.php LocalSettings.MediaWiki.Core/LocalSettings.Settings.php \
	LocalSettings.OpenResearchStack/LocalSettings.Settings.php \
	mw-config/ mw-config/index.php extensions/SemanticMediaWiki/extension.json \
	extensions/Echo/extension.json skins/Vector/skin.json \
	includes/Setup.php maintenance/update.php vendor/autoload.php \
	cache/ languages/ tests/ docs/ extensions/ skins/; do
	# the file set differs between MediaWiki versions
	[ -e "/var/www/html/$f" ] || continue
	expect 403 "anonymous: /$f" "$IP_URL/$f"
done
release_notes="$(find /var/www/html -maxdepth 1 -name 'RELEASE-NOTES-*' -printf '%f\n' | head -1)"
expect 403 "anonymous: /$release_notes" "$IP_URL/$release_notes"
if [ -f /var/www/html/extensions/SemanticMediaWiki/.smw.json ]; then
	expect 403 "anonymous: /extensions/SemanticMediaWiki/.smw.json" "$IP_URL/extensions/SemanticMediaWiki/.smw.json"
fi

# ---- things that must keep working -------------------------------------------

expect "200|301|302" "index.php (login page)" "$IP_URL/index.php?title=Special:UserLogin"
expect 200 "load.php" "$IP_URL/load.php?modules=startup&only=scripts&raw=1&skin=vector"
expect 200 "resources: png" "$IP_URL/resources/assets/poweredby_mediawiki_88x31.png"
expect 200 "resources: js" "$IP_URL/resources/lib/jquery/jquery.js"
expect 200 "extension: js" "$IP_URL/extensions/Echo/modules/ext.echo.js"
if [ "$(curl -s "$IP_URL/api.php?action=query&meta=siteinfo&format=json" | grep -c readapidenied)" -gt 0 ] || $PUBLIC; then
	echo "ok      api.php denies anonymous reads (or wiki is public)"
else
	echo "FAILED  api.php does not deny anonymous reads"
	failures=$((failures + 1))
fi

# ---- version disclosure ------------------------------------------------------

expect_header_absent Server '[0-9]'
expect_header_absent X-Powered-By '.'

if [ "$failures" -gt 0 ]; then
	echo "$failures security check(s) FAILED"
	exit 1
fi
echo "all security checks passed"
