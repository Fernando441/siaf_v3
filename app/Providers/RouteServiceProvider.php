<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/tablero';
    public const HOME_GPS = '/solicitud/listado-proveedor';
    protected $namespace = 'App\Http\Controllers';

    public function boot()
    {
        parent::boot();
    }

    public function map()
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
        $this->mapUnidadRoutes();
        $this->mapClienteRoutes();
        $this->mapProyectoRoutes();
        $this->mapLicitacionRoutes();
        $this->mapUsuarioRoutes();
        $this->mapArchivoRoutes();
        $this->mapSegmentoRoutes();
        $this->mapPerfilRoutes();
        $this->mapTallerRoutes();
        $this->mapComercialRoutes();
        $this->mapFinanzasRoutes();
        $this->mapChatRoutes();
        $this->mapNotificacionRoutes();
        $this->mapSolicitudRoutes();
        $this->mapBusquedaRoutes();
        $this->mapSeminuevosRoutes();
    }

    protected function mapApiRoutes()
    {
        Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));
    }

    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    protected function mapUnidadRoutes()
    {
        Route::middleware('web')
            ->prefix('unidad')
            ->namespace($this->namespace . '\Unidad')
            ->group(base_path('routes/unidad.php'));
    }

    protected function mapClienteRoutes()
    {
        Route::middleware('web')
            ->prefix('cliente')
            ->namespace($this->namespace . '\Cliente')
            ->group(base_path('routes/cliente.php'));
    }

    protected function mapProyectoRoutes()
    {
        Route::middleware('web')
            ->prefix('proyecto')
            ->namespace($this->namespace . '\Proyecto')
            ->group(base_path('routes/proyecto.php'));
    }

    protected function mapLicitacionRoutes()
    {
        Route::middleware('web')
            ->prefix('licitacion')
            ->namespace($this->namespace . '\Licitacion')
            ->group(base_path('routes/licitacion.php'));
    }

    protected function mapUsuarioRoutes()
    {
        Route::middleware('web')
            ->prefix('usuario')
            ->namespace($this->namespace . '\Usuario')
            ->group(base_path('routes/usuario.php'));
    }

    protected function mapArchivoRoutes()
    {
        Route::middleware('web')
            ->prefix('archivo')
            ->namespace($this->namespace . '\Archivo')
            ->group(base_path('routes/archivo.php'));
    }

    protected function mapSegmentoRoutes()
    {
        Route::middleware('web')
            ->prefix('segmento')
            ->namespace($this->namespace . '\Segmento')
            ->group(base_path('routes/segmento.php'));
    }

    protected function mapPerfilRoutes()
    {
        Route::middleware('web')
            ->prefix('perfil')
            ->namespace($this->namespace . '\Perfil')
            ->group(base_path('routes/perfil.php'));
    }

    protected function mapTallerRoutes()
    {
        Route::middleware('web')
            ->prefix('taller')
            ->namespace($this->namespace . '\Taller')
            ->group(base_path('routes/taller.php'));
    }

    protected function mapComercialRoutes()
    {
        Route::middleware('web')
            ->prefix('comercial')
            ->namespace($this->namespace . '\Comercial')
            ->group(base_path('routes/comercial.php'));
    }

    protected function mapFinanzasRoutes()
    {
        Route::middleware('web')
            ->prefix('finanzas')
            ->namespace($this->namespace . '\Finanzas')
            ->group(base_path('routes/finanzas.php'));
    }

    protected function mapChatRoutes()
    {
        Route::middleware('web')
            ->prefix('chat')
            ->namespace($this->namespace . '\Chat')
            ->group(base_path('routes/chat.php'));
    }

    protected function mapNotificacionRoutes()
    {
        Route::middleware('web')
            ->prefix('notificacion')
            ->namespace($this->namespace . '\Notificacion')
            ->group(base_path('routes/notificacion.php'));
    }

    protected function mapSolicitudRoutes()
    {
        Route::middleware('web')
            ->prefix('solicitud')
            ->namespace($this->namespace . '\Solicitud')
            ->group(base_path('routes/solicitud.php'));
    }

    protected function mapBusquedaRoutes()
    {
        Route::middleware('web')
            ->prefix('busqueda')
            ->namespace($this->namespace . '\Busqueda')
            ->group(base_path('routes/busqueda.php'));
    }

    protected function mapSeminuevosRoutes()
    {
        Route::middleware('web')
            ->prefix('seminuevos')
            ->namespace($this->namespace . '\Unidad')
            ->group(base_path('routes/seminuevos.php'));
    }
}
