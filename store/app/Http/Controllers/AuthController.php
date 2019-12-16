<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Traits\JwtTrait;
use Illuminate\Support\Facades\Hash;
use App\Http\Helpers\Responser;
use Illuminate\Http\Response;
use App\Http\Requests\User\UserPostRequest;

class AuthController extends Controller
{    

    use JwtTrait;

    private $responser;

    public function __construct(Responser $responser)
    {
        $this->responser = $responser;
    }

    public function register(UserPostRequest $request)
    {

        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => bcrypt($request->password),
            'role'      => 2
        ]);
    
        $this->responser->setStatus(Responser::UNAUTHORIZED);
        $this->responser->setData(['user' => $user]);
        return $this->responser->respond();

    } 

    public function login(Request $request): Response
    {
        $user = User::where('email', $request->email)->first();

        if(!$user)
        {
            $this->responser->setErrors(['request' => ['Unautorized']]);
            $this->responser->setStatus(Responser::UNAUTHORIZED);
            return $this->responser->respond();
        }

        if (!(Hash::check($request->password, $user->password))) 
        {
            $this->responser->setErrors(['request' => ['Unautorized']]);
            $this->responser->setStatus(Responser::UNAUTHORIZED);
            return $this->responser->respond();
        }
        
        $this->responser->setData(['token' => $this->jwt($user)]);
        return $this->responser->respond();
    }    
        
    public function user(Request $request, Responser $responser): Response
    {
        $user = User::findOrFail($request->auth->id);        
        
        $data['user'] = $user;
        $responser->setData($data);

        return $responser->respond();
    }    
    
    public function refresh(Request $request): Response
    {
        
        $user = User::findOrFail($request->auth->id);

        $this->responser->setData(['token' => $this->jwt($user)]);
        return $this->responser->respond();
    }    
    
    private function guard()
    {
        return Auth::guard();
    }
}