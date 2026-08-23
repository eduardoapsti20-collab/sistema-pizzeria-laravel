<?php
namespace App\Providers;
use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            // CORREGIDO: antes esto hacía un `Setting::first()` por CADA vista
            // renderizada en la página (layout, componentes, sub-vistas...).
            // Con `static`, la consulta se ejecuta una sola vez por petición
            // y se reutiliza el mismo resultado para el resto de vistas.
            static $empresa = null;

            if ($empresa === null) {
                $empresa = Setting::first();
            }

            $view->with('empresa', $empresa);
        });
    }
}