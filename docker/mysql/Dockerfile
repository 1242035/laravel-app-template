FROM mysql:8.0

ENV TZ=UTC \
  MYSQL_DATABASE=app_db \
  MYSQL_USER=app_user \
  MYSQL_PASSWORD=app_secret \
  MYSQL_ROOT_PASSWORD=app_secret

COPY ./my.cnf /etc/my.cnf
