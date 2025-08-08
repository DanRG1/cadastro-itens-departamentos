# Imagem base PHP-FPM
FROM php:8.2-fpm

# Define diretório de trabalho
WORKDIR /var/www

# Instala dependências do sistema necessárias para extensões PHP e Laravel
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql zip bcmath opcache \
    && rm -rf /var/lib/apt/lists/*
# Instala o Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copia arquivos do projeto
COPY . .

# Define permissões para o Laravel
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Porta do PHP-FPM
EXPOSE 9000

# Comando de inicialização
CMD ["php-fpm"]
