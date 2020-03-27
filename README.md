# Install project

### Clone git repository
$ git clone git@github.com:denbad/quotation.git quotation

### Change to app dir
$ cd quotation

### Run containers
$ docker-compose up -d --build

### Test php is installed
$ docker exec -it quotation-cli php -v

### Test mysql server is running
$ docker exec -it quotation-db mysql -u root -proot -e "SHOW VARIABLES LIKE \"%version%\"" 

### Test web server is running
$ curl -I http://localhost:8000/

### Install app dependencies
$ docker exec -it quotation-cli composer install

### Migrate database
$ docker exec -it quotation-cli php bin/console doctrine:migrations:migrate

$ docker exec -it quotation-cli php bin/console doctrine:migrations:migrate --env=test

# Usage

### Quotation sync preview
$ docker exec -it quotation-cli php bin/console quotation:sync --dry-run

### Quotation sync
$ docker exec -it quotation-cli php bin/console quotation:sync

### Quotation forced sync
$ docker exec -it quotation-cli php bin/console quotation:sync --force

### Actual dev database contents
$ docker exec -it quotation-db mysql -u root -proot -e "SELECT * FROM app.quotation ORDER BY id" 

$ docker exec -it quotation-db-test mysql -u root -ptest -e "SELECT * FROM app.quotation ORDER BY id"

### Switch to alternative quotation provider
Edit config/packages/app.yaml ('ecb' or 'cbr')

### Conversion malformed request 1
$ curl http://localhost:8000/convert/eurusd/

### Conversion malformed request 2
$ curl http://localhost:8000/convert/eurusd/?nominal=aaa

### Conversion not supported example
$ curl http://localhost:8000/convert/xxxzzz/?nominal=10

### Conversion 10 eur to rub
$ curl http://localhost:8000/convert/eurrub/?nominal=10

### Conversion 100 rub to eur
$ curl http://localhost:8000/convert/rubeur/?nominal=100

### Conversion 1 xdr to uzs
$ curl http://localhost:8000/convert/xdruzs/?nominal=1

### Run static analysis
$ docker exec -it quotation-cli vendor/bin/phpstan analyse App tests --level max -c phpstan.neon

### Run unit tests
$ docker exec -it quotation-cli php bin/phpunit --testsuite unit

### Run integration tests against test database
$ docker exec -it quotation-cli php bin/phpunit --testsuite integration


