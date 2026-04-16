FROM php:8.2-apache

# Enable mysqli extension
RUN docker-php-ext-install mysqli

# Copy app code into Apache's web root
COPY app/ /var/www/html/

# Apache listens on 80 inside the container
EXPOSE 80
