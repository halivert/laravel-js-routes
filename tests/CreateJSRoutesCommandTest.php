<?php

namespace Halivert\JSRoutes\Tests;

use Halivert\JSRoutes\Console\CreateJSRoutesCommand;
use Illuminate\Routing\Router;
use Orchestra\Testbench\TestCase;

class CreateJSRoutesCommandTest extends TestCase
{
	protected function getPackageProviders($app)
	{
		return [
			'Halivert\JSRoutes\Tests\Stubs\Providers\JSRoutesServiceProviderTest'
		];
	}

	protected function getEnvironmentSetUp($app)
	{
		$app['router']->get('get', ['as' => 'get', 'uses' => function () {
			return 'hello world';
		}]);

		$app['router']->get('get/{id}', ['as' => 'hi', 'uses' => function () {
			return 'hello world';
		}]);

		$app['router']->post('post', function () {
			return 'goodbye world';
		})->name('bye');

		$app['router']->group(['prefix' => 'boss'], function (Router $router) {
			$router->put('put', ['as' => 'boss.hi', 'uses' => function () {
				return 'hello boss';
			}]);

			$router->delete('delete', function () {
				return 'goodbye boss';
			})->name('boss.bye');
		});


		$app['router']->patch('patch', function () {
			return 'goodbye world';
		})->name('patch');

		$app['router']->options('options', function () {
			return 'goodbye world';
		})->name('options');

		$app['router']->get('bruh', function () {
			return 'goodbye world';
		})->name('telescope');

		$app['router']->get('multi/{id}/param/{id2}/url/{id}', function () {
			return 'goodbye world';
		})->name('multiparam');

		$app['config']->set('app.jsroutes.path', './');
	}

	/**
	 * @test
	 */
	public function it_creates_file()
	{
		if (file_exists(realpath('./routes.js'))) {
			$this->artisan('route:tojs')->expectsQuestion(
				"The [routes.js] file already exists. Do you want to replace it?",
				"yes"
			)->expectsOutput('routes.js created')->assertExitCode(0);
		} else {
			$this->artisan('route:tojs')
				->expectsOutput('routes.js created')
				->assertExitCode(0);
		}
	}
}
