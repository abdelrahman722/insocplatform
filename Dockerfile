# المرحلة 1: بناء التطبيق
FROM php:8.3-fpm AS build

# تثبيت التبعيات الأساسية
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    build-essential \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libwebp-dev \
    libxslt1-dev \
    && docker-php-ext-configure gd \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# تثبيت Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# إعداد العمل
WORKDIR /var/www/html

# نسخ ملفات المشروع
COPY . .

# تثبيت التبعيات
RUN composer install --no-dev --optimize-autoloader

# توليد مفتاح التطبيق
RUN php artisan key:generate --force

# تشغيل الترحيلات
RUN php artisan migrate --force

# المرحلة 2: تشغيل التطبيق
FROM php:8.3-fpm

# تثبيت التمديدات
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# إعداد العمل
WORKDIR /var/www/html

# نسخ الملفات من مرحلة البناء
COPY --from=build /var/www/html /var/www/html

# إعداد الصلاحيات
RUN chown -R www-data:www-data \
    storage \
    bootstrap/cache

# فتح المنفذ
EXPOSE 8000

# تشغيل الخادم
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]