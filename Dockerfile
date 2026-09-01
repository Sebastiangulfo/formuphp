FROM php:8.2-apache

# Extensión para conectar a MySQL con PDO
RUN docker-php-ext-install pdo pdo_mysql

# Copia la app al directorio que sirve Apache
COPY . /var/www/html/

# Railway asigna el puerto en la variable $PORT. Hacemos que Apache escuche ahí.
CMD ["sh", "-c", "sed -i \"s/80/${PORT:-80}/g\" /etc/apache2/ports.conf /etc/apache2/sites-available/000-default.conf && apache2-foreground"]
