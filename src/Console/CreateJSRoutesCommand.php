<?php

namespace Halivert\JSRoutes\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;

class CreateJSRoutesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "route:tojs
		{ --name=routes.js : Name of the output file. }
		{ --p|path= : Path of the output file. }
		{ --w|whitelist= : List of comma separated route names to include (overrides ignore and methods). }
		{ --i|ignore=telescope : List of comma separated route names to ignore (overrides methods). }
		{ --m|methods=GET : List of comma separated methods accepted by filter. Empty for include all methods. }
		{ --f|force : Overwrite existing routes by default. }";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Create object with routes, and a function for its JS use";

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
        )->filter(function ($route, $key) {
            return $this->includeRoute($route, $key);
        })->map(function ($route) {
            return [
                "uri" => $route->uri
            ];
        });

        $jsonFlags = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE;

        $content = "var routes = ";
        $content .= json_encode($routes, $jsonFlags);
        $content .= ";\n\n";

        $content .= file_get_contents(__DIR__ . "/../assets/js/routeFunction.js");

        $fileName = $this->option("name");
        if ($this->createFile($fileName, $content)) {
            $this->info($fileName . " created");
        }
    }

    public function createFile($fileName, $contents)
    {
        if (
            file_exists($file = $this->getJSPath($fileName)) &&
            !$this->option("force")
        ) {
            if (
                !$this->confirm(
                    "The [" . $fileName . "] file already exists. Do you want to replace it?"
                )
            ) {
                $this->error("Error");
                return false;
            }
        }

        file_put_contents($file, $contents);
        return true;
    }

    private function includeRoute($route, $routeName)
    {
        $whitelist = explode(",", $this->option("whitelist"));

        if (in_array($routeName, $whitelist)) {
            return true;
        }

        $ignore = explode(",", $this->option("ignore"));

        if (in_array($routeName, $ignore)) {
            return false;
        }

        $methods = $this->option("methods");
        $valid = empty($methods);
        foreach (explode(",", $methods) as $method) {
            $valid |= in_array($method, $route->methods);
        }

        return $valid;
    }

    public function getJSPath($fileName)
    {
        $path = $this->option("path") ?? config('js.path')[0] ?? resource_path('js');
        return implode(DIRECTORY_SEPARATOR, [$path, $fileName]);
    }
}
