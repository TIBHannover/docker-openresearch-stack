show-current-target = @echo; echo "======= $@ ========"

.PHONY: all
all:

compose = docker compose $(COMPOSE_ARGS)
compose-run = $(compose) run --rm
compose-exec = $(compose) exec -T
compose-cp = docker compose cp
wiki-exec = $(compose-exec) wiki

# ======== Lint ========

.PHONY: lint
lint: lint-dockerfile lint-sh lint-compose

.PHONY: lint-dockerfile
lint-dockerfile:
	$(show-current-target)
	docker run --rm -i -v $(PWD)/.hadolint.yaml:/hadolint.yaml --entrypoint hadolint hadolint/hadolint --config /hadolint.yaml -

.PHONY: lint-sh
lint-sh:
	$(show-current-target)
	docker run --rm -v $(PWD):/mnt:ro koalaman/shellcheck-alpine shellcheck \
	  /mnt/context/tools/startup-container.sh \
	  /mnt/context/build-tools/composer-update.sh

.PHONY: lint-compose
lint-compose:
	$(show-current-target)
	docker compose -f docker-compose.yml config --quiet

# ======== Build ========

.PHONY: build
build:
	docker build \
	  --tag ghcr.io/gesinn-it-pub/openresearch-stack:dev \
	  ./context

# ======== Run ========

.PHONY: up
up:
	$(show-current-target)
	$(compose) up -d

.PHONY: wait-for-wiki
wait-for-wiki:
	$(show-current-target)
	$(compose-run) wait-for-wiki

.PHONY: show-status
show-status:
	$(show-current-target)
	$(compose) ps

.PHONY: show-logs
show-logs:
	docker compose logs -f || exit 0

.PHONY: show-jobs
show-jobs:
	$(show-current-target)
	$(wiki-exec) php maintenance/showJobs.php --list

.PHONY: show-jobs-count
show-jobs-count:
	$(show-current-target)
	$(wiki-exec) php maintenance/showJobs.php

.PHONY: stop
stop:
	$(show-current-target)
	$(compose) stop

.PHONY: down
down:
	$(show-current-target)
	$(compose) down

.PHONY: destroy
destroy:
	$(show-current-target)
	$(compose) down --volumes --remove-orphans

# ======== Develop ========
.PHONY: bash
bash:
	$(show-current-target)
	$(compose) exec wiki bash
