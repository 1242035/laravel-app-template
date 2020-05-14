<?php

namespace App\Services;

use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINE\LINEBot\SignatureValidator;

class LineMessage
{

    protected $bot;

    protected $replyToken;

    protected $config;

    const REPLY_MESSAGES = [
        'I sent your message',
        'Your message is sent',
        'Message sent. Thank you for using our service !',
        'Message received. Thank you for using our service',
    ];

    public function __construct()
    {
        $this->config = [
            'channel_access_token' => config('services.line_message.channel_access_token'),
            'channel_secret' => config('services.line_message.channel_secret'),
        ];
        $httpClient = new CurlHTTPClient($this->config['channel_access_token']);
        $this->bot = new LINEBot($httpClient, ['channelSecret' => $this->config['channel_secret']]);
    }

    public function validateSignature($requestBody, $signature)
    {
        if (
            empty($signature) ||
            !SignatureValidator::validateSignature($requestBody, $this->config['channel_secret'], $signature)
        ) {
            return false;
        }
        return true;
    }

    public function replyText($replyToken, $message)
    {
        return $this->bot->replyText($replyToken, $message);
    }

    public function pushMessage($userId, $message)
    {
        return $this->bot->pushMessage($userId, new TextMessageBuilder($message));
    }

    public function getProfile($userId)
    {
        $response = $this->bot->getProfile($userId);
        if ($response->isSucceeded()) {
            return $response->getJSONDecodedBody();;
        }
    }

    public function getImage($message_id)
    {
        return $this->bot->getMessageContent($message_id)->getRawBody();
    }
}
