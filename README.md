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

**Feel free to send pull request!**

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
