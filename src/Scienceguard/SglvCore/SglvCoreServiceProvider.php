<?php 

namespace Scienceguard\SglvCore;

use Illuminate\Support\ServiceProvider;

class SglvCoreServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('scienceguard/sglv-core');

		// include files using require function
		$files = array(
			'constants',
			'functions',
		);
		$this->loadIncludes($files, 'require');

		// include files using include function
		// $files = array(
		// 	'events',
		// 	'filters',
		// 	'validations',
		// 	'routes',
		// );
		// $this->loadIncludes($files, 'include');
	}

	/**
    * Include some specific files from the src-root.
    *
    * @return void
    */
	private function loadIncludes($files, $param='include')
	{
		// Run through $filesToLoad array.
		foreach ($files as $file) {
			// Add needed database structure and file extension.
			$file = __DIR__ . '/../../' . $file . '.php';
			// If file exists, include.
			if (is_file($file) && file_exists($file)){
				if($param=='require'){
					require_once($file);
				}
				else{
					include($file);
				}
			}
		}
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		/*
		* Register the service provider for the dependency.
		*/
		// $this->app->register('Barryvdh\Debugbar\ServiceProvider');
		/*
		* Create aliases for the dependency.
		*/
		// $loader = \Illuminate\Foundation\AliasLoader::getInstance();
		// $loader->alias('Debugbar', 'Barryvdh\Debugbar\Facade');
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}
