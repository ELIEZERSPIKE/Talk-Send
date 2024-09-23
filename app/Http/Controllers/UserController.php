<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Response\ApiResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return ApiResponse::sendResponse(true,[ new  UserResource(User::all())], 'Operation effectuee', 201 );
    }

    
}
