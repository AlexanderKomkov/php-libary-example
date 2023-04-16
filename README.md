
# Libary Example

Реализцая небольшого CRUD для библитоеки, без использования фреймворков и готовых пакетов, с использованием ООП

## Установка и запуск локально

1. Создаем рабочую директорию и переходим в нее `mkdir ${app} && cd ${app}`
2. Клонируем репозиторий `git clone https://github.com/AlexanderKomkov/php-libary-example.git ./`
3. Выполняем `composer install`
4. Запускаем докер `docker-compose up -d`
5. Импортируем `db_schema/db.sql` в Adminer

## Роутинг

1. Web `routes/web.php`
2. Api `reotes/api.php`