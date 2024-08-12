# Dockerfile para una aplicación PHP 8.1 con Apache
FROM php:8.1-apache

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

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copia tu código fuente a la ubicación deseada en la imagen
COPY . /var/www/html

# Asignar permisos de usuario y grupo a la carpeta /var/www/html
RUN chown -R www-data:www-data /var/www/html

# Asignar permisos de lectura, escritura y ejecución a la carpeta /var/www/html
RUN chmod -R 755 /var/www/html

# Colocar la zona horaria en America/Costa_Rica
RUN echo "date.timezone = America/Costa_Rica" > /usr/local/etc/php/php.ini

# Ocultar mesajes de error en producción
RUN echo "display_errors = On" >> /usr/local/etc/php/php.ini
RUN echo "display_startup_errors = Off" >> /usr/local/etc/php/php.ini
RUN echo "error_reporting = E_ALL & ~E_DEPRECATED & E_STRICT" >> /usr/local/etc/php/php.ini

# Exponer el puerto 80
EXPOSE 80

# Comando para ejecutar Apache en segundo plano
CMD ["apache2-foreground"]
