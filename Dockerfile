# Dockerfile para una aplicación PHP 8.1 con Apache
FROM php:8.1-apache

# Copia tu código fuente a la ubicación deseada en la imagen
#COPY . /var/www/html

# Establece el directorio de trabajo
WORKDIR /var/www/html

# Instala las bibliotecas comunes de PHP
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libzip-dev \
    libfreetype6-dev \
    libapache2-mod-fcgid \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
    mysqli \
    pdo \
    pdo_mysql \
    ctype \
    zip \
    gd \
    exif \
    bcmath \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /var/cache/apt/archives/*

# Habilita el módulo de Apache mod_rewrite
RUN a2enmod rewrite

# Asignar permisos de usuario y grupo a la carpeta /var/www/html
RUN chown -R www-data:www-data /var/www/html

RUN chmod -R 755 /var/www/html

# Desactivar mensajes de deprecated
RUN echo "error_reporting = E_ALL & ~E_DEPRECATED & ~E_NOTICE" > /usr/local/etc/php/php.ini

# Exponer el puerto 80
EXPOSE 80

# Colocar el tiempo de la zona horaria en America/Costa_Rica
ENV TZ=America/Costa_Rica

# Ejecutar el comando para actualizar la zona horaria
RUN ln -fs /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# Comando para ejecutar Apache en segundo plano
CMD ["apache2-foreground"]