<?php

declare(strict_types=1);

namespace webhook;

use pocketmine\plugin\PluginBase;

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
                "embeds" => [
                    [
                        "title" => self::$title,
                        "description" => self::$contents,
                        "color" => hexdec(self::$color)
                    ]
                ]
            ];

            $ch = curl_init(self::$webhookUrl);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
            curl_exec($ch);
            curl_close($ch);
        }
    }
}
