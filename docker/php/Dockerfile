FROM php:8.3-cli-bookworm

ENV TZ=Europe/Minsk
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN apt-get update && \
    apt-get install -y --no-install-recommends \
    git unzip rsync cron openjdk-17-jdk gnupg curl xclip tmux wget jq ca-certificates \
    libicu-dev libpq-dev libzip-dev libfreetype6-dev libjpeg-dev libpng-dev libmagickwand-dev librdkafka-dev libonig-dev \
    libnss3 libxss1 fonts-liberation lsb-release xdg-utils libgbm1 libatk-bridge2.0-0 libgtk-3-0 libasound2 libcups2 \
    libdrm-dev libnspr4 libxcb-dri3-0 libxcomposite1 libxdamage1 libxext6 libxfixes3 libxrandr2 libxtst6 && \
    \
    # Install PHP extensions
    docker-php-ext-install -j$(nproc) intl pdo_mysql zip gd opcache pcntl mbstring exif sockets bcmath && \
    \
    # Install Google Chrome
    CHROME_VERSION=$(curl -s https://googlechromelabs.github.io/chrome-for-testing/last-known-good-versions-with-downloads.json | jq -r '.channels.Stable.version') && \
    CHROME_URL=$(curl -s https://googlechromelabs.github.io/chrome-for-testing/last-known-good-versions-with-downloads.json | jq -r '.channels.Stable.downloads.chrome[] | select(.platform == "linux64") | .url') && \
    mkdir -p /opt/chrome && \
    curl -sSL "$CHROME_URL" -o /tmp/chrome-linux64.zip && \
    unzip /tmp/chrome-linux64.zip -d /opt/chrome && \
    ln -s /opt/chrome/chrome-linux64/chrome /usr/bin/google-chrome && \
    \
    # Install ChromeDriver
    CHROMEDRIVER_URL=$(curl -s https://googlechromelabs.github.io/chrome-for-testing/last-known-good-versions-with-downloads.json | jq -r '.channels.Stable.downloads.chromedriver[] | select(.platform == "linux64") | .url') && \
    mkdir -p /opt/chromedriver && \
    curl -sSL "$CHROMEDRIVER_URL" -o /tmp/chromedriver-linux64.zip && \
    unzip /tmp/chromedriver-linux64.zip -d /opt/chromedriver && \
    ln -s /opt/chromedriver/chromedriver-linux64/chromedriver /usr/bin/chromedriver && \
    \
    # Clean up
    rm -rf /tmp/*.zip && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

COPY ./docker/php/conf.d/php.ini /usr/local/etc/php/conf.d/php.ini

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

WORKDIR /app
COPY . /app

RUN git config --global --add safe.directory /app

RUN echo "10 2,6,10,14,18,22 * * * /usr/local/bin/php /app/app.php >> /var/log/cron.log 2>&1" > /etc/cron.d/app-cron && \
    chmod 0644 /etc/cron.d/app-cron && \
    crontab /etc/cron.d/app-cron && \
    touch /var/log/cron.log

ENTRYPOINT ["/bin/bash", "-c"]

CMD ["printenv > /etc/environment && service cron start && composer install --no-interaction --prefer-dist --optimize-autoloader && tail -f /var/log/cron.log"]