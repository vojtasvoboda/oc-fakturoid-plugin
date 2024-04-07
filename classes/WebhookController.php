<?php namespace VojtaSvoboda\Fakturoid\Classes;

use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use VojtaSvoboda\Fakturoid\Models\Settings;

class WebhookController extends Controller
{
    public function receive(WebHookReceiver $receiver): Response
    {
        /** @var string $token Get token from settings */
        $token = Settings::get('webhook_token');

        // check token
        if (!empty($token) && $token !== get('token')) {
            return response('Unauthorized', 401);
        }

        // handle webhook
        $receiver->handle(post());

        return response('OK', 200);
    }
}
