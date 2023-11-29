<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')],
            'password' => ['required', 'string', 'min:8'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_id' => 2
        ]);

        return response()->json(['message' => 'berhasil registrasi']);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/',],
        ], [
            'password.regex' => 'Password harus memiliki setidaknya satu huruf kapital, satu angka, dan satu simbol.',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            // Jika email tidak terdaftar, berikan respons yang sesuai
            return response()->json(['status' => 404, 'message' => 'Email tidak terdaftar'], 404);
        }
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $token = $user->createToken('token')->plainTextToken;
            $user->role;

            return response()->json(['data' => $user, 'token' => $token]);
        } else {
            return response()->json(['status' => 401, 'message' => 'Password salah'], 401);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['status' => 200, 'message' => "berhasil logout"], 200);
    }

    public function getInfo(Request $request)
    {
        $data = $request->user();
        $role = $data->role;
        return response()->json(['status' => 200, 'data' => $role], 200);
    }
}
