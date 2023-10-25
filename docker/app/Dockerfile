FROM php:8.0.29-fpm

EXPOSE 5173
ENV TZ Asia/Tokyo

# php.iniの保存場所は、php infoの「Loaded Configuration File項目」で確認できる
COPY ./docker/app/php.ini /usr/local/etc/php/php.ini
COPY ./docker/app/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

# Composerをマルチステージビルドでインストールする。
# マルチステージビルドとはイメージを利用して、最終的なイメージを作成すること。
# マルチステージビルドでインストールするとイメージサイズが小さくなる。
COPY --from=composer:2.0 /usr/bin/composer /usr/bin/composer

# Vue.jsを使うため、Node.jsをマルチステージビルドでインストールする。
# Node.jsにはnpmというパッケージ管理システムが入っており、Vue.jsプロジェクトで使う。
COPY --from=node:18.16.1 /usr/local/bin /usr/local/bin
COPY --from=node:18.16.1 /usr/local/lib /usr/local/lib

# アップデート可能なパッケージがあるかリポジトリ（外部サーバー）に問い合わせ、
# パッケージリスト（/etc/apt/sources.list）を更新する。
# 更新したパッケージリストを元に、パッケージをインストールする。
RUN apt-get update \
    && apt-get -y install \
    zip \
    unzip \
    vim \
    # 拡張パッケージ「intl」をインストールするには「libicu-dev」をインストールする必要がある
    libicu-dev \
    # テストで画像ファイルを生成するため、GDライブラリ関連のパッケージをインストール
    zlib1g-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    && docker-php-ext-configure \
    # GDライブラリでJPEGファイルを扱えるようにする。PNGファイルはデフォルトで扱えるため設定不要。
    gd --with-jpeg \
    # 「docker-php-ext-install」はPHPイメージファイルに標準で備わっている拡張パッケージをインストール、
    # 有効化するので有効化コマンドは不要。
    # 「docker-php-ext-install」はPHP FPM用のコマンド。
    && docker-php-ext-install \
    pdo_mysql \
    gd \
    # メールアドレスのバリデーションで使用する
    intl \
    # 「pecl」はC言語で書かれたパッケージをインストールする。
    # パッケージをインストール後は、「docker-php-ext-enable」で有効にする。
    && pecl install \
    xdebug-3.1.6 \
    && docker-php-ext-enable \
    xdebug

# コンテナに入った際のカレントディレクトリを指定する
WORKDIR /var/www/html