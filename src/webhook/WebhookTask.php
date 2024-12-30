<?php

declare(strict_types=1);

namespace webhook;

use pocketmine\scheduler\AsyncTask;
use pocketmine\Server;

class WebhookTask extends AsyncTask {

    private string $webhookUrl;
    private string $title;
    private string $contents;
    private string $color;

    public function __construct(string $webhookUrl, string $title, string $contents, string $color) {
        $this->webhookUrl = $webhookUrl;
        $this->title = $title;
        $this->contents = $contents;
        $this->color = $color;
    }

    public function onRun(): void {
        $data = [
            "embeds" => [
                [
                    "title" => $this->title,
                    "description" => $this->contents,
                    "color" => hexdec($this->color)
                ]
            ]
        ];

        $ch = curl_init($this->webhookUrl);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
        $response = curl_exec($ch);
        if ($response === false) {
            $error = curl_error($ch);
            file_put_contents("php://stderr", "CURL Error: $error\n");
        }
        curl_close($ch);
    }
    public function onCompletion(): void { $result = $this->getResult(); }
}
