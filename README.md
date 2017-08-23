# laravel-route-logger

README:

run: composer require "eyepax-it/route-logger:dev-master"

add:
Add to App\Kernel\ =>

 protected $middleware = [
  \Eyepax\RouteLogger\RequestResponseLogger::class
]

Add to config\app.php =>

 'providers' => [
    Eyepax\RouteLogger\RouteLoggerServiceProvider::class,
  ]
  
  run: php artisan migrate
  
 
 
