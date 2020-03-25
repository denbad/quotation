##### Clone git repository
$ git clone url quotation

##### Change to app dir
$ cd quotation

##### Run containers
$ docker-compose up -d --build

##### Install app dependencies
$ docker exec -it quotation-cli composer install

##### Test mysql server is running
$ mysql -u root -h 127.0.0.1 -P13306 -proot

##### Preview response from quotation rate provider
$ docker exec -it quotation-cli php bin/console quotation:sync --dry-run

##### Quotations sync
$ docker exec -it quotation-cli php bin/console quotation:sync

##### Quotations forced sync
$ docker exec -it quotation-cli php bin/console quotation:sync --force

##### Actual database contents
$ docker exec -it quotation-db mysql -u root -proot -e "SELECT * FROM app.quotation ORDER BY code" 

##### Switch to alternative quotation provider
Edit config/packages/app.yaml ('ecb' or 'cbr')

##### Run static analysis
$ docker exec -it quotation-cli 

##### Run unit tests
$ docker exec -it quotation-cli 

##### Run integration tests
$ docker exec -it quotation-cli 

##### Conversion example 1
$ curl  

##### Conversion example 2
$ curl

##### Conversion example 3
$ curl 
