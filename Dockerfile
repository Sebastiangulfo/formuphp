FROM php:8.2-cli

# Extensión para conectar a MySQL con PDO
RUN docker-php-ext-install pdo pdo_mysql

WORKDIR /var/www/html
COPY . /var/www/html/

EXPOSE 8080

# Servidor web integrado de PHP escuchando en el puerto de Railway ($PORT).
# Evita Apache por completo (y su error "More than one MPM loaded").
CMD ["sh", "-c", "php -S 0.0.0.0:${PORT:-8080} -t /var/www/html"]
