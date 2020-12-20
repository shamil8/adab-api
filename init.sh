#!/usr/bin/env bash

# Create database
echo "Creating main database...\r\n"
bin/console doctrine:database:create

# Make migrations
echo "Executing migrations...\r\n"
bin/console doctrine:migrations:migrate

# Load fixtures
echo "Loading fixtures...\r\n"
bin/console doctrine:fixtures:load --append

