# Crud Repository Generator

With this package you can generate simple CRUD repositories, with or without a contract.

## Usage

Without contract for the User model.
```
php artisan make:repository UserRepository
```
With contract for the User model.
```
php artisan make:repository -c UserRepository
```

## Config

If you have a custom location for your models, you can publish the config.
The config defaults to "App\Models"

```
php artisan vendor:publish --provider="Treggats\CrudRepositoryGenerator\CrudRepositoryGeneratorServiceProvider"
```
