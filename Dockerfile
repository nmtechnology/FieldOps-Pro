FROM richarvey/nginx-php-fpm:3.1.6

# Copy application files
COPY . /var/www/html

# Set working directory
WORKDIR /var/www/html

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

# Install Node and build frontend assets
RUN apk add --no-cache nodejs npm
RUN npm ci --legacy-peer-deps --no-audit
RUN npm run build
RUN rm -rf node_modules

# Set permissions
RUN chown -R nginx:nginx /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Configure nginx
RUN rm -f /etc/nginx/sites-available/default.conf
COPY <<'EOF' /etc/nginx/sites-available/default.conf
server {
    listen 8080;
    server_name _;
    root /var/www/html/public;
    index index.php index.html;
    
    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";
    
    charset utf-8;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }
    
    error_page 404 /index.php;
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
    }
    
    location ~ /\.(?!well-known).* {
        deny all;
    }
}
EOF

# Create start script
RUN cat > /start.sh << 'EOF'
#!/bin/sh
set -e

echo "Running Laravel setup..."
php artisan config:clear
php artisan migrate --force --no-interaction
php artisan storage:link || true
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Starting services..."
/usr/bin/supervisord -n -c /etc/supervisord.conf
EOF

RUN chmod +x /start.sh

EXPOSE 8080

CMD ["/start.sh"]
