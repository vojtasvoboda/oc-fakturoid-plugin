<?php namespace VojtaSvoboda\Fakturoid\Classes;

use Event;
use VojtaSvoboda\Fakturoid\Models\Settings;
use VojtaSvoboda\Fakturoid\Models\WebhookLog;

class WebhookReceiver
{
    public function handle(array $data)
    {
        /** @event vojtasvoboda.fakturoid.webhookReceived */
        $response = Event::fire('vojtasvoboda.fakturoid.webhookReceived', [$data], true);

        // do not save webhook data if response is false
        if ($response === false) {
            return;
        }

        // overriding webhook data if needed
        if (is_array($response)) {
            $data = $response;
        }

        // log webhook data
        $this->logWebhook($data);
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
