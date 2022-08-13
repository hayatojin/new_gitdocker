version: '3.9'

volumes:
  db-store:
  maildir: {}

services:
  app:
    build: ./infra/php
    volumes:
      - ./src:/data

  web:
    image: nginx:1.20-alpine
    ports:
      - 8080:80
    volumes:
      - ./src:/data
      - ./infra/nginx/default.conf:/etc/nginx/conf.d/default.conf
    working_dir: /data

  db:
    build: ./infra/mysql
    volumes:
      - db-store:/var/lib/mysql
    ports:
      - 3306:3306

  mail:
    image: mailhog/mailhog
    container_name: mailhog
    ports:
      - "8025:8025"
    environment:
      MH_STORAGE: maildir
      MH_MAILDIR_PATH: /tmp

    volumes:
      - maildir:/tmp