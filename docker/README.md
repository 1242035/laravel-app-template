## Introduction

Docker VS Laravel

## Usage
```bash
$ git clone https://rea-fun@bitbucket.org/reafun/ishin__callcenter-g.git
$ cd ishin__callcenter-g/infrastructure
$ make init
```
動作確認
URL: http://127.0.0.1

開発ディレクトリー
```bash
$ cd ~ishin__callcenter-g/laravel
$ git checkout -b feature/yyyymm/自分の名前/シャープ課題番号
```
## Comands
環境のアップデート(composer update && npm install && npm run dev)
```bash
~infrastructure $ make update
```

yarnインストール
```bash
~infrastructure $ make yarn
```

yarn dev
```bash
~infrastructure $ make yarn-dev
```

yarn watch-poll
```bash
~infrastructure $ make yarn-watch-poll
```

DBのrefresh(php artisan refresh --seed)
```bash
~infrastructure $ make refresh
```

DBの作成し直し(php artisan fresh --seed)
```bash
~infrastructure $ make fresh
```

Dockerコンテナの停止
```bash
~infrastructure $ make stop
```


Dockerコンテナの起動
```bash
~infrastructure $ make start
```

Dockerコンテナの停止と削除
```bash
~infrastructure $ make down
```

※詳しくは infrastructure/Makefileを参照

## Container structure

```bash
├── app
├── web
└── db
```

### app container

- Base image
  - [php](https://hub.docker.com/_/php):7.4-fpm-buster
  - [composer](https://hub.docker.com/_/composer):1.10

### web container

- Base image
  - [nginx](https://hub.docker.com/_/nginx):1.18-alpine
  - [node](https://hub.docker.com/_/node):14.2-alpine

### db container

- Base image
  - [mysql](https://hub.docker.com/_/mysql):8.0
