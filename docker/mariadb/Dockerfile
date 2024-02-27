FROM mariadb

COPY database/setup.sql /docker-entrypoint-initdb.d/

CMD ["--init-file", "/docker-entrypoint-initdb.d/setup.sql"]
