# Easy-WebhookAPI
This is an API that allows you to easily send webhooks.

# How to use
1. Put it in the plugin folder.
2. Add the "use Webhook\Webhook;" to the files you want to use.
3. Use "Webhook::setWebhookUrl();" to set the destination.
4. Use "Webhook::setColor();" to set the color.
5. Use "Webhook::setTitle();" to set the title.
6. Use "Webhook::setContents();" to set contents.
7. Use "Webhook::sendWebhook();" to send a Webhook.

# example

<?php

namespace Example;

use pocketmine\plugin\PluginBase;
use Webhook\Webhook;

class Example extends PluginBase {
    public function onEnable(): void {   
       Webhook::setWebhookUrl(https://discord.com/api/webhooks/00000");
        Webhook::setColor("FFFFFF");
        Webhook::setTitle("Webhook");
        Webhook::setContents("This is a Webhook");
        Webhook::sendWebhook();
    }
}
