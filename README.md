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
│   ├── mysql
│   │   └── my.cnf
│   ├── nginx
│   │   └── default.conf
│   └── php-fpm
│       ├── Dockerfile
│       └── php.ini
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

/// イメージのビルド
$ docker-compose build
```

### コンテナの起動

```
// リポジトリのclone
$ git clone git@github.com:tamurayk/laravel-template.git

// 開発環境の起動
$ cd laravel-template
$ docker-compose up -d
```

### `Application Key` の作成

```
$ cp .env.example .env
$ docker exec php-fpm php artisan key:generate
```

### migration

```
$ docker exec php-fpm php artisan migrate
```

## スコープ外

- サンプルアプリ
- CD/CI
