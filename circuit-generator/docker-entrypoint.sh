#!/bin/sh
set -e

# Install production dependencies
npm ci --omit=dev

# Initialize database file if missing
if [ ! -f database.json ]; then
  echo '{"collection": {}}' > database.json
fi

# Build CSS assets
npm run build:css

exec node src/server.js
