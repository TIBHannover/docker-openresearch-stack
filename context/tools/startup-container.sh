#!/bin/bash

set -euxo pipefail

## 251201-GEA: we use Ophelia as job scheduler
# service cron start
initialize-wiki.sh

apache2-foreground
