# laravel-template

## 目標

- Laravel が動く環境を docker で作る
- `docker-compose up -d` したら、初期設計済みの Laravel でコードを書き始められる状態になる

### 初期設計パターン

- シンプルな設計パターン
- CQRS パターン

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

## 開発環境

- `docker-compose up -d`

## スコープ外

- サンプルアプリ
- CD/CI
