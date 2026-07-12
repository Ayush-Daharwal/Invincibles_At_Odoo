#!/bin/bash
mkdir -p temp_pkgs
cd temp_pkgs

PACKAGES=(
  "ai-engine"
  "dev-engine"
  "fleetops-engine"
  "iam-engine"
  "leaflet-routing-machine"
  "ledger-engine"
  "registry-bridge-engine"
  "valhalla-engine"
  "vroom-engine"
  "intl-lint"
)

for pkg in "${PACKAGES[@]}"; do
  # Check if directory is empty
  if [ -z "$(ls -A ../packages/$pkg 2>/dev/null)" ]; then
    echo "Downloading $pkg because it is empty..."
    npm pack @fleetbase/$pkg
    tar -xzf fleetbase-${pkg}-*.tgz -C ../packages/$pkg --strip-components=1
    rm fleetbase-${pkg}-*.tgz
  fi
done
