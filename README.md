##### Clone git repository
$ git clone url currency-rate

##### Change to app dir
$ cd currency-rate

##### Run containers
$ docker-compose up -d --build

##### Install app dependencies
$ docker exec -it currency-rate-cli composer install

##### Test mysql server is running
$ mysql -u root -h 127.0.0.1 -P13306 -proot

##### Preview response from currency rate provider
$ docker exec -it currency-rate-cli php bin/console currency-rate:sync --dry-run

##### Currency rates sync
$ docker exec -it currency-rate-cli php bin/console currency-rate:sync

##### Currency rates forced sync
$ docker exec -it currency-rate-cli php bin/console currency-rate:sync --force

##### Actual database contents
$ docker exec -it currency-rate-percona mysql -u root -proot -e "select * from app.quotation" 

##### Switch to currency provider alternative currency provider
Edit config/packages/app.yaml ('ecb' or 'cbr')

##### Run static analysis
$ docker exec -it currency-rate-cli 

##### Run unit tests
$ docker exec -it currency-rate-cli 

##### Run integration tests
$ docker exec -it currency-rate-cli 

##### Conversion example 1
$ curl  

##### Conversion example 2
$ curl

##### Conversion example 3
$ curl 
