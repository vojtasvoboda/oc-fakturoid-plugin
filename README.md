# Fakturoid plugin 1.x for OctoberCMS

Fakturoid plugin 1.x for OctoberCMS adds connector to Fakturoid API v2. No other plugin dependencies.

Developed with OctoberCMS v1.1.4 (Laravel 6.0). Latest test with OctoberCMS v3.6.8 (Laravel 9.52.16) and PHP 8.3.3.

## Versions

Plugin has versions 1.x and 2.x and both are compatible with October v1.x, v2.x and v3.x.
But the version 2.x can be used only with PHP 8.1 and higher.

You are watching README for version 1.x.

| Plugin version | Fakturoid API | PHP       |
|----------------|---------------|-----------|
| `2.x`          | `v3`          | `>=8.1`   |
| `1.x`          | `v2`          | `>=5.3.0` |

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
