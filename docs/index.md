---
layout: repo
---

## Inicio rápido

```shell
composer require halivert/laravel-js-routes
```

Ejecutar comando `artisan`

```shell
php artisan route:tojs
```

Agregar el recurso al archivo `webpack.mix.js`:

```js
mix.js("resources/js/routes", "public/js");
```

Y para utilizarlo, requiere ser importado

```js
import { route } from "./routes.js";
```

¡Y voilá! ahora tienes acceso a la función `route` en JS, su primer parámetro es
el nombre (el mismo que en Laravel) y el segundo es un arreglo o un objeto de
parámetros.

## Configuración

Puedes agregar un objeto llamado `jsroutes` a tu archivo `config/app.php`:

```php
'jsroutes' => [
  'methods' => [
    // Selecciona solamente las rutas con estos métodos e.g.
    'GET'
  ],
  'include' => [
    // Incluye explicitamente las rutas con estos nombres e.g.
    'users.store'
  ],
  'exclude' => [
    // Excluye las rutas con los siguientes nombres e.g.
    'telescope',
  ]
]
```

También puedes utilizar las opciones de comando

-   `name`: Nombre del archivo generado (por defecto: routes.js).
-   `p|path`: Ruta del archivo generado.
-   `i|include`: Lista de nombres de rutas a incluir separados por comas
    (sobreescribe `exclude` y `methods`).
-   `e|exclude`: Lista de nombres de rutas a excluir separados por comas
    (sobreescribe `methods`).
-   `m|methods`: Lista de métodos aceptados por el filtro (GET, POST, PUT, PATCH,
    DELETE). Dejar en blanco para aceptar todos los métodos.
-   `f|force`: Sobreescribe el achivo si ya existe.

## Licencia
[MIT](https://github.com/halivert/laravel-js-routes/blob/master/LICENSE)
