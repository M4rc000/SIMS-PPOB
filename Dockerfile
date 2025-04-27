FROM php:8.1-cli

# Update dan instal libcurl development
RUN apt-get update && apt-get install -y libcurl4-openssl-dev pkg-config

WORKDIR /app
COPY . /app

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    composer install --no-dev --optimize-autoloader

EXPOSE ${PORT:-8000}

CMD sh -c 'php -S 0.0.0.0:${PORT:-8000} -t public'
