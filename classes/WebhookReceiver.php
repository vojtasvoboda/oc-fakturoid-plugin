<?php namespace VojtaSvoboda\Fakturoid\Classes;

use Event;
use VojtaSvoboda\Fakturoid\Models\Settings;
use VojtaSvoboda\Fakturoid\Models\WebhookLog;

class WebHookReceiver
{
    public function handle(array $data)
    {
        $this->logWebhook($data);

        /** @event vojtasvoboda.fakturoid.webhookReceived */
        Event::fire('vojtasvoboda.fakturoid.webhookReceived', [$data]);
    }

    private function logWebhook(array $data)
    {
        // check if enabled
        if ($this->isWebhookLogEnabled() === false) {
            return;
        }

        // save webhook data
        WebhookLog::create($data);
    }

    private function isWebhookLogEnabled(): bool
    {
        return Settings::get('webhook_log_enabled', false);
    }
}
