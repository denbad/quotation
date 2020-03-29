# Install project

### Clone git repository
$ git clone git@github.com:denbad/quotation.git quotation

### Change to app dir
$ cd quotation

### Run containers
$ docker-compose up -d --build

### Test php is installed
$ docker exec -it quotation-cli php -v

### Test both mysql servers are running
$ docker exec -it quotation-db mysql -u root -proot -e "SHOW VARIABLES LIKE '%version%'" 

$ docker exec -it quotation-db-test mysql -u root -ptest -e "SHOW VARIABLES LIKE '%version%'"

### Test web server is running
$ curl -I http://localhost:8000/

### Install app dependencies
$ docker exec -it quotation-cli composer install

### Migrate both databases  
$ docker exec -it quotation-cli php bin/console doctrine:migrations:migrate

$ docker exec -it quotation-cli php bin/console doctrine:migrations:migrate --env=test

# Run tests

### Run unit tests
$ docker exec -it quotation-cli php bin/phpunit --testsuite unit

### Run integration tests
$ docker exec -it quotation-cli php bin/phpunit --testsuite command

$ docker exec -it quotation-cli php bin/console quotation:sync --force --env=test && docker exec -it quotation-cli php bin/phpunit --testsuite controller

### Validate coding standards
$ docker exec -it quotation-cli php vendor/bin/php-cs-fixer fix --dry-run --verbose --config=.php_cs.dist App tests

### Run static analysis
$ docker exec -it quotation-cli vendor/bin/phpstan analyse --level max -c phpstan.neon App tests

# Import quotations (currency rates)

### Quotation sync preview
$ docker exec -it quotation-cli php bin/console quotation:sync --dry-run

### Quotation sync
$ docker exec -it quotation-cli php bin/console quotation:sync

### Quotation forced sync
$ docker exec -it quotation-cli php bin/console quotation:sync --force

### Switch to alternative quotation provider
Set default loader in config/packages/app.yaml ('ecb', 'cbr'), or pass manually:

$ docker exec -it quotation-cli php bin/console quotation:sync --loader=cbr

$ docker exec -it quotation-cli php bin/console quotation:sync --loader=ecb

### Actual database contents
$ docker exec -it quotation-db mysql -u root -proot -e "SELECT * FROM app.quotation ORDER BY id" 

$ docker exec -it quotation-db-test mysql -u root -ptest -e "SELECT * FROM app.quotation ORDER BY id"

# REST api

### Conversion malformed request 1
$ curl http://localhost:8000/convert/eurusd/

### Conversion malformed request 2
$ curl http://localhost:8000/convert/eurusd/?nominal=aaa

### Conversion not supported example
$ curl http://localhost:8000/convert/xxxzzz/?nominal=10

### Base conversion 10 eur to rub
$ curl http://localhost:8000/convert/eurrub/?nominal=10

### Base conversion 100 rub to eur
$ curl http://localhost:8000/convert/rubeur/?nominal=100

### Cross conversion 200 rub to gbp
$ curl http://localhost:8000/convert/rubgbp/?nominal=200


