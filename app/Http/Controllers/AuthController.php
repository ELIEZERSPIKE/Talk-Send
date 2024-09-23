<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\Resources;
use App\Http\Resources\UserResource;
use App\Interfaces\AuthInterface;
use App\Models\User;
use App\Response\ApiResponse;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    private AuthInterface $authInterface;

    public function __construct(AuthInterface $authInterface)
    {
       $this->authInterface = $authInterface; 
    }

    public function register(RegisterRequest $registerRequest){

        $data = [
            'name' => $registerRequest->name,
            'email' => $registerRequest->email,
            'password' => $registerRequest->password,
        ];

        // return $data,c'est pour deboguer register quand l'api ne retourne pas de tableau ;

        DB::beginTransaction();

        try{

            $user = $this->authInterface->register($data);
            DB::commit();

            return ApiResponse::sendResponse(true, [new UserResource($user)],'Opération effectuée', 201
        );


        } catch(\Throwable $th){
            return $th;

            return ApiResponse::rollback($th);
        }

    }

    public function login(Request $loginRequest){
        $data = [
            'email' => $loginRequest->email,
            'password' => $loginRequest->password
        ];

        // return $data;


        DB::beginTransaction();
        try{
            $user = $this->authInterface->login($data);
            DB::commit();
            if(!$user){
                return ApiResponse::sendResponse(
                    $user,
                    [],
                    'Nom utilisateur ou Mot depasse incorrecte',
                    200
                );
            }

            return ApiResponse::sendResponse(
                $user,
                [],
                'Operation effectuee',
                200
            );

        } catch(\Throwable $th){
            return ApiResponse::rollback($th);
        }
    }

    public function checkOtpCode(Request $request){
        $data = [
            'email' => $request->email,
            'code' => $request->code,
        ];

        DB::beginTransaction();
        try{
            $user = $this->authInterface->checkOtpCode($data);

            DB::commit();

            if(!$user){
                return ApiResponse::sendResponse(
                    false,
                    [],
                    'code de confirmation invalide',
                    '200'
                );
            } else{
                return ApiResponse::sendResponse(
                    true,
                    [],
                    'code de confirmation valide',
                    '200'
                );
            }


        }catch(\Throwable $th){
            
            // return $th;

             return ApiResponse::rollback($th);

        }
    }

    public function logout(){
        $user = User::find(auth()->user()->getAuthIdentifier());
        $user->token()->delete();

        return ApiResponse::sendResponse(
            true,
            [],
            'Utilisateur deconnecté',
            200
        );
    }
}
