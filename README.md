# Laravel WebSMS.ru Notification Channel
## Installation
```bash
composer require laravel-tool/laravel-websms-ru
```
## Configuration
```php
return [
    'username' => env('WEBSMS_RU_USERNAME'),
    'password' => env('WEBSMS_RU_PASSWORD'),
    'default_sender' => env('WEBSMS_RU_DEFAULT_SENDER'),
];
```
