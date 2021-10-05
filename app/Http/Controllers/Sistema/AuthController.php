<?php

namespace App\Http\Controllers\Sistema;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Sistema\Usuarios\Permiso;

class AuthController extends Controller
{
    public function login(Request $request){
        $credentials = $request->only('email', 'password');
        $credentials['activo'] = 1;

        if ($token = $this->guard()->attempt($credentials)) {
            return response()->json([
                'status' => 'success'
            ], 200)->header('Authorization', $token);
        }

        return response()->json([
            'error' => 'error_login',
            'status' => 'error',
            'message' => 'Error al validar los datos del usuario'
        ],401);
    }
    public function register(Request $request)
    {
        $v = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'password'  => 'required|min:3|confirmed'
        ]);

        if ($v->fails())
        {
            return response()->json([
                'status' => 'error',
                'errors' => $v->errors()
            ], 422);
        }

        $user = new User;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->name = $request->name;
        $user->id_empresa = $request->id_empresa;
        $user->save();

        return response()->json(['status' => 'success'], 200);
    }

    public function logout()
    {
        $this->guard()->logout();

        return response()->json([
            'status' => 'success',
            'msg' => 'Sesión cerrada correctamente.'
        ], 200);
    }

    public function user(Request $request)
    {
        //Devuelve todos los datos del usuario
        $user = User::find(Auth::user()->id);

        return response()->json([
            'status' => 'success',
            'data' => $user
        ]);
    }

    public function refresh()
    {
        if ($token = $this->guard()->refresh()) {
            return response()
                ->json(['status' => 'successs'], 200)
                ->header('Authorization', $token);
        }

        return response()->json(['error' => 'refresh_token_error'], 401);
    }

    private function guard()
    {
        return Auth::guard();
    }
}