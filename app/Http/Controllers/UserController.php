<?php


namespace App\Http\Controllers;


use App\Models\User;

class UserController extends Controller
{
    public function index ()
    {
        $level = User::where('level', 0)
            ->paginate($perPage = 5, $columns = ['name', 'level']);
        return response ()->json ($level, 201);
    }
}
