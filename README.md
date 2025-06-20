## Підняти проєкт з нуля

```bash
make up-build
```

Ця команда збудує контейнери. Важливо, щоб порт 80 був доступним, інакше не запрацює Nginx.

У файл `/etc/hosts` потрібно додати:

```
127.0.0.1 frontend.review-system.local
127.0.0.1 api.review-system.local
```

- `frontend.review-system.local` — для перегляду відгуків
- `api.review-system.local` — для API

Далі потрібно ініціалізувати проєкт. Увійти в контейнер CLI:

```bash
make cli
```

Всередині контейнера виконати:


Поставити composer

```bash
composer install
```

Ініціалізувати проєкт

```bash
php init
```

Обрати режим `dev` (ввести `0`), після чого виконати міграції:

```bash
php yii migrate
```

Далі у файлі api/config/params-local.php скопіювати вміст з api/config/params.php:

```bash
<?php
return [
    'origin_url' => ['http://localhost/'],
    'access-token' => '',
];
```
origin_url — поставити правильний домен, на який потрібно надсилати запит, наприклад: ['http://frontend.review-system.local']

access-token — вказати свій токен для можливості надсилання відгуків
