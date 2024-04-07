<?php

use VojtaSvoboda\Fakturoid\Classes\WebhookController;

// Fakturoid webhook route
Route::post('/fakturoid/webhook', [WebhookController::class, 'receive']);
