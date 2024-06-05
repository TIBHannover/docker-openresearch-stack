show-current-target = @echo; echo "======= $@ ========"

.PHONY: all
all:

compose = docker compose $(COMPOSE_ARGS)
compose-run = $(compose) run --rm
compose-exec = $(compose) exec -T
compose-cp = docker compose cp
wiki-exec = $(compose-exec) wiki

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
