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

### Laravel 再インストール

```
// Laravel 再インストール
$ docker exec -it php-fpm /bin/ash
# rm -rf /srv/* /srv/.*
# composer create-project --prefer-dist laravel/laravel .

$ docker volume rm laravel-template-database-data
$ docker volume create --name laravel-template-database-data

$ cp examples/laravel-basic-task-list/.env.example src/.env.example
$ cp src/.env.example src/.env
$ docker exec php-fpm php artisan key:generate
$ docker exec php-fpm php artisan migrate
```

### model

- Laravel のデフォルトでは意図的に `models` ディレクトリが用意されない
  - Eloquent モデルの格納場所は、開発者自身で選択する、という思想
  - デフォルトでは `app` ディレクトリ下へ設置される
- ドキュメント
  - https://readouble.com/laravel/7.x/en/structure.html#introduction


### `public/js/app.js`

```
// js ファイルを更新したら、下記のコマンドにて `public/js/app.js` を再生
// See: https://laravel.com/docs/7.x/frontend#writing-css
$ yarn yun dev
```

- note
    - `docker-compose.yml` にて、ホストOS側の `src/app/public` を nginx コンテナの `/srv/app/public` にコピーしている


css が 404 になる問題を解消する為に、
ホストOS側の `src/app/public` を nginx コンテナの `/srv/app/public` にコピーするようにした。

