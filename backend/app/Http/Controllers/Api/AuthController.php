<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Exception;


class AuthController extends Controller
{

    /**
     * user Login
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){
        $validator = Validator::make($request->all(),[
            "email" => "required|email",
            "password" => "required",
        ]);

        if($validator->fails()){
            return sendError('Validation Error', $validator->errors(),422);
        }

        $credential = $request->only('email','password');

        try {
            if(Auth::attempt($credential)){
                $user = Auth::user();
                $data = [
                    'name'  => $user->name,
                    'email' => $user->email,
                    'access_token' => $user->createToken('accessToken')->accessToken,
                ];
                return sendResponse('You are successfully logged in', $data );
            }else{
                return sendError('Unauthorised access', '',401);
            }

        }catch (Exception $e){
            return sendError('Something wrong', []);
        }
    }


    /**
     * user registration
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request){
        $validator = Validator::make($request->all(),[
            "name" => "required|min:4",
            "email" => "required|email|unique:users",
            "password" => "required|confirmed|min:8",
        ]);

        if($validator->fails()){
            return sendError('Validation Error', $validator->errors(),422);
        }

        try {
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password)
            ]);

            $data = [
                'name'  => $user->name,
                'email' => $user->email,
                'access_token' => $user->createToken('accessToken')->accessToken,
            ];

            return sendResponse('User registration successful',$data);

        }catch (Exception $e){
            return sendError('Something wrong', []);
        }

    }

    /**
     * Get user by user ID
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function userShow($id){
        $user = User::find($id);
        if($user){
            return sendResponse('success',$user);
        }else{
            return sendError('Data not found', []);
        }
    }

    /**
     * user logout
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request){
        auth()->user()->token()->revoke();
        return response()->json( ['message' => 'Successfully logged out'] );
    }


}
