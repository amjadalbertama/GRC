<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Library\GeneratePagesListAndGroup;

class LoginController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->middleware('auth:sanctum', [
            'except' => [
                'index',
                'login',
                'logout',
            ],
        ]);
    }

    /**
     * Login Index
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if (Auth::check()) {
            return redirect('dashboard');
        }

        return view('login.index');
    }

    /**
     * Login
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request, \App\Library\GeneratePagesListAndGroup $page)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email', 'exists:users'],
            'password' => ['required'],
        ]);
 
        if (!isset($request->type)) {
            return response()->json([
                "success" => false,
                "message" => "Field type is required, choose web or api."
            ]);
        }

        if ($request->type == "web") {
            try {
                if (Auth::attempt($credentials)) {
                    $request->session()->regenerate();
                    $request->session()->get('url');
                    $page->generate($request);

                    $user = User::where("email", $request->email)->firstOrFail();
                    $token = $user->createToken("auth_token")->plainTextToken;

                    return response()->json([
                        'success' => true,
                        'data' => [
                            "access_token" => $token,
                            "type" => "Bearer",
                        ],
                        'prev_url' => isset($request->session()->get('url')['intended']) ? $request->session()->get('url')['intended'] : route('home'),
                    ]);
                    // return redirect()->intended('dashboard.index');
                } else {
                    return response()->json([
                        "success" => false,
                        "message" => "Your username or password is incorrect!"
                    ]);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'debug' => $e->getMessage()
                ]);
            }
        } else {
            try {
                if (Auth::attempt($credentials)) {
                    // $request->session()->regenerate();
                    // $request->session()->get('url');
                    // $page->generate($request);

                    $user = User::where("email", $request->email)->firstOrFail();
                    $token = $user->createToken("auth_token")->plainTextToken;

                    return response()->json([
                        'success' => true,
                        'data' => [
                            "access_token" => $token,
                            "type" => "Bearer",
                        ],
                        // 'prev_url' => isset($request->session()->get('url')['intended']) ? $request->session()->get('url')['intended'] : route('dashboard.index'),
                    ]);
                    // return redirect()->intended('dashboard.index');
                } else {
                    return response()->json([
                        "success" => false,
                        "message" => "Your username or password is incorrect!"
                    ]);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'debug' => $e->getMessage()
                ]);
            }
        }
        // return back()->withErrors([
        //     'email' => 'The provided credentials do not match our records.',
        // ])->onlyInput('email');
    }

    /**
     * Logout
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        //
        try {
            Auth::logout();
    
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/');

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'redirect' => ''
            ]);
        }
    }
}
