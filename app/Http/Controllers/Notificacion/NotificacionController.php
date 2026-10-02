<?php

namespace App\Http\Controllers\Notificacion;

use App\Http\Controllers\Controller;
use App\Models\Notificaciones\Notificaciones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;


class NotificacionController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {

        $notificaciones = Notificaciones::where('users_permiso', auth()->user()->id)->orderBy('id','ASC')->get();

        return response()->json([
            'status' => 'success',
            'message' => '',
            'data'    => $notificaciones,
        ]);
    }

    public function totalNuevos(Request $request)
    {

        $notificaciones = Notificaciones::where('users_permiso', auth()->user()->id)->orderBy('id','ASC')->get();

        return response()->json([
            'status' => 'success',
            'message' => '',
            'data'    => ["total" => count($notificaciones) ],
        ]);
    }

    public function show()
    {
        $not = Notificaciones::where('users_permiso', auth()->user()->id)->orderBy('id','ASC')->get();

        return view('notificacion.show', compact('not'));
    }
}