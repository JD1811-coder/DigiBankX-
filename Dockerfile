FROM php:8.2-apache

# Install mysqli extension required for TiDB / MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Enable Apache rewrite module
RUN a2enmod rewrite

# 1. Hide server banners and version info on error pages (Finding 01)
RUN echo "ServerTokens Prod" >> /etc/apache2/apache2.conf \
    && echo "ServerSignature Off" >> /etc/apache2/apache2.conf

# 2. Allow Apache to serve directory indexes and prevent 403 Forbidden (Finding 03)
RUN echo "DirectoryIndex index.php pages_client_index.php index.html" >> /etc/apache2/apache2.conf

# 3. Grant directory access inside /var/www/html
RUN echo '<Directory /var/www/html/>\n\
    Options -Indexes +FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' >> /etc/apache2/apache2.conf

# Copy all project files into Apache web root
COPY . /var/www/html/

# Configure Apache to listen on Render's dynamic $PORT or default to 80
RUN sed -i 's/80/${PORT}/g' /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf

EXPOSE 80

CMD ["apache2-foreground"]
