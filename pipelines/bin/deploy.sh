#!/usr/bin/env bash

set -e

cd pipelines/deployer
composer install -o --no-dev
./vendor/bin/dep deploy $ENV \
--revision="$BUCKET_COMMIT" \
-o deploy_path_custom=$HOST_DEPLOY_PATH \
-o user=$USER