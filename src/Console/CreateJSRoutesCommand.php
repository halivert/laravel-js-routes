<?php

namespace Halivert\JSRoutes\Console;

use Illuminate\Console\Command;

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
		{ --i|include= : List of comma separated route names to include (overrides exclude and methods). }
		{ --e|exclude= : List of comma separated route names to exclude (overrides methods). }
		{ --m|methods= : List of comma separated methods accepted by filter. Empty for include all methods. }
		{ --f|force : Overwrite existing routes by default. }";

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = "Create object with routes, and a function for its JS use. Uses key from configuration file 'jsroutes'.";

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
		$routes = $this->getRoutesArray();

		$jsonFlags = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE;

		$content = 'const routes = ';
		$content .= json_encode($routes, $jsonFlags);
		$content .= ";\n\n";

		$content .= file_get_contents(
			__DIR__ . '/../assets/js/routeFunction.js'
		);

		$fileName = $this->option('name') ?? config('app.jsroutes.name');
		if ($this->createFile($fileName, $content)) {
			$this->info("$fileName created");
		}
	}

	public function getRoutesArray(): array
	{
		return collect(
			app('router')->getRoutes()->getRoutesByName()
		)->filter(function ($route, $key) {
			return $this->includeRoute($route, $key);
		})->map(function ($route) {
			return [
				'uri' => $route->uri
			];
		})->toArray();
	}

	public function createFile($fileName, $contents)
	{
		if (
			file_exists($file = $this->getJSPath($fileName)) &&
			!$this->option('force')
		) {
			if (
				!$this->confirm(
					"The [$fileName] file already exists. Do you want to replace it?"
				)
			) {
				$this->error('Error');
				return false;
			}
		}

		file_put_contents($file, $contents);
		return true;
	}

	private function includeRoute($route, $routeName)
	{
		$include = $this->getOption('include');

		if (in_array($routeName, $include)) {
			return true;
		}

		$exclude = $this->getOption('exclude');

		if (in_array($routeName, $exclude)) {
			return false;
		}

		$methods = $this->getOption('methods');

		$valid = empty($methods);
		foreach ($methods as $method) {
			$valid |= in_array($method, $route->methods);
		}

		return $valid;
	}

	protected function getJSPath($fileName)
	{
		$path = $this->getOption(
			'path',
			config('js.path')[0] ?? resource_path('js')
		);

		return implode(DIRECTORY_SEPARATOR, [$path, $fileName]);
	}

	protected function getOption(string $key, $default = null)
	{
		if ($this->option($key)) {
			return explode(',', $this->option($key));
		}

		return config("app.jsroutes.$key", $default);
	}
}
