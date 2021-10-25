# Laravel Repository Generator
With this package you can generate repositories with the ```artisan make:repository``` command. 
The generator will generate the repository, repository interface and will bind them automatically (can be changed to 
manual binding) to the Service Container so you can inject the interface into your controllers.

## Installation
Require the Laravel Repository Generator with composer.
```
composer require timwassenburg/laravel-repository-generator
```

### Publish config (optional)
```
php artisan vendor:publish --provider="TimWassenburg\RepositoryGenerator\RepositoryGeneratorServiceProvider" --tag="config"
```

## Usage
For usage take the following steps. Generate the repository and then inject it into a controller or service.

### Generating repositories
Run the following command.
```
php artisan make:repository UserRepository
```
This example will generate the following files:
```
app\Repositories\Eloquent\UserRepository
app\Repositories\UserRepositoryInterface
```

### Dependency Injection
Next we have to inject the interface into the constructor our controller or service. For this example we will use the UserController.
```php
<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepositoryInterface;

class UserController extends Controller
{
    private $user;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->user = $userRepository;
    }
    
    // your controller functions
}
```

By default you will be able to use Eloquent methods like ```all()``` and ```find()```.
You can extend this in your repository. Now you will be able to use your repository 
in your methods like this.
```php
public function index()
{
    return $this->user->all();
}
```
## Manual binding
By default the package will automatically bind the repository interfaces for you with the repositories so you can
inject the interface into your controllers. If you want to bind manually you can disable
this behaviour by setting the ```auto_bind_interfaces``` option to ```false``` in ```config\repository-generator.php```.
If the config is not there make sure to publish it first as described in the Installation chapter.

You can add your bindings to your AppServiceProvider or 
you can a create a new provider with ```php artisan make:provider RepositoryServiceProvider```
(don't forget to add it in ```config\app.php```) and add the bindings in the ```register()``` method, see the example below.

```php
<?php 

namespace App\Providers; 

use App\Repositories\Eloquent\UserRepository;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider; 

/** 
* Class RepositoryServiceProvider 
* @package App\Providers 
*/ 
class RepositoryServiceProvider extends ServiceProvider 
{ 
   /** 
    * Register services. 
    * 
    * @return void  
    */ 
   public function register() 
   { 
       $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
   }
}
```

## Contributing
If you want to contribute to this package feel tree to open a ticket or a pull request.

## License
The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
