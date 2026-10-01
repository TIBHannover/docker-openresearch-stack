# Changelog

All notable changes to this project will be documented in this file.
This project adheres to [Semantic Versioning](https://semver.org/) and
[Keep a Changelog](https://keepachangelog.com/en/1.1.0/).

## [Unreleased]

## [1.39.17-003] - 2026-10-01

### Changed
- ci(docker): align linting with docker-mediawiki-core [`952cd4c`](https://github.com/TIBHannover/docker-openresearch-stack/commit/952cd4c)
- feat(docker): add additional hardening [`7f6b36d`](https://github.com/TIBHannover/docker-openresearch-stack/commit/7f6b36d)
- test(security): add hardening checks to make ci [`7c32974`](https://github.com/TIBHannover/docker-openresearch-stack/commit/7c32974)
- ci(github): run make ci on pull requests and pushes [`69afe4f`](https://github.com/TIBHannover/docker-openresearch-stack/commit/69afe4f)

## [1.39.17-002] - 2026-09-28

### Fixed
- fix(ExternalData): backport CVE-2026-100382 fix (unauthenticated remote code execution via untrimmed Lua argument names bypassing the wiki-wide program command configuration)

### Changed
- deps(JSBreadCrumbs): bump from 1.1.1 to 8ccb1bd5 (last commit of the now-deleted upstream REL1_39 branch)
  - no functional change; re-pinned to a commit hash since upstream version tags are not reliably in sync with REL branches
- deps(PageForms): bump from 2.1.11 to 2.1.12
  - fix(formfield): guard global Parser against OT_WIKI/untitled state in mapping template resolution, fixing a `mapping template=` field showing the raw, unresolved template call instead of its label, and an `SF_Select` field's `function=` argument showing raw, unresolved markup instead of its result
- deps(PageForms): bump from 2.1.10 to 2.1.11 [`70abc36`](https://github.com/TIBHannover/docker-openresearch-stack/commit/70abc36)
  - feat: add `PFUtils::ensureParserInitialized()` central helper that initializes a `Parser` only if it hasn't been already, replacing several independently-written inline guards against the same MW 1.42+ typed-property problem
  - fix(runquery): guard `getOutput()`/`parse()` and `addFormRLModules()` calls with `PFUtils::ensureParserInitialized()` when the singleton hasn't been initialized yet this request, fixing a fatal error on MW 1.42+ (`Parser::$mOutput` is now a typed property) reproducible with `format=leaflet` query results or embedded forms with no `{{{field|...}}}` tags
  - fix(sfselect): call `clearState()` instead of `resetOutput()` on the freshly constructed `Parser` in `PFSFSelectAPI::createParser()`, part of the same MW 1.42+ typed-property bug family
  - fix(formfield): show the display title instead of the raw stored page name for a disabled (read-only) `text`, `combobox`, or `textarea` field bound to a Page-type value
  - fix(show-on-select): fix mutually-exclusive alternative rows staying visible at the same time when the target row's `id`/`data-origID` had been Sanitizer-escaped
- deps(PageForms): bump from 2.1.9 to 2.1.10
- deps(PageForms): bump from 2.1.3 to 2.1.9
  - fix(values-utils): align SMW property-value namespace prefix with the canonical English name, fixing DisplayTitle lookups for dropdown/combobox/tokens/checkboxes/radiobutton inputs on non-English wikis (2.1.4)
  - fix(autoedit): resolve `IDBAccessObject` against the global namespace so MW 1.39 form submissions with `{num}`/unique-number page-name formulas no longer fatal (2.1.5)
  - fix(autoedit): correct info-tag page-name extraction regex so a trailing `{num}}}}` sequence no longer truncates the formula by one character (2.1.5)
  - fix(values): fall back to namespace-tolerant page-value comparison so legacy localized-namespace-prefixed values still resolve to their SMW DisplayTitle in dropdown/combobox/tokens/checkboxes/radiobutton inputs (2.1.6)
  - internal refactoring: PSR-4 namespace migration for the form/template domain model, plus centralized possible-value matching, page-value comparison, span-class building, and hidden-input generation into shared helpers (no behavior change) (2.1.4, 2.1.6, 2.1.7)
  - fix(FormPrinter): cast a form field's current value to `string` before substituting it into a page-name formula, fixing a `TypeError` that broke `Special:FormEdit` when the field's stored value round-tripped as `int`/`float`/`bool` (2.1.8)
  - fix(combobox): show a field's clean display title instead of the raw page title (e.g. "Person:Rizzo the Rat"), and stop the value disappearing when the field was clicked (2.1.9)
  - fix(mapping): fix an error that broke the edit/preview page for forms with a numeric-rating mapping field (e.g. a 1–5 rating scale) (2.1.9)
  - fix(dropdown/combobox): show a clean label instead of a raw, namespace-prefixed value (e.g. "Category:Foo") when the saved value wasn't among the field's suggested options (2.1.9)
  - fix(checkboxes/dropdown/listbox/radiobutton): stop losing or hiding a saved value when it wasn't among the field's suggested options — in the radio-button case this could silently blank out the value on save (2.1.9)
  - fix(remote-autocompletion): actually prevent a large list of values (from a category, namespace, concept, or property) from being fully loaded on every page view (2.1.9)

## [1.39.17-001] - 2026-07-21

### Changed
- deps(mediawiki): 1.39.15 → 1.39.17
  - contains several security fixes (CVE-2025-67475, CVE-2025-67478, CVE-2025-67479, CVE-2025-67480, CVE-2025-67481, CVE-2025-67482) — see MediaWiki 1.39.16/1.39.17 release notes
  - plus routine submodule updates and translatewiki.net localisation updates across REL1_39
- deps(docker-mediawiki-tools): 5.0.0 → 5.2.1
  - fix(initialize-wiki): always clean up LocalSettings.TMP.php on failure
  - fix(composer-update): use `--prefer-dist` instead of `--prefer-source`
  - fix(initialize-wiki): disable search updates before update.php — extensions that create wiki pages during update.php queue SearchUpdate jobs, causing ES to auto-create "wiki_content" as a plain index and fail alias registration
  - feat(install-extensions): add script to install custom MediaWiki extensions from JSON config
  - fix(run-jobs): support lockfile to pause execution during backup/restore ([#5](https://github.com/gesinn-it-pub/docker-mediawiki-tools/pull/5))
  - fix(run-jobs): use `-f` instead of `-e` for lockfile check
  - fix(run-jobs): re-check lockfile between batches, not just on startup
- deps(PageForms): 2.0.1 → 2.1.3
  - security fixes: SPARQL injection in "values from wikidata" fields, stored XSS in translatable field tags
  - several `TypeError`/fatal-error fixes across forms, spreadsheet, maps, and upload handling
  - large internal refactoring and test-coverage additions (no behavior change)
- deps(phpspreadsheet): 1.30.1 → 1.30.5
- chore(deps): update EditAccount to 3.1.0
- chore(deps): update DisplayTitle to 4.2.0 (gesinn-it-pub)
- chore(deps): update Arrays to 2.2.2

### Fixed
- fix(SemanticResultFormats): patch `SRF_Array.php` to detect modern Arrays extension via `class_exists('ExtArrays')` — `ExtArrays::VERSION` constant was removed in Arrays 2.x, causing `#arrayprint` to produce no output

### CI
- ci(lint): add `make lint` target with hadolint, shellcheck, and compose validation

## [1.39.15-012] - 2026-06-10

### Changed
- deps(PageForms): update to version 1.3.5

## [1.39.15-011] - 2026-05-12

### Changed
- deps: update CookieWarning (2024-06-17), DateDiff (2024-06-11), Mermaid 6.0.1→6.0.2, NativeSvgHandler (2024-06-12), PageForms 5.5.1.0-alpha3→1.3.3, RegexFunctions (2024-06-12), phpspreadsheet 1.29.0→1.30.1 ([`32bd61d`](https://github.com/TIBHannover/docker-openresearch-stack/commit/32bd61d))

## [1.39.15-010] - 2026-02-18

### Changed
- deps(PageForms): 5.5.1.0-alpha3 → 5.5.1.0-alpha3
- deps(SemanticResultFormats): 5.1.0 → 5.2.0
- chg(MainCacheType): set to `CACHE_DB` to avoid [phabricator T417769](https://phabricator.wikimedia.org/T417769)

## [1.39.15-009] - 2026-02-10

### Changed
- deps: update ConfirmAccount and SemanticResultFormats to pinned versions

## [1.39.15-008] - 2026-02-10

### Changed
- deps(SemanticResultFormats): update to a pinned commit id that supports fixed Graph format

## [1.39.15-007] - 2026-02-09

### Changed
- deps(Modern Timeline): 1.2.2 → 2.0.0

## [1.39.15-006] - 2026-02-04

### Changed
- deps(SemanticResultFormats): → 5.1.0
- deps(SemanticDependencyUpdater): 4.0.0 → 4.2.0
- deps(SemanticCompoundQueries): 3.0.0-beta → 3.0.0

## [1.39.15-005] - 2026-01-28

### Changed
- refactor: reorder LocalSettings configuration blocks
- add `$wgShellLocale` for stable UTF-8 shell execution
- chg: update Ofelia job schedule to run every 15 seconds and prevent overlap

## [1.39.15-004] - 2026-01-22

### Changed
- deps(docker-mediawiki-tools): 4.1.0 → 5.0.0
  - chg(cron): newer MW images do not contain cron anymore (but use a job scheduler like Ofelia); remove any cron configuration / start, stop commands

## [1.39.15-003] - 2026-01-21

### Fixed
- fix(PlantUML): use GitHub as download mirror; enable PlantUML in ExternalData

### Changed
- deps(plantuml): v1.2022.2 → v1.2022.14

## [1.39.15-002] - 2026-01-21

### Changed
- deps(PageForms): 5.5.1.0-alpha1 → 5.5.1.0-alpha2

## [1.39.15-001] - 2025-12-01

### Changed
- deps(PF): → 5.5.1.0-alpha1
- deps(MW): → 1.39.15 (note: the base image now uses Debian Trixie instead of Bookworm)
- chg: switch to Ofelia for scheduled MediaWiki jobs; replace the internal cron service with Ofelia as a Docker-based scheduler. This resolves issues with dangling cron-related processes and unexpected container behavior reported during local CI runs. The wiki container no longer installs or runs cron; scheduled tasks are now executed via Ofelia job-exec labels.

## [1.39.13-005] - 2025-09-18

### Changed
- chg: `$wgRestrictDisplayTitle = false;`

## [1.39.13-004] - 2025-08-12

### Changed
- deps(PageForms): → 5.4.0.3

## [1.39.13-003] - 2025-08-12

### Changed
- deps(DisplayTitle): downgrade to 4.0.2 (final version before MW 1.41 becomes mandatory, even though the version number only increased from 4.0.2 to 4.0.3)

## [1.39.13-002] - 2025-08-04

### Changed
- deps(SemanticResultFormats): temp. use commit `0262821` for latest Graph format that includes the `graphfieldpages` option
- deps(SemanticMediaWiki): → 5.1.0
- deps(Mermaid): 3.1.0 → 6.0.1
- deps(Maps): 10.2.0 → 11.0.1
- deps(AutoCreatePage): use latest version
- deps(docker-mediawiki-tools): update to 3.3.2

## [1.39.13-001] - 2025-07-21

### Changed
- deps(SemanticResultFormats): → 5.0.0
- deps(SemanticExtraSpecialProperties): → 4.0.0
- deps(SemanticCompoundQueries): → 3.0.0-beta
- deps(SemanticDependencyUpdater): → 4.0.0
- deps(SemanticMediaWiki): temp. use commit `bccedaf` for [SemanticMediaWiki@5941613](https://github.com/SemanticMediaWiki/SemanticMediaWiki/commit/5941613b5ab0f09043fb0a150433d0784dcb2057) to support KnowledgeGraph
- deps(Loops): → commit `83cd81d`
- deps(Elastica): → commit `426e234`
- deps(EditAccount): → 2025-02-20
- deps(DisplayTitle): → latest commit that works with MW 1.39
- deps(AdminLinks): → 0.6.3
- deps(mw): 1.39.13

## [1.39.10-001] - 2024-10-16

### Changed
- deps(mw): 1.39.10
- deps(smw): 4.1.3 → 4.2.0

## [1.39.8-001] - 2024-09-17

### Changed
- deps(mediawiki): 1.39.8

### Fixed
- fix: set permissions of `/var/www/html` to 755 instead of 1777 (default)

## [1.39.7-003] - 2024-09-11

### Changed
- deps(docker-mediawiki-tools): → 3.0.1
  - fix(update-search-index.sh): change path from `extensions/CirrusSearch` to `extensions/Cirrussearch`, required for Cirrus MW 1.39+

## [1.39.7-002] - 2024-09-11

### Changed
- deps(docker-mediawiki-tools): → 3.0.0
- deps(elasticsearch): set correct image & version required for MW 1.39

## [1.39.7-001] - 2024-06-05

Initial tagged release.

[Unreleased]: https://github.com/TIBHannover/docker-openresearch-stack/compare/1.39.17-001...HEAD
[1.39.17-001]: https://github.com/TIBHannover/docker-openresearch-stack/compare/1.39.15-012...1.39.17-001
[1.39.15-012]: https://github.com/TIBHannover/docker-openresearch-stack/compare/1.39.15-011...1.39.15-012
[1.39.15-011]: https://github.com/TIBHannover/docker-openresearch-stack/compare/1.39.15-010...1.39.15-011
[1.39.15-010]: https://github.com/TIBHannover/docker-openresearch-stack/compare/1.39.15-009...1.39.15-010
[1.39.15-009]: https://github.com/TIBHannover/docker-openresearch-stack/compare/1.39.15-008...1.39.15-009
[1.39.15-008]: https://github.com/TIBHannover/docker-openresearch-stack/compare/1.39.15-007...1.39.15-008
[1.39.15-007]: https://github.com/TIBHannover/docker-openresearch-stack/compare/1.39.15-006...1.39.15-007
[1.39.15-006]: https://github.com/TIBHannover/docker-openresearch-stack/compare/1.39.15-005...1.39.15-006
[1.39.15-005]: https://github.com/TIBHannover/docker-openresearch-stack/compare/1.39.15-004...1.39.15-005
[1.39.15-004]: https://github.com/TIBHannover/docker-openresearch-stack/compare/1.39.15-003...1.39.15-004
[1.39.15-003]: https://github.com/TIBHannover/docker-openresearch-stack/compare/1.39.15-002...1.39.15-003
[1.39.15-002]: https://github.com/TIBHannover/docker-openresearch-stack/compare/1.39.15-001...1.39.15-002
[1.39.15-001]: https://github.com/TIBHannover/docker-openresearch-stack/compare/1.39.13-005...1.39.15-001
[1.39.13-005]: https://github.com/TIBHannover/docker-openresearch-stack/compare/1.39.13-004...1.39.13-005
[1.39.13-004]: https://github.com/TIBHannover/docker-openresearch-stack/compare/1.39.13-003...1.39.13-004
[1.39.13-003]: https://github.com/TIBHannover/docker-openresearch-stack/compare/1.39.13-002...1.39.13-003
[1.39.13-002]: https://github.com/TIBHannover/docker-openresearch-stack/compare/1.39.13-001...1.39.13-002
[1.39.13-001]: https://github.com/TIBHannover/docker-openresearch-stack/compare/1.39.10-001...1.39.13-001
[1.39.10-001]: https://github.com/TIBHannover/docker-openresearch-stack/compare/1.39.8-001...1.39.10-001
[1.39.8-001]: https://github.com/TIBHannover/docker-openresearch-stack/compare/1.39.7-003...1.39.8-001
[1.39.7-003]: https://github.com/TIBHannover/docker-openresearch-stack/compare/1.39.7-002...1.39.7-003
[1.39.7-002]: https://github.com/TIBHannover/docker-openresearch-stack/compare/1.39.7-001...1.39.7-002
[1.39.7-001]: https://github.com/TIBHannover/docker-openresearch-stack/releases/tag/1.39.7-001
