<?php

namespace LaravelTool\LaravelWebsmsRu;

use Exception;
use Http;

class WebsmsService
{
    const BASE_URL = 'http://smpp3.websms.ru:8787/';

    public function __construct(
        protected string $username,
        protected string $password,
    ) {

    }

    /**
     * @param  string  $phone
     * @param  string  $message
     * @param  string|null  $from
     * @return string
     * @throws Exception
     */
    public function send(string $phone, string $message, ?string $from = null): string
    {
        $query = [
            'message' => $message,
            'tel_list' => Normalize::phone($phone),
        ];
        if (!is_null($from)) {
            $query['from'] = $from;
        }
        $response = $this->request('send', $query);

        return $response['systemId'];
    }

    /**
     * @param  string  $endpoint
     * @param  array  $query
     * @return array
     * @throws Exception
     */
    protected function request(string $endpoint, array $query): array
    {
        $query['login'] = $this->username;
        $query['pass'] = $this->password;
        $response = Http::asJson()->acceptJson()->post(self::BASE_URL.$endpoint, $query);
        if ($response->failed()) {
            throw new Exception(__('Response status code: :code', ['code' => $response->status()]));
        }
        $data = $response->json();
        if (!empty($data['errcode'])) {
            throw new Exception(__('Error :code: :msg', [
                'code' => $data['errcode'],
                'msg' => $data['error'],
            ]));
        }
        return $data;
    }
}
