## Introduction

Docker VS Laravel

## Usage
## Container structure

```bash
├── app
├── nginx
└── mysql
```

### app container

- Base image
  - [php](https://hub.docker.com/_/php):7.4-fpm-buster
  - [composer](https://hub.docker.com/_/composer):1.10

### nginx container

- Base image
  - [nginx](https://hub.docker.com/_/nginx):1.18-alpine
  - [node](https://hub.docker.com/_/node):14.2-alpine

### mysql container

- Base image
  - [mysql](https://hub.docker.com/_/mysql):8.0
