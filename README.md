# REST Api
## Пример реализации rest на php
Возможности api:
- Посмотр списка контактов 
- Возможность поиска контакта по номеру телефона
- Добавлеия контакта списком
- Проверка валидности введенных данных
- Запрет на добавления контакта чаще чем раз в сутки
## Структура
 
 - app \
  -- db \
  --- connect.php _(работа с БД)_ \
  -- rest \
  --- api.php _(работа rest)_
  --- contactsApi.php _(реализация rest для работы с контактами)_ \
  -- views \
  --- layout _(шаблон приложения)_ \
  --- create.php _(пример view страницы)_ \
  -- app.php _(autoload)_ \
 - resources _(js, css)_
 - index.php _(точка входа для rest request)_
 - add.php _(пример web interface страницы)_
## Demo
- Список контактов http://contacts.birdweb.ru/contacts/
- Поиск контакта http://contacts.birdweb.ru/contacts/?phone=7773213326
- Добавление контакта web интерфейс http://contacts.birdweb.ru/add.php
- Добавление контакта post data http://contacts.birdweb.ru/contacts/ (POST)
