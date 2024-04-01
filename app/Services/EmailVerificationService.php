<?php
namespace App\Customs\Services;
use Illuminate\Support\Str;
use App\Notifications\EmailVerificationNotification;
use App\Models\EmailVerificationToken;
use Illuminate\Support\Facades\Notification;
use App\models\User;

class EmailVerificationService{
 
public static function sendVerificationLink(object $user): void{
Notification::send($user, new EmailVerificationNotification($this->generateVerificationlink($user->email)));
}


public static function verifyToken(string $email, string $token)
{
    $token = EmailVerificationToken::where('email', $email)->where('token', $token)->first();
    if ($token) {
        if ($token->expired_at >= now()) {
            return $token;
        } else {
            // $token->delete();
            return response()->json([
                'status' => 'failed',
                'message' => 'Token expired'
            ])->send();
        }
    } else {
        return response()->json([
            'status' => 'failed',
            'message' => 'Invalid token'
        ])->send();
    }
}

public  static function checkIfEmailIsVerified($user)
{
    if ($user->email_verified_at) {
        return response()->json([
            'status' => 'failed',
            'message' => 'Email has already been verified'
        ])->send();
    }
}


public function verifyEmail(string $email, string $token)
{
    $user = User::where('email', $email)->first();
    if (!$user) {
        return response()->json([
            'status' => 'failed',
            'message' => 'User not found'
        ]);
    }

    self::checkIfEmailIsVerified( $user);
    $verifiedToken = self::verifyToken($email, $token);

    if ($user->markEmailAsVerified()) {
        if ($verifiedToken) {
            // $verifiedToken->delete();
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Email has been verified successfully'
        ]);
    } else {
        return response()->json([
            'status' => 'failed',
            'message' => 'Email verification failed, please try again later.'
        ]);
    }}



    public function ResendLink($email){
        $user=User::where("email",$email)->first();
        if($user){
           self::sendVerificationLink($user);
           return response()->json([
            'status' => 'success',
            'message' => 'resend link.'
        ]);

        }
        else{
            return response()->json([
                'status' => 'failed',
                'message' => 'user not found.'
            ]);

        }

    }














    // generate verfication link
    public function generateVerificationlink( string $email):string{
        $checkifexisttoken=EmailVerificationToken::where('email',$email)->first();
        if($checkifexisttoken){
            $checkifexisttoken->delete();

        }
        else{
            $token=Str::uuid();
            $url=config('app.url')."?token=".$token."&email=".$email;
            $savetoken=EmailVerificationToken::create(["email"=>$email,"token"=>$token,"expired_at"=>now()->addMinutes(60)]);
            if($savetoken)
            {
                return $url;
            }

        }
    }
}