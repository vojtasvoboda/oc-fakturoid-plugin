# Fakturoid plugin 2.x for OctoberCMS

Fakturoid plugin 2.x for OctoberCMS adds connector to Fakturoid API v3. No other plugin dependencies.

Developed with OctoberCMS v1.1.4 (Laravel 6.0). Latest test with OctoberCMS v3.6.8 (Laravel 9.52.16) and PHP 8.3.3.

## Versions

Plugin has versions 1.x and 2.x and both are compatible with October v1.x, v2.x and v3.x.
But the version 2.x can be used only with PHP 8.1 and higher.

You are watching README for version 2.x.

| Plugin version | Fakturoid API | PHP       |
|----------------|---------------|-----------|
| `2.x`          | `v3`          | `>=8.1`   |
| `1.x`          | `v2`          | `>=5.3.0` |

## Installation

Before first use, you have to fill Fakturoid credentials in CMS > Settings > Fakturoid.

## Using

1. You can use directly Fakturoid Client like that:

`$fakturoid = App::make('Fakturoid\FakturoidManager');`

or

`$fakturoid = app('Fakturoid\FakturoidManager');`

and then call FakturoidManager directly:

```php
$subjects = $fakturoid->getSubjectsProvider()->list()->getBody();
```

2. Or you can use predefined services, whose log errors and exception to the backend log.

Available services at the moment:
- SubjectService for subjects management
- InvoiceService for invoices management

Services methods are compatible with plugin 1.x.

```php
$fakturoid = app('VojtaSvoboda\Fakturoid\Services\SubjectService');
$subjects = $fakturoid->getSubjects();
```

## Webhooks

For using webhooks:

a) Fill random hash in CMS > Settings > Fakturoid > Webhook, see [Random string generator](https://gen.7ka.cz/).
b) Go to the Fakturoid > Nastavení > Napojení na jiné aplikace > Webhooky page and insert webhook URL: _https://yourdomain.com/fakturoid/webhook?token=<random>_.
c) You can enable saving webhooks to the log in CMS > Settings > Fakturoid > Webhook.

Example of handling webhook in your plugin:

```php
public function boot()
{
    Event::listen('vojtasvoboda.fakturoid.webhookReceived', function ($data) {
        // handle only paid events
        if (str_starts_with($data['event_name'], 'invoice_paid') === false) {
            return;
        }

        // get it from Fakturoid API to be sure it is paid
        $invoice_id = $data['invoice_id'];
        $invoiceService = app('VojtaSvoboda\Fakturoid\Services\InvoiceService');
        $invoice = $this->invoiceService->getInvoice($invoice_id);

        // if invoice is paid
        if ($invoice->status == 'paid') {
            // update status in my system
        }
    });
}
```

Webhook data are: invoice_id, number, status, total, paid_at, event_name, invoice_custom_id.

When you return false in the listener, webhook won't be saved to the log.

```php
Event::listen('vojtasvoboda.fakturoid.webhookReceived', function ($data) {
    // e.g. we want to save only webhooks with invoice_paid event
    if ($data['event_name'] !== 'invoice_paid') {
        // when false is returned, webhook won't be saved to the log
        return false;
    }
});

```

You can also modify webhook data before save them to the log:

```php
Event::listen('vojtasvoboda.fakturoid.webhookReceived', function ($data) {
    $data['invoice_custom_id'] = 42;

    // webhook will be saved with invoice_custom_id = 42
    return $data;
});

```

## Documentation

Fakturoid API v3 documentation: https://www.fakturoid.cz/api/v3

## Migration from 1.x to 2.x

- you have to fill new API v3 credentials in CMS > Settings > Fakturoid
- old exception Fakturoid\Exception was replaced with ConnectionFailedException, InvalidDataException, AuthorizationFailedException and RequestException exceptions
- it is not possible to call action 'pay' on invoice anymore (method fireAction)

## Contributing

Please send Pull Request to the master branch.

## License

Fakturoid plugin is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT) same as
OctoberCMS platform.
