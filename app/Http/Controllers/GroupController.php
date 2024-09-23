<?php

namespace App\Http\Controllers;

use App\Http\Requests\GroupRequest;
use App\Http\Requests\MemberRequest;
use App\Http\Resources\GroupResource;
use App\Interfaces\AuthInterface;
use App\Mail\GroupMail;
use App\Mail\OtpCodeMail;
use App\Models\Group;
use App\Models\invite;
use App\Models\OtpCode;
use App\Models\User;
use App\Response\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class GroupController extends Controller
{
    //

    private AuthInterface $authInterface;

    public function __construct(AuthInterface $authInterface){
       $this->authInterface = $authInterface; 
    }

  public function Groupregister(GroupRequest $groupregisterRequest){
    
    $data = [
        'name' => $groupregisterRequest->name,
        'avatar' => $groupregisterRequest->avatar,
        'description' => $groupregisterRequest->description,
    ];

    DB::beginTransaction();

    try {
       
        $group = $this->authInterface->Groupregister($data);
        DB::commit();

        
        return ApiResponse::sendResponse(true, [new GroupResource($group)], 'Opération effectuée', 201);
    } catch (\Throwable $th) {
        DB::rollBack(); 
        return ApiResponse::rollback($th);
    }
  }


    public function index(){
        
        // Je veux retourner la liste de tous les groupes
        try{
            $groups = Group::all();
            DB::commit();
            return ApiResponse::sendResponse(true, [new GroupResource($groups)], 'Opération effectuée', 201);


        } catch(\Throwable $th){
            DB::rollBack();
            return ApiResponse::rollback($th);
        }

    }

    



public function Invite(Request $request, $groupId) {
    try {
        $group = Group::find($groupId);

        if (!$group) {
            return response()->json(['message' => 'Group not found'], 404);
        }

        $email = $request->input('email');

        $user = invite::where('email', $email)->first();

        if (!$user) {
            $user = invite::create([
                'email' => $email,
                'name' => $request->input('name') ?? 'Invité',
            ]);

            Mail::to($user->email)->send(new GroupMail($group));
        }

        $group->invites()->attach($user->id);

         return response()->json(['message' => 'User added to group and notified via email'], 200);

    } catch (\Throwable $th) {
        return $th;
        // return response()->json(['message' => 'An error occurred', 'error' => $th->getMessage()], 500);
    }
}


    


}
