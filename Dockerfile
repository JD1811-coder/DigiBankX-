FROM php:8.2-apache

# Install mysqli extension required for TiDB / MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Enable Apache rewrite module
RUN a2enmod rewrite

# Match XAMPP's output buffering to prevent "headers already sent"
RUN echo "output_buffering = 4096" >> /usr/local/etc/php/conf.d/docker-php-ext-output-buffering.ini

# Hide server signatures and prevent 403 Forbidden
RUN echo "ServerTokens Prod" >> /etc/apache2/apache2.conf \
    && echo "ServerSignature Off" >> /etc/apache2/apache2.conf \
    && echo "DirectoryIndex index.php pages_client_index.php index.html" >> /etc/apache2/apache2.conf

RUN echo '<Directory /var/www/html/>\n\
    Options -Indexes +FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' >> /etc/apache2/apache2.conf

COPY . /var/www/html/

RUN sed -i 's/80/${PORT}/g' /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf

EXPOSE 80

CMD ["apache2-foreground"]
