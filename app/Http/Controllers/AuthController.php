<?php
namespace App\Http\Controllers;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistertionRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Customs\Services\EmailVerificationService;
use App\Http\Requests\Auth\VerifyEmailRequest;
use Illuminate\Http\Request;
use Validator;


class AuthController extends Controller
{
   
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(private EmailVerificationService $service) {
        // $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request){


         $token = auth()->attempt($request->validated());
         if($token){
            return $this->responsewithtoken($token,auth()->user());
         }
         else{
           return response()->json(['status','failed'],401);
         }
            
        
       
    }
    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegistertionRequest $request) {

        $user = User::create(array_merge(
                    $request->validated(),
                    ['password' => bcrypt($request->password)]
                ));
                if($user){
                    $this->service->sendVerificationLink($user);
                    $token=auth()->login($user);
                    return $this->responsewithtoken($token,$user);
                }
                else{
                    return response()->json(['status'=>'faield','message'=>'an error'],500);
                }
                
        // return response()->json([
        //     'message' => 'User successfully registered',
        //     'user' => $user
        // ], 201);
    }
    public function responsewithtoken($token,$user){
        return response()->json([
            'status'=>'success',
            'user'=>$user,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);



    }

    public function verifyUserEmail(Request  $request){
        $this->service->verifyEmail($request->email,$request->token);

    }
    public function testid(){

        return response()->json([
            'status'=>'success',
            'userid'=>Auth::id(),
           
        ]);

    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        auth()->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        return $this->createNewToken(auth()->refresh());
    }
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile() {
        return response()->json(auth()->user());
    }
    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            // 'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }
}