<?php

declare(strict_types=1);

namespace ShqrkMC;

use pocketmine\plugin\PluginBase;
use pocketmine\scheduler\AsyncTask;
use pocketmine\Server;

class Webhook extends PluginBase {

    public static string $webhookUrl;
    public static string $title = "Webhook";
    public static string $contents = "Contents";
    public static string $color = "FFFFFF";

    public function onEnable(): void {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public static function setWebhookUrl(string $webhookUrl): void {
        self::$webhookUrl = $webhookUrl;
    }

    public static function setTitle(string $title): void {
        self::$title = $title;
    }

    public static function setContents(string $contents): void {
        self::$contents = $contents;
    }

    public static function setColor(string $color): void {
        self::$color = $color;
    }

    public static function sendWebhook(): void {
        if (isset(self::$webhookUrl)) {
            $data = [
                "webhookUrl" => self::$webhookUrl,
                "data" => [
                    "embeds" => [
                        [
                            "title" => self::$title,
                            "description" => self::$contents,
                            "color" => hexdec(self::$color)
                        ]
                    ]
                ]
            ];

            Server::getInstance()->getAsyncPool()->submitTask(new WebhookTask($data));
        }
    }
}

class WebhookTask extends AsyncTask {

    private array $data;

    public function __construct(array $data) {
        $this->data = $data;
    }

    public function onRun(): void {
        $webhookUrl = $this->data["webhookUrl"];
        $payload = $this->data["data"];

        $ch = curl_init($webhookUrl);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
        curl_exec($ch);
        curl_close($ch);
    }
}