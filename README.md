# adab-api *(adab API)*
API platform for *adab* project

#### Deploy project

###### __Update composer__
```bash
composer self-update

```

###### __Install dependencies composer__
```bash
composer install

```

###### __Create database__
```bash
php bin/console doctrine:database:create

```

###### __Make migrations__
```bash
php bin/console doctrine:migrations:migrate

```
###### __Load fixtures__
```bash
php bin/console doctrine:fixtures:load --append

```

Curl Example
```
curl -k -X POST -H "Content-Type: application/json" -d "{\"email\":\"admin@adab.tj\", \"password\":\"admin\"}" https://127.0.0.1:8000/api/login_check

curl -k -X GET http://127.0.0.1:8000/api/poems -H "Authorization: BEARER <your_token>"

```
