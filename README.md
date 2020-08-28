# laravel-template

## 目標

- Laravel が動く環境を docker で作る
- `docker-compose up -d` したら、初期設計済みの Laravel でコードを書き始められる状態になる

### 初期設計パターン

- シンプルな設計パターン (フレームワークの機能をそのまま使う)
- Clean Architecture 的なパターン (CQRS など)

## 構成

- Nginx (Web サーバ)
- PHP-FPM (PHP の実行環境)
- MySQL (RDBMS)
- phpMyAdmin

## 技術要素

- Laravel 7.x
    - https://readouble.com/laravel/7.x/ja/installation.html

## ディレクトリ構成

```
.
├── docker => 各コンテナの設定ファイル
│   ├── nginx
│   │   ├── Dockerfile
│   │   └── config
│   │       └── default.conf
│   └── php-fpm
│       ├── Dockerfile
│       └── config
│           └── php.ini
├── docker-compose.local.yml
├── docker-compose.yml
├── logs => 各種ログファイル
├── src => Laravelプロジェクトをインストールするディレクトリ
├── .env
├── .gitignore
├── .docker-composer.yml
└── README.md
```


## 構築方法

### 前準備 (初回のみ)

```
// データベースのデータ保存用ボリュームを作成
$ docker volume create --name laravel-template-database-data

// イメージのビルド
$ docker-compose build

// (Dockerfile を変更した場合は再ビルド)
$ docker-compose build --no-cache
```

### コンテナの起動

```
// リポジトリのclone
$ git clone git@github.com:tamurayk/laravel-template.git

// 開発環境の起動
$ cd laravel-template
$ docker-compose up -d

// (php-fpm コンテナに入る)
$ docker exec -it php-fpm /bin/ash
```

- http://localhost:8000/ で Laravel の Web アプリにアクセスできます

### `Application Key` の作成

```
$ cp .env.example .env
$ docker exec php-fpm php artisan key:generate
```

### migration

```
$ docker exec php-fpm php artisan migrate
```

### 開発時に phpMyAdmin を利用する

下記のように開発環境を起動すると http://localhost:8080/ で phpMyAdmin にアクセスできます

```
$ docker-compose -f docker-compose.yml -f docker-compose.local.yml up -d
```

## スコープ外

- サンプルアプリ
- CD/CI

## note

```
// Laravel インストール
composer create-project --prefer-dist laravel/laravel <ProjectName>
```
