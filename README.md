# Laravel JS routes

Command for use Laravel routes in JS

## Usage:

```shell
composer require halivert/laravel-js-routes
```

Execute artisan command

```shell
php artisan route:tojs
```

Add the resource to webpack.mix.js:

```js
mix.js("resources/js/routes", "public/js");
```

And to use it, you need to import it

```js
import { route } from "./routes.js";
```

And voila! you can have the `route` function, the first parameter is the route
name (same as in laravel) and the second is an array of parameters.

## License
[MIT](https://github.com/halivert/laravel-js-routes/blob/master/LICENSE)

## Contributing

Pull requests and issues are welcome.
