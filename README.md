# Fakturoid plugin for OctoberCMS

Fakturoid plugin for OctoberCMS adds connector to Fakturoid API v2. No other plugin dependencies.

Developed with OctoberCMS v1.1.4 (Laravel 6.0). Latest test with OctoberCMS v3.2.21 (Laravel 9.52.5).

## Installation

Before first use, you have to fill Fakturoid credentials in CMS > Settings > Fakturoid.

## Using

1. You can use directly Fakturoid Client like that:

`$fakturoid = App::make('Fakturoid\Client');`

or

`$fakturoid = app('Fakturoid\Client');`

2. Or you can use predefined services, which they log errors and exception to the backend log.

For now there are available:
- SubjectService for subjects management
- InvoiceService for invoices management

**Feel free to send pull request!**

## Documentation

Fakturoid API v2 documentation: https://fakturoid.docs.apiary.io/

## Contributing

Please send Pull Request to the master branch.

## License

Fakturoid plugin is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT) same as
OctoberCMS platform.
