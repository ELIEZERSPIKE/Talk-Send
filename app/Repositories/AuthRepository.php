<?php

namespace App\Repositories;

use App\Interfaces\AuthInterface;
use App\Mail\OtpCodeMail;
use App\Models\File;
use App\Models\Group;
use App\Models\OtpCode;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthRepository implements AuthInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function register(array $data)
    {
        User::create($data);
        $otp_code = [
            'email' => $data['email'],
            'code' =>rand(111111, 999999)
        ];
        OtpCode::where('email', $data['email'])->delete();
        OtpCode::create($otp_code);
        Mail::to($data['email'])->send(new OtpCodeMail(
            $data['name'],
            $data['email'],
            $otp_code['code']
        ));
        
    }
    public function login(array $data)
    {
        
        $user = User::where('email', $data['email'])->first();
        if(!$user)
        return false;

            if(!Hash::check($data['password'], $user->password)){
                return false;
            }
            $user->tokens()->delete();
            $user->token = $user->createToken($user->id)->plainTextToken;

            return $user;
    }
    
    public function checkOtpCode(array $data){
       $otp_code = OtpCode::where('email', $data['email'])->first();
       if(!$otp_code)
       return false; 

       if(Hash::check($data['code'], $otp_code['code'])){
        $user = User::where('email', $data['email'])->first();
        $user->update(['is_confirmed' => true]);

        $otp_code->delete();
        $user->token = $user->createToken($user->id)->plainTextToken;
        return $user;
       }
       return false;
    }

    public function Groupregister(array $data){
        // $group = Group::create($data);
         $group = Group::create([
             'name' => $data['name'],
            //  'avatar' => $data['avatar'],
             'description' => $data['description']
         ]);
    
        return $group; 
    }

    // Methode Pour la creation d 'un invite'
    public function Invite(array $data)
    {
      $user = User::create($data);  
    
      return $user;
    }

     //   $user = User::create([
    //     'name' => $data['name'],
    //     'email' => $data['email'],
    //   ]); 
    
   
    public function file(array $data){
        $file = File::create($data);
    }

    // public function show_files($goupId){
    //     $files = [];
    //     $file = File::where('group_id', $goupId)->get();
    //     // foreach ($file as $file){
    //     //     array_push($files, $file);
    //     // }
    //     return $file;
    // }
}
