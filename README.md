# Laravel WebSMS.ru Notification Channel
## Installation
```bash
composer require laravel-tool/laravel-websms-ru
```
## Configuration

1. ```php
    return [
        'username' => env('WEBSMS_RU_USERNAME'),
        'password' => env('WEBSMS_RU_PASSWORD'),
        'test_mode' => env('WEBSMS_RU_TEST_MODE', false),
        'default_sender' => env('WEBSMS_RU_DEFAULT_SENDER'),
    ];
    ```
2. Add to notifiable model:
    ```php
    public function routeNotificationForSms($notification): string
    {
        return $this->phone;
    }
    ```
3. Add to notification channel "websms_ru":
   ```php
    public function via($notifiable)
    {
        return ['websms_ru'];
    }
   ```