<?php


namespace App\Http\Controllers;


use App\Models\User;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class TokenController extends Controller
{
    public function createToken (Request $request)
    {
        $this->validate ($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where(
            'email',
            $request->email
        )->first();



        if ( is_null ($user) || !Hash::check( $request->password, $user->password ) ) {
            return response ()
                ->json(
                    'Usuário ou senha inválidos',
                    401
                );
        }

        $token = JWT::encode(
            ['email' => $request->email],
            env('JWT_KEY')
        );

        return [
            'access_token' => $token
        ];
    }
}
