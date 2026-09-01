FROM php:8.2-cli

# Extension para conectar a MySQL
RUN docker-php-ext-install mysqli

WORKDIR /var/www/html
COPY . /var/www/html/

EXPOSE 8080

# Servidor web integrado de PHP en el puerto de Railway ($PORT)
CMD ["sh", "-c", "php -S 0.0.0.0:${PORT:-8080} -t /var/www/html"]
