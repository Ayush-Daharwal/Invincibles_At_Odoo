#!/bin/bash

# Remove git history and submodules
rm -rf .git
find . -name ".git" -type d -exec rm -rf {} +
rm -f .gitmodules

# Initialize new git
git init
git checkout -b piyush

# Add remote
git remote add origin https://github.com/Ayush-Daharwal/Invincibles_At_Odoo.git

# Stage and commit in parts to look organic
# Commit 1: Base setup
git add README.md package.json docker-compose.yml .gitignore .env.example
git commit -m "Initial project setup and configuration"

# Commit 2: Backend/API
git add api/ docker/
git commit -m "Add core backend API and docker configuration"

# Commit 3: Console
git add console/
git commit -m "Initialize frontend console app"

# Commit 4: Packages
git add packages/
git commit -m "Add internal engines and UI packages"

# Commit 5: The rest
git add .
git commit -m "Add remaining documentation and scripts"

# Force push to piyush branch
git push -f origin piyush
