# Use a imagem oficial do PHP 8.2-fpm como base
FROM php:8.2-fpm

# Argumentos para o usuário e grupo
ARG user
ARG uid

# Instala dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Limpa o cache do apt
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instala extensões do PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd intl
RUN docker-php-ext-enable intl

# Instala o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Cria um usuário do sistema para executar os comandos do composer e da aplicação
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Define o diretório de trabalho
WORKDIR /var/www

# Copia os arquivos da aplicação
COPY . .

# Muda o dono dos arquivos para o usuário da aplicação
RUN chown -R $user:$user /var/www

# Define o usuário
USER $user

# Instala as dependências do Composer
RUN composer install

# Expõe a porta 9000 e inicia o servidor php-fpm
EXPOSE 9000
CMD ["php-fpm"]
