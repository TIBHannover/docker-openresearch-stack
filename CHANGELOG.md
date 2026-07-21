# Changelog

All notable changes to this project will be documented in this file.
This project adheres to [Semantic Versioning](https://semver.org/) and
[Keep a Changelog](https://keepachangelog.com/en/1.1.0/).

## [Unreleased]

### Changed
- deps(mediawiki): bump from 1.39.15 to 1.39.17 ([`ab71d3f`](https://github.com/TIBHannover/docker-openresearch-stack/commit/ab71d3f))
- deps(docker-mediawiki-tools): bump from 5.0.0 to 5.2.1 ([`ed5a2bb`](https://github.com/TIBHannover/docker-openresearch-stack/commit/ed5a2bb))
- deps(PageForms): bump from 2.0.1 to 2.1.3 ([`aa129df`](https://github.com/TIBHannover/docker-openresearch-stack/commit/aa129df))
- deps(PageForms): bump from 2.0.0 to 2.0.1 ([`2f4bd96`](https://github.com/TIBHannover/docker-openresearch-stack/commit/2f4bd96))
- deps(PageForms): bump from 1.3.5 to 2.0.0 ([`616a280`](https://github.com/TIBHannover/docker-openresearch-stack/commit/616a280))
- deps(phpspreadsheet): bump from 1.30.1 to 1.30.5 ([`32bf4db`](https://github.com/TIBHannover/docker-openresearch-stack/commit/32bf4db))
- chore(deps): update EditAccount to 3.1.0 ([`6b1e82d`](https://github.com/TIBHannover/docker-openresearch-stack/commit/6b1e82d))
- chore(deps): update EditAccount to 3.0.0 ([`67ccb2f`](https://github.com/TIBHannover/docker-openresearch-stack/commit/67ccb2f))
- chore(deps): update DisplayTitle to 4.2.0 (gesinn-it-pub) ([`0cafbac`](https://github.com/TIBHannover/docker-openresearch-stack/commit/0cafbac))
- chore(deps): update Arrays to 2.2.2 ([`c842239`](https://github.com/TIBHannover/docker-openresearch-stack/commit/c842239))

### Fixed
- fix(SemanticResultFormats): patch SRF_Array to detect modern Arrays extension ([`bc5bc77`](https://github.com/TIBHannover/docker-openresearch-stack/commit/bc5bc77))

### CI
- ci(lint): add make lint target with hadolint, shellcheck, and compose validation ([`abda814`](https://github.com/TIBHannover/docker-openresearch-stack/commit/abda814))

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

[Unreleased]: https://github.com/TIBHannover/docker-openresearch-stack/compare/1.39.15-012...HEAD
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
