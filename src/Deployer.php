<?php namespace Deployer;

use Deployer\Http\GitHubWebhookController;
use Silex\Application;

class Deployer {

	public function __construct()
	{
		$this->app = new Application;

		$this->app['debug'] = true;
	}

	public function goDoYourThang()
	{
		$this->registerRoutes();

		$this->app->run();
	}

	private function registerRoutes()
	{
		$this->app->get('/', function() { return 'Welcome!'; });

		$this->app->get('/hello/{name}', function($name) {
			return 'Hello, '.$this->app->escape($name);
		});

		$this->app->post('/github', GitHubWebhookController::class);
	}

} 