# Laravel JS routes
Command for use Laravel routes in JS

### Usage:

```
composer require halivert/laravel-js-routes
```

Add the resource to webpack.mix.js:
```js
mix.js("resources/js/routes", "public/js");
```

And to use it, you need to import it
```js
import { route } from "./routes.js";
```

And voila! you can have the ```route``` function, the first parameter is the route name (same as in laravel)
and the second is an array of parameters.  
