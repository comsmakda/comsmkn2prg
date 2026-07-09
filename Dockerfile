FROM php:8.2-apache

# curl diperlukan untuk komunikasi PHP -> Sync Agent (push user, pull log fingerprint)
RUN apt-get update \
    && apt-get install -y --no-install-recommends libcurl4-openssl-dev \
    && docker-php-ext-install mysqli pdo pdo_mysql curl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Timezone WITA (Pinrang, Sulawesi Selatan) - penting untuk akurasi jam masuk/pulang di rekap fingerprint
RUN ln -snf /usr/share/zoneinfo/Asia/Makassar /etc/localtime \
    && echo "Asia/Makassar" > /etc/timezone
RUN echo "date.timezone = Asia/Makassar" > /usr/local/etc/php/conf.d/timezone.ini

RUN a2enmod rewrite headers

RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

COPY . /var/www/html/

RUN chown -R www-data:www-data /var/www/html

EXPOSE 80