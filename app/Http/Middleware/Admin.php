<?php


namespace App\Http\Middleware;

use App\Models\User;
use Firebase\JWT\JWT;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Http\Request;

class Admin
{
    public function handle(Request $request, \Closure $next)
    {
        try {
            if (!$request->hasHeader('Authorization')) {
                throw new \Exception();
            }
            if ( !$request->hasHeader ('Authorization') ) {
                return null;
            }
            $authorizationHeader = $request->header ('Authorization');
            $token = str_replace ('Bearer ', '', $authorizationHeader);

            $dadosAutenticacao = JWT::decode($token, env('JWT_KEY'), ['HS256']);

            $user = User::where(
                'email',
                $dadosAutenticacao->email
            )->first();

            if (is_null ($user) && $user->level != "Administrador") {
                throw new \Exception();
            }
            return $next($request);

        } catch (\Exception $e) {
            return response ()->json ("Não autorizado, apenas administradores do sistema.", 401);
        }

    }
}
