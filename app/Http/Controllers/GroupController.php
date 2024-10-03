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
use App\Models\MembreGroup;
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
        'description' => $groupregisterRequest->description,
    ];

    DB::beginTransaction();

    try {
       
        $group = $this->authInterface->Groupregister($data);
        DB::commit();

        
        return ApiResponse::sendResponse(true, [new GroupResource($group)], 'Opération effectuée', 201);
    } catch (\Throwable $th) {
        DB::rollBack(); 
        // return ApiResponse::rollback($th);
        return $th;
    }
  }


    public function index() {
        // Je veux retourner la liste de tous les groupes
        try {
           
            $groups = Group::all();
            return ApiResponse::sendResponse(true, GroupResource::collection($groups), 'Opération effectuée', 200);
        } catch (\Throwable $th) {
            return $th;
            // return ApiResponse::rollback($th);
        }
    }
    
   



    
 public function invite(MemberRequest $request, $groupId) {

    try {
        $group = Group::find($groupId);

        if (!$group) {
            return response()->json(['message' => 'Group not found'], 404);
        }

        $email = $request->input('email');

        $user = User::where('email', $email)->first();

        if ($user) {
            MembreGroup::create([
                'group_id' => $group->id,
                'user_id' => $user->id,
                'member_type' => 'user', 
            ]);

            Mail::to($user->email)->send(new GroupMail($group));

            return response()->json(['message' => 'Utilisateur inscrit ajouté au groupe et notification envoyée'], 200);
        } else {
            // Recherche d'un invité existant
            $invite = Invite::where('email', $email)->first();

            if (!$invite) {
                $invite = Invite::create([
                    'email' => $email,
                    'name' => $request->input('name') ?? 'Invité',
                ]);
            }

            MembreGroup::create([
                'group_id' => $group->id,
                'invite_id' => $invite->id,
                'member_type' => 'invite', 
            ]);

            // Envoi d'email à l'invité
            Mail::to($invite->email)->send(new GroupMail($group));

            return response()->json(['message' => 'Invité ajouté au groupe et notification envoyée'], 200);
        }

    } catch (\Throwable $th) {
        return response()->json(['message' => 'Une erreur est survenue', 'error' => $th->getMessage()], 500);
    }
      }




      public function getGroupByName(Request $request)
      {
          $name = $request->query('name');
          $group = Group::where('name', $name)->first();
  
          if ($group) {
              return response()->json(['groups' => [$group]], 200);
          } else {
              return response()->json(['message' => 'Groupe non trouvé'], 404);
          }
      }
    


}
