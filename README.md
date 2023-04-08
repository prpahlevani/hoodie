# hoodie
This package provides you a regular uniformed JSON response structure.

## Installation

```bash
$ composer require motrack/hoodie
```

### For Laravel version < 5.5

If you don't use auto-discovery, add the ServiceProvider to the providers array in `config/app.php`

```php
Motrack\Hoodie\Providers\HoodieServiceProvider::class,
```

you can add the facade name as an alias to the `config/app.php`

```php
"aliases": {
    "Hoodie" => Motrack\Hoodie\Facades\Hoodie::class
}
```
or just add the facade class wherever you need.

```php
use Motrack\Hoodie\Facades\Hoodie
```

## Basic Usage

there are two basic methods `respondSuccess()` and `respondError()` for the general response managing.
for example you can easily make a response in your Controller using Hoodie

```php
    public function doFunction(): JsonResponse
    {
        ...
        return Hoodie::respondSuccess();
    }
```

there are still options for customizing the response message, status code, or even setting some custom headers.

```php
return Hoodie::respondSuccess('Success!', 200, ['token' => $token, 'platform' => 'core']);
```

you can even pass the exception through the `respondError()` method to manage the response error when the `APP_DEBUG` is `true` in your `.env` file, if you wish.

```php
return Hoodie::respondError('Something went wrong!', 500, $exception, $headers );
```

## Advanced Usage

if you want to pass your using resource through the result of the API response, you can call `respondWithResource()` method.

```php
use App\Http\Resources\PostResource; // the Json Resource you've provided for the result

class PostController extends Controller
{
    ...
    public function show(Post $post): JsonResponse
    {
        return Hoodie::respondWithResource(new PostResource($post) , 'Post Created Successfully', 201 , ['my_custom_header' => 'header_value']);
    }
    ...
}
```

the `respondWithResourceCollection()` method is using for when you need to pass a Json Collection Resource through the result of your API.

```php
use App\Http\Resources\PostCollection; // the Json Collection you've provided for the result

class PostController extends Controller
{
    public function index(): JsonResponse
    {
        return Hoodie::respondWithResourceCollection(new PostCollection(Post::paginate()) , 'List of Posts Retrieved Successfully', 200 , ['my_custom_header' => 'header_value']);
    }
    ...
}
```
