# Инструкция по запуску

```shell
git clone https://github.com/eldargasanov1/secunda.git
cd secunda
cp .env.example .env
docker run --rm -it -v "$PWD":/app -u $(id -u):$(id -g) composer sh -c "composer install"
./vendor/bin/sail up -d
./vendor/bin/sail artisan migrate
./vendor/bin/sail artisan db:seed
# Готово
```
