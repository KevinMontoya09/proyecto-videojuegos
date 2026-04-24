# 1. Usamos la imagen oficial de PHP con el servidor Apache incluido 
FROM php:8.2-apache

# 2. Instalamos la extensión mysqli para conectar con la BBDD de AWS 
# Esto es obligatorio según el enunciado para poder usar mysqli desde PHP.
RUN docker-php-ext-install mysqli pdo pdo_mysql

# 3. (Opcional) Habilitamos mod_rewrite para URLs amigables
RUN a2enmod rewrite
