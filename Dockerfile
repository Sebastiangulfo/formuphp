FROM php:8.2-apache

# Extensión para conectar a MySQL con PDO
RUN docker-php-ext-install pdo pdo_mysql

# PHP (mod_php) requiere el MPM prefork. Nos aseguramos de que sea el único
# activo para evitar el error "More than one MPM loaded".
RUN a2dismod mpm_event  2>/dev/null || true; \
    a2dismod mpm_worker 2>/dev/null || true; \
    a2enmod  mpm_prefork

# Copia la app al directorio que sirve Apache
COPY . /var/www/html/

# Apache escuchará en el puerto que indique la variable APACHE_LISTEN_PORT.
RUN sed -i 's/Listen 80/Listen ${APACHE_LISTEN_PORT}/' /etc/apache2/ports.conf \
 && sed -i 's/:80>/:${APACHE_LISTEN_PORT}>/'          /etc/apache2/sites-available/000-default.conf

# Railway asigna el puerto en $PORT; lo pasamos a Apache (8080 por defecto en local).
CMD ["sh", "-c", "export APACHE_LISTEN_PORT=${PORT:-8080}; apache2-foreground"]
