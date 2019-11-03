<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;

class CreateJSRoutes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:routes
		{ --name=routes.js : Name of created file }
		{--force : Overwrite existing routes by default }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create object with routes, and a function for its JS use';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $routes = collect(
            Route::getRoutes()->getRoutesByName()
        )->filter(function ($e, $k) {
            return $this->includeRoute($e, $k);
        })->map(function ($e) {
            return [
                "uri" => $e->uri
            ];
        });

        $content = "var routes = ";
        $content .= json_encode($routes, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        $content .= ";\n\n";

        $content .= "const route = (routeName, params = []) => {\n";
        $content .= "	var _route = routes[routeName];\n";
        $content .= "	if (_route == null) {\n";
        $content .= "		throw \"Requested route doesn't exist\";\n";
        $content .= "	}\n";
        $content .= "	var uri = _route.uri;\n";
        $content .= "	for (var i = 0; i < params.length; i++) {\n";
        $content .= "		uri = uri.replace(/{[\w]+}/, params[i]);\n";
        $content .= "	}\n";
        $content .= "	if (uri.includes(\"}\")) {\n";
        $content .= "		throw \"Missing parameters\";\n";
        $content .= "	}\n";
        $content .= "	return '/' + uri;\n";
        $content .= "}\n";

        $content .= "\nexport { route };";

        $fileName = $this->option("name");
        if ($this->createFile($fileName, $content)) {
            $this->info("{$fileName} created");
        }
    }

    public function createFile($fileName, $contents)
    {
        if (
            file_exists($file = $this->getJSPath($fileName)) &&
            !$this->option('force')
        ) {
            if (
                !$this->confirm(
                    "The [{$fileName}] view already exists. Do you want to replace it?"
                )
            ) {
                $this->error('Error');
                return false;
            }
        }

        file_put_contents($file, $contents);
        return true;
    }

    private function includeRoute($value, $routeName)
    {
        $valid = $routeName !== 'telescope';
        $valid &= (
            in_array('GET', $value->methods) ||
            $routeName === 'read-notifications.update'
        );

        return $valid;
    }

    public function getJSPath($path)
    {
        return implode(
            DIRECTORY_SEPARATOR,
            [config('js.path')[0] ?? resource_path('js'), $path]
        );
    }
}
