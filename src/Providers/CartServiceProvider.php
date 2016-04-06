<?php
namespace Mrtom90\LaravelShop\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Mrtom90\LaravelShop\Cart\Cart;

class CartServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    public function boot()
    {

        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'courier');

        if (!$this->app->routesAreCached()) {
            require __DIR__ . '/../Http/routes.php';
        }

    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app['cart'] = $this->app->share(function ($app) {
            $storage = $app['session'];
            $events = $app['events'];
            $instanceName = 'cart';
            $session_key = '4yTlTDKu3oJOfzD';

            return new Cart(
                $storage,
                $events,
                $instanceName,
                $session_key
            );
        });
        $this->app->register('Mrtom90\LaravelShop\Providers\HtmlServiceProvider');

        $loader = AliasLoader::getInstance();
        $loader->alias('Html', 'Mrtom90\LaravelShop\Facades\HtmlFacade');
        $loader->alias('Form', 'Mrtom90\LaravelShop\Facades\FormFacade');

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
