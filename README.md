# Laravel JS routes

> [!NOTE]
> This package is not maintained anymore, I suggest you to use
> [Ziggy](https://github.com/tighten/ziggy) since is a bigger one, with more
> support.
>
> Anyways, thank you so much for your support :smile:

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

Or add route function to bootstrap.js as stated in #1 by @clandestine8

```js
window.route = require('./routes.js').route;
// You can't use absolute routes with this method.
```

If you want to use absolute urls, you need to have `MIX_APP_URL` .env var

And to use it, you need to import it

```js
import { route } from "./routes.js";
```

And voila! you can have the `route` function, the first parameter is the route
name (same as in laravel), the second is an array of parameters or an object,
and the third is if you want to use absolute paths, by default true.

## License
[MIT](https://github.com/halivert/laravel-js-routes/blob/master/LICENSE)

## Contributing

Pull requests and issues are welcome.
