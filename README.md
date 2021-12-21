# Metabase Dashboard

This packages provides a tool for embedding Metabase dashboards in your Laravel Nova application.

## Install

Via Composer

``` bash
composer require samfelgar/metabase-dashboard
```

## Usage

First, you'll need a `Samfelgar\MetabaseDashboard\DataTransferObjects\Dashboard` instance. It receives four parameters:
`url`, `secret`, `resource` and `params`.

> **PRO TIP:** It's not advisable to keep secrets in your codebase. You can create a config file pointing to an environment
> variable and access it with `config('your-config-file.secret')`.

```php
$dashboard = new \Samfelgar\MetabaseDashboard\DataTransferObjects\Dashboard(
    'https://example.com',
    'your-secret',
    1, // resource id
    [
    'param' => 'value'
    ]
);
```

Then, on your `App\Providers\NovaServiceProvider`, you can register the tool:

> **IMPORTANT:** You must pass a unique identifier as the first parameter, or else you may experience some weird behavior.  

```php
public function tools(): array
{
    return [
        (new \Samfelgar\MetabaseDashboard\MetabaseDashboard('uniqueIdentifier', $dashboard))
            ->label('Awesome Label')
            ->title('Awesome Title'),
    ];
}
```

## Contributing

All contributions are welcome! Please open a PR.

## Security

If you discover any security related issues, please email samfelgar@gmail.com or open an issue.

## License

The MIT License (MIT).