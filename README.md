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

- Laravel 6.x
    - LTS の 6.x を選定

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

### ディレクトリ構成 (Laravel)

```
./src/
├── app => アプリケーションのコアコード ※別途記載
├── bootstrap
    ├── app.php => フレームワークの初期処理
    └── cache => ルートやサービスのキャッシュファイル
├── config
    ├── app.php
    ├── auth.php
    ├── broadcasting.php
    ├── cache.php
    ├── cors.php
    ├── database.php
    ├── filesystems.php
    ├── hashing.php
    ├── logging.php
    ├── mail.php
    ├── queue.php
    ├── services.php
    ├── session.php
    └── view.php
├── database
    ├── factories
    ├── migrations
    └── seeds
├── public
    ├── index.php => 全リクエストの入り口。オートローディングを設定。
    ├── css => assets
    ├── img => assets
    └── js => assets
├── resources
    ├── views => Blade ファイル群
    ├── js => assets の元ファイル
    ├── lang => assets の元ファイル
    └── sass => assets の元ファイル
├── routes
    ├── api.php => REST API(ステートレス) 用の Route群(RouteServiceProvider の api ミドルウェアグループに属するルート)。トークン認証。
    ├── channels.php
    ├── console.php
    └── web.php => RouteServiceProvider の web ミドルウェアグループに属するルート。ステートフル。セッションで認証。
├── storage
    ├── app => アプリケーションにより生成されるファイルを保存
    ├── framework => フレームワークが生成するファイルやキャッシュ
    └── logs
├── tests => PHPUnit
├── vendor => Composerによる依存パッケージ群
├── server.php
├── artisan
├── composer.json
└── package.json
```

```
./src/app/
    ├── Console => カスタム Artisan コマンド群
    ├── Entities
        ├── Constants
        ├── Contracts
        └── Eloquents => Eloquent モデル群
    ├── Exceptions
    ├── Http
        ├── Controllers
            ├── Api => for API
            ├── TaskController.php => for Web
            └── Controller.php
        ├── Kernel.php
        ├── Middleware
        ├── Requests => formRequest 群
            ├── Contracts => interface
            │   ├── FormRequest.php
            │   └── Task
            │       └── TaskStoreRequest.php
            └── Task
                └── TaskStoreRequest.php => `php artisan make:request` で作成
        ├── UseCases => ビジネスロジック群
            ├── contract => Interface 群
            ├── Task
                ├── CreateTaskUseCase.php
                └── DeleteTaskUseCase.php
    ├── Helpers
    ├── Policies => 認可ポリシー群。 `php artisan make:policy` で作成
    ├── Providers => サービスプロバイダー群
    └── Rules => カスタムバリデーションルール群

// 下記は必要に応じて追加
./src/app/
    ├── Event => イベント群。`php artisan make:event` で作成
    ├── Listeners => イベントリスナ群。`php artisan make:listener` で作成
    ├── Jobs => Queue 投入可能な Job 群。`php artisan make:job` で作成
    ├── Mail => `php artisan make:mail` で作成
    ├── Notifications => `php artisan make:notification` で作成
    └── Broadcasting => WebSocket接続経由でのイベントの Broadcast(=サーバサイド/クライアントサイドのJavaScriptで同じ名前のイベントを共有) `php artisan make:channel` で作成

// シンプルなパターンでは使用しない
./src/app/
    ├── Repositories => リポジトリパターン採用時に使用
    ├── Services
        ├── XxxService => 各種サービスレイヤ実装時に使用
        ├── Commands => CQRS パターン採用時に使用
        └── Queries => CQRS パターン採用時に使用
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
// 6.x の最新版をインストール
# composer create-project laravel/laravel /srv --prefer-dist "^6.0"

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

