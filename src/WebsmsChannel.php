<?php

namespace LaravelTool\LaravelWebsmsRu;

use Exception;
use Illuminate\Notifications\Notification;

class WebsmsChannel
{

    protected string $channelName = 'websms_ru';

    public function __construct(
        protected ?string $username,
        protected ?string $password,
        protected bool $testMode,
        protected ?string $defaultSender
    ) {

    }

    /**
     * @param $notifiable
     * @param  Notification  $notification
     * @return void
     * @throws Exception
     */
    public function send($notifiable, Notification $notification): void
    {
        if (!$this->username || !$this->password) {
            return;
        }

        $to = $notifiable->websms ?? null;
        $routeTo = $notifiable->routeNotificationFor('sms', $notification);
        if ($routeTo) {
            $to = $routeTo;
        }
        $message = $notification->toSms($notifiable);

        $service = new WebsmsService($this->username, $this->password, $this->testMode);
        $service->send(
            $to,
            $message,
            $this->defaultSender,
        );
    }
}
