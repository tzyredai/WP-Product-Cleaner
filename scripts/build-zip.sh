#!/usr/bin/env bash
set -euo pipefail
ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
VERSION="$(php -r '$s=file_get_contents($argv[1]); preg_match("/Version:\s*([^\r\n]+)/",$s,$m); echo trim($m[1]);' "$ROOT/wp-product-cleaner.php")"
BUILD="$(mktemp -d)"
trap 'rm -rf "$BUILD"' EXIT
mkdir -p "$BUILD/wp-product-cleaner" "$ROOT/dist"
rsync -a --exclude='.git' --exclude='dist' --exclude='.github' --exclude='scripts' --exclude='developer-tests' --exclude='preview.html' --exclude='CHANGELOG.md' --exclude='SECURITY.md' --exclude='CONTRIBUTING.md' "$ROOT/" "$BUILD/wp-product-cleaner/"
rm -f "$ROOT/dist/wp-product-cleaner-"*.zip
( cd "$BUILD" && zip -qr "$ROOT/dist/wp-product-cleaner-$VERSION.zip" wp-product-cleaner )
echo "Built dist/wp-product-cleaner-$VERSION.zip"
