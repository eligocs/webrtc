<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Config;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    { 

        $this->mapWebRoutes();

        $this->mapFrontRoutes();

        $this->mapAdminRoutes();

        $this->mapInstituteRoutes();

        $this->mapStudentRoutes();
        
        $this->mapAuthApiRoutes();

        $this->mapFrontApiRoutes();
        
        $this->mapAdminApiRoutes();       
       
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web/web.php'));
    } 
     

    protected function mapFrontRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web/front.php'));
    }

    protected function mapAdminRoutes()
    { 
        Route::prefix('admin') 
            ->middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web/admin.php'));
    }

    protected function mapInstituteRoutes()
    { 
        Route::prefix('institute') 
            ->middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web/institute.php'));
    } 

    protected function mapStudentRoutes()
    { 
        Route::prefix('student') 
            ->middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web/student.php'));
    } 

    /**
     * Define authApi for Auth apis 
     * 
     * 
    */ 

    protected function mapAuthApiRoutes()
    {
        $api_version = Config::get('constants.api_version');        
        $prefix = 'api/'.$api_version.'/'; 
        Route::prefix($prefix)
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/'.$prefix.'auth.php'));
    }

    /**
     * Define frontApi for front apis 
     * 
     * 
    */ 

    protected function mapFrontApiRoutes()
    {
        $api_version = Config::get('constants.api_version');        
        $prefix = 'api/'.$api_version.'/front';  
        Route::prefix($prefix)
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/'.$prefix.'.php'));
    }

    /**
     * Define adminApi for admin apis 
     * 
     * 
    */ 

    protected function mapAdminApiRoutes()
    {
        $api_version = Config::get('constants.api_version');        
        $prefix = 'api/'.$api_version.'/admin'; 
        Route::prefix($prefix)
            ->middleware('auth:api')
            ->namespace($this->namespace)
            ->group(base_path('routes/'.$prefix.'.php'));
    } 
    
}
