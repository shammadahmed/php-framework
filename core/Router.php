<?php

namespace Core;

class Router
{
	protected $routes = [
		'GET' => [],
		'POST' => [],
		'PATCH' => [],
		'PUT' => [],
		'DELETE' => [],
	];

	public static function load($file)
	{
		$router = new static;

		require $file;

		return $router;
	}

	public function define($routes)
	{
		$this->routes = $routes;
	}

	public function get($uri, $controller)
	{
		$this->routes['GET'][trim($uri, '/')] = $controller;
	}

	public function post($uri, $controller)
	{
		$this->routes['POST'][trim($uri, '/')] = $controller;
	}

	public function put($uri, $controller)
	{
		$this->routes['PUT'][trim($uri, '/')] = $controller;
	}

	public function patch($uri, $controller)
	{
		$this->routes['PATCH'][trim($uri, '/')] = $controller;
	}

	public function delete($uri, $controller)
	{
		$this->routes['DELETE'][trim($uri, '/')] = $controller;
	}

	public function direct($uri, $method)
	{
		if (array_key_exists($uri, $this->routes[$method])) {
			return $this->callAction(
				...explode('@', $this->routes[$method][$uri])
			);
		}

		throw new \Exception('No route defined for this URI');
	}

	public function callAction($controller, $action)
	{
		$controller = "App\\Controllers\\{$controller}";
		$controller = new $controller;

		if (! method_exists($controller, $action)) {
			throw new \Exception(
				"{$controller} does not respond to the {$action} action"
			);
		}

		return $controller->$action();
	}
}