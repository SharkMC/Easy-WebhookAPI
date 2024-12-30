<?php

declare(strict_types=1);

namespace webhook;

use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use webhook\WebhookTask;

class Webhook extends PluginBase {

    public static string $webhookUrl = "";
    public static string $title = "Webhook";
    public static string $contents = "Contents";
    public static string $color = "FFFFFF";

    public function onEnable(): void {
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
        $task = new WebhookTask(self::$webhookUrl, self::$title, self::$contents, self::$color);
        Server::getInstance()->getAsyncPool()->submitTask($task);
    }
}
