#!/usr/bin/env bash
# Generate new app key
php artisan key:generate
# Migrate database
php artisan migrate
# Seed in the test data
php artisan db:seed
# Optimize the app
php artisan optimize