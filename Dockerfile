# Usar variable para versión del Lambda Web Adapter (ajusta si sacan versión más nueva)
ARG LAMBDA_ADAPTER_VERSION=0.9.1

### Etapa base: PHP + Apache ###
FROM php:8.1-apache AS base

# Instalar dependencias de sistema y extensiones PHP necesarias
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libzip-dev \
    libfreetype6-dev \
    libicu-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-configure intl \
    && docker-php-ext-install -j$(nproc) \
        intl \
        mysqli \
        pdo \
        pdo_mysql \
        ctype \
        zip \
        gd \
        exif \
        bcmath \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Habilitar mod_rewrite de Apache
RUN a2enmod rewrite

# Cambiar Apache para que escuche en 8080 (compatible con Web Adapter y no requiere privilegios root extras)
RUN sed -i 's/80/8080/g' /etc/apache2/ports.conf \
    && sed -i 's/:80/:8080/g' /etc/apache2/sites-available/000-default.conf

ENV PORT=8080

# Configuración de PHP: zona horaria y ajustes mínimos de producción
RUN { \
    echo "date.timezone=America/Costa_Rica"; \
    echo "display_errors=Off"; \
    echo "display_startup_errors=Off"; \
    echo "error_reporting=E_ALL & ~E_DEPRECATED & E_STRICT"; \
} > /usr/local/etc/php/conf.d/99-custom.ini

# Directorio de la aplicación
WORKDIR /var/www

# Copiar el código de la aplicación
COPY ./app /var/www

# Instalar Composer y dependencias
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer install --no-dev --prefer-dist --working-dir=/var/www

# Permisos adecuados
RUN chown -R www-data:www-data /var/www

# Asignar permisos de lectura, escritura y ejecución a la carpeta /var/www/html
RUN chmod -R 755 /var/www

### Etapa del adapter: traer el Lambda Web Adapter desde el repositorio público ###
FROM public.ecr.aws/awsguru/aws-lambda-adapter:${LAMBDA_ADAPTER_VERSION} AS adapter

### Imagen final: unir todo ###
FROM base

# Copiar el adapter como extensión (para que Lambda lo ejecute automáticamente)
COPY --from=adapter /lambda-adapter /opt/extensions/lambda-adapter

# Puerto expuesto (no obligatorio en Lambda, útil localmente)
EXPOSE 8080

# Arranca Apache (el Web Adapter se ejecuta como extensión y traduce invocaciones HTTP de Lambda a tu servidor)
CMD ["apache2-foreground"]
