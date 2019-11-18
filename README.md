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
  --- connect.php (работа с БД) \
  -- rest \
  --- api.php (работа rest)
  --- contactsApi.php (реализация rest для работы с контактами) \
  -- views \
  --- layout (шаблон приложения) \
  --- create.php (пример view страницы) \
  -- app.php (autoload) \
 - resources (js, css)
 - index.php (точка входа для rest request)
 - add.php (пример web interface страницы)
## Demo
- Список контактов http://contacts.birdweb.ru/contacts/
- Поиск контакта http://contacts.birdweb.ru/contacts/?phone=7773213326
- Добавление контакта web интерфейс http://contacts.birdweb.ru/add.php
- Добавление контакта post data http://contacts.birdweb.ru/contacts/ (POST)
