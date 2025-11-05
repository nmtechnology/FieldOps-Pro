#!/bin/sh
# Simple health check script for container readiness

# Check if nginx is running
if ! pgrep nginx > /dev/null; then
    echo "nginx is not running"
    exit 1
fi

# Check if php-fpm is running
if ! pgrep php-fpm > /dev/null; then
    echo "php-fpm is not running"
    exit 1
fi

# Check if the health endpoint responds
if command -v curl > /dev/null; then
    if ! curl -sf http://localhost:8080/health > /dev/null; then
        echo "Health endpoint not responding"
        exit 1
    fi
else
    # Fallback to wget if curl not available
    if ! wget -q -O- http://localhost:8080/health > /dev/null; then
        echo "Health endpoint not responding"
        exit 1
    fi
fi

echo "Health check passed"
exit 0
