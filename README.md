# AdabApi
API platform for *[Adab](https://adab.ga/)* project

<p align="center">
    <a href="https://adab.ga/" target="_blank" rel="noopener noreferrer">
        <img width="100" src="https://adab.ga/_nuxt/assets/images/adab-logo.svg" alt="Vue logo">
    </a>
</p>

****
- [Adab](https://adabapi.ga/) - Education portal
- [AdabApi](https://adabapi.ga/) - My api platform (Symfony 5 - REST API)
- [phpMyAdmin](https://adabapi.ga/phpmyadmin/) - For [AdabApi](https://adabapi.ga/)


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

# Demo API platform (it's awesome)
<p align="center">
    <img src="https://raw.githubusercontent.com/shamil8/adab-api/master/public/api-platform.png" alt="VarX image">
</p>