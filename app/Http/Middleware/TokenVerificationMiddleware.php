<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Helper\JWTToken;
use Exception;
use App\Models\User;

class TokenVerificationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token=$request->cookie('token');
       //$token = $request->header("token");
       //return $token;
        $result=JWTToken::VerifyToken($token);
        if($result=="unauthorized"){
            return redirect('/userLogin');
            // return response()->json([
            //     'status'=>"fail",
            //     "message"=>"unauthorized"
            // ],401);
        }
        else{
            $request->headers->set('email',$result->userEmail);
          //  $request->headers->set('id',$result->userID);
            return $next($request);
        }
        return $next($request);
    }

     /*function ResetPassword(Request $request){
        try{
            $email=$request->header('email');
            $password=$request->input('password');
            User::where('email','=',$email)->update(['password'=>$password]);
            return response()->json([
                'status' => 'success',
                'message' => 'Request Successful',
            ],200);

        }catch (Exception $exception){
            return response()->json([
                'status' => 'fail',
                'message' => 'Something Went Wrong',
            ],200);
        }
    }*/
}
