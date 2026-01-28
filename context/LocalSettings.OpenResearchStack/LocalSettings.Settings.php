<?php
############################################################################
## SETTINGS
############################################################################

## ------------------------------------------------------------------------
## PHP runtime settings
## ------------------------------------------------------------------------

# Increase maximum execution time (default 30s) to avoid issues with
# long running scripts, e.g. Special:Import
set_time_limit(300);

## ------------------------------------------------------------------------
## Core limits / Performance boundaries
## ------------------------------------------------------------------------

$wgMaxArticleSize    = 4096;
$wgAPIMaxResultSize  = $wgMaxArticleSize * 4096;
$wgAPIMaxDBRows      = 25000;

## ------------------------------------------------------------------------
## Caching / Job queue
## ------------------------------------------------------------------------

$wgCacheDirectory = "$IP/cache";

$wgJobRunRate = 0;

## ------------------------------------------------------------------------
## Shared memory / Object cache (Memcached)
## ------------------------------------------------------------------------

$wgMainCacheType    = CACHE_MEMCACHED;
$wgParserCacheType  = CACHE_MEMCACHED;
$wgMessageCacheType = CACHE_MEMCACHED;

$wgMemCachedServers = [ "127.0.0.1:11211" ];

$wgSessionCacheType            = CACHE_DB;
$wgObjectCacheSessionExpiry    = 86400;
$wgExtendedLoginCookieExpiration = 86400 * 180;

## ------------------------------------------------------------------------
## Shell execution environment / Limits
## ------------------------------------------------------------------------

# Ensure stable UTF-8 locale for external command execution
$wgShellLocale = "C.UTF-8";

# Required e.g. by PDF Handler for large PDFs
$wgMaxShellFileSize = 614400;
$wgMaxShellMemory   = 614400;

## ------------------------------------------------------------------------
## Redirect / Display behaviour
## ------------------------------------------------------------------------

$wgFixDoubleRedirects   = true;
$wgRestrictDisplayTitle = false;

## ------------------------------------------------------------------------
## UI / Branding
## ------------------------------------------------------------------------

$wgFavicon = "$wgScriptPath/resources/src/mediawiki.openresearch.media/favicon.ico";

## ------------------------------------------------------------------------
## Extensions
## ------------------------------------------------------------------------

$wgPFEnableStringFunctions = true;

## ------------------------------------------------------------------------
## Security: Password attempt throttle
## ------------------------------------------------------------------------

$wgPasswordAttemptThrottle = [
    [ 'count' => 5, 'seconds' => 3600 ],
    [ 'count' => 2, 'seconds' => 300 ],
];

## ------------------------------------------------------------------------
## E-Mail configuration
## ------------------------------------------------------------------------

$wgEnableEmail     = true;
$wgEnableUserEmail = true; # UPO

$wgEmergencyContact = "support@acme.com";
$wgPasswordSender   = "support@acme.com";

$wgEnotifUserTalk      = true; # UPO
$wgEnotifWatchlist     = true; # UPO
$wgEmailAuthentication = true;

$wgSMTP = [
    'host'     => 'mail.acme.com',
    'IDHost'   => 'acme.com',
    'port'     => 25,
    'username' => 'test',
    'password' => 'secret',
    'auth'     => true,
];

## ------------------------------------------------------------------------
## Timezone / Localization
## ------------------------------------------------------------------------

$wgLocaltimezone = "Europe/Berlin";
putenv("TZ=$wgLocaltimezone");

$wgLocalTZoffset = date("Z") / 60;

$wgDefaultUserOptions['timecorrection'] =
    'ZoneInfo|' . (date("I") ? 120 : 60) . '|Europe/Berlin';

## ------------------------------------------------------------------------
## Default user preferences (UPO)
## ------------------------------------------------------------------------

# Language
$wgDefaultUserOptions['language'] = 'en';

# Files / Thumbnails
$wgDefaultUserOptions['thumbsize'] = 0; # 0 defaults to 60px

# Semantic MediaWiki
$wgDefaultUserOptions['smw-prefs-general-options-time-correction']     = 1;
$wgDefaultUserOptions['smw-prefs-general-options-disable-search-info'] = 1;
$wgDefaultUserOptions['smw-prefs-general-options-suggester-textinput'] = 1;

## ------------------------------------------------------------------------
## Hooks / Behaviour customizations
## ------------------------------------------------------------------------

# Edit redlinks with VisualEditor by default
$wgHooks['HtmlPageLinkRendererBegin'][] =
    function ( $linkRenderer, $target, &$text, &$extraAttribs, &$query, &$ret ) {

        $title = Title::newFromLinkTarget( $target );

        if ( !$title->isKnown() ) {
            $query['veaction'] = 'edit';
            $query['action']   = 'view'; // Prevent MediaWiki overriding veaction
        }
    };

## ------------------------------------------------------------------------
## Moderation / Patrol
## ------------------------------------------------------------------------

$wgUseRCPatrol  = false;
$wgUseNPPatrol  = false;

## ------------------------------------------------------------------------
## File uploads
## ------------------------------------------------------------------------

$wgEnableUploads   = true;
$wgFileExtensions  = [ 'png', 'gif', 'jpg', 'jpeg', 'svg', 'webp' ];

# Required to allow e.g. docx (MIME type mismatches)
$wgVerifyMimeType = false;
