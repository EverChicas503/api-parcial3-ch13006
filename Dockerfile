FROM php:8.2-cli

# Instalar dependencias del sistema y conector de MySQL
RUN apt-get update && apt-get install -y unzip git \
    && docker-php-ext-install pdo pdo_mysql

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Directorio de trabajo
WORKDIR /app

# Copiar todos los archivos de la API
COPY . .

# Instalar las librerías de Slim
RUN composer install

# Exponer el puerto para Render
EXPOSE 10000

# Encender el servidor
CMD php -S 0.0.0.0:10000 -t public