#!/usr/bin/env bash
#
# Makes the smaller WebP copies that <x-img> offers in srcset.
#
# For every JPEG or PNG under the folders given (default: the hero, proof
# and card image folders), writes name-w640.webp and name-w1024.webp next
# to it when the source is wide enough to need them. Existing copies are
# left alone, so it is safe to re-run after adding images.
#
#   scripts/make-image-variants.sh                 # default folders
#   scripts/make-image-variants.sh public/assets/x # one folder
#
# Needs cwebp (brew install webp). sips ships with macOS.

set -euo pipefail
cd "$(dirname "$0")/.."

dirs=("$@")
if [ ${#dirs[@]} -eq 0 ]; then
  dirs=(public/assets/photos public/assets/proof public/assets/storefront
        public/assets/a-plus-content public/assets/ppc-management
        public/assets/keyword-research public/assets/account-health
        public/assets/map-enforcement public/assets/case-study-sds
        public/assets/case-study-tubelox)
fi

made=0
for dir in "${dirs[@]}"; do
  for src in "$dir"/*.jpg "$dir"/*.jpeg "$dir"/*.png; do
    [ -f "$src" ] || continue
    width=$(sips -g pixelWidth "$src" | awk '/pixelWidth/ {print $2}')
    base="${src%.*}"
    for w in 640 1024; do
      out="$base-w$w.webp"
      # Only when the source is meaningfully wider than the copy.
      if [ "$width" -gt $((w + 100)) ] && [ ! -f "$out" ]; then
        cwebp -quiet -q 72 -metadata none -resize "$w" 0 "$src" -o "$out"
        made=$((made + 1))
      fi
    done
  done
done
echo "Made $made image variants."
