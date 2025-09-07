# Dockerfile
FROM php:8.1-apache

# تثبيت التبعيات
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    libonig-dev \
    libzip-dev

# تفعيل التمديدات
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# تثبيت Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# إعداد العمل
WORKDIR /var/www/html

# نسخ الملفات
COPY . .

# تثبيت التبعيات
RUN composer install --no-dev --optimize-autoloader

# توليد مفتاح التطبيق
RUN php artisan key:generate

# إعداد الصلاحيات
RUN chown -R www-data:www-data \
    storage \
    bootstrap/cache

# تكوين Apache
RUN a2enmod rewrite
COPY ./.htaccess /var/www/html/.htaccess

# فتح المنفذ
EXPOSE 8080

# تشغيل الخادم
CMD ["apache2-foreground"]