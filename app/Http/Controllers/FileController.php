<?php

namespace App\Http\Controllers;

use App\Http\Resources\GroupResource;
use App\Models\File;
use App\Response\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FileController extends Controller
{
    // public function upload(Request $request, $id){
    //     $request->validate([
    //         'file' => 'required|file|mimes:jpg,png,pdf,docx,txt|max:2048',
    //         'group_id' => 'required|exists:groups,id'
    //     ]);

    //     $file = $request->file('file');
    //     $path = $file->store('chat_files', 'public');
        
    //     $fileModel = new File();
    //     $fileModel->file_name = $file->getClientOriginalName();
    //     $fileModel->file_path = $path;
    //     $fileModel->file_type = $file->getClientMimeType();
    //     $fileModel->group_id = $request->input('group_id');

    //     $fileModel->user_id = $id;
    //     $fileModel->save();
    //     return response()->json([
    //         'message' => 'Fichier envoye avec success',
    //         'file' => $fileModel
    //     ], 201);
    // }


    public function file(Request $fileRequest,$id)
    {
        $data = [
            'file' => 'required|file|mimes:jpg,png,pdf,docx,txt|max:2048',
            'group_id' => 'required|exists:groups,id'
        ];
    
        // Validation des données
        $validatedData = $fileRequest->validate($data);
    
        DB::beginTransaction();
    
        try {
            $file = $fileRequest->file('file');
            $path = $file->store('chat_files', 'public');
    
            $fileModel = new File();
            $fileModel->file_name = $file->getClientOriginalName();
            $fileModel->file_path = $path;
            $fileModel->file_type = $file->getClientMimeType();
            $fileModel->group_id = $validatedData['group_id'];
            $fileModel->user_id = $id;    
            $fileModel->save(); 
    
            DB::commit();
    
            return ApiResponse::sendResponse(true, [new GroupResource($fileModel)], 'Opération effectuée', 201);
        } catch (\Throwable $th) {
            DB::rollback(); 
            return ApiResponse::rollback($th); 
        }
    }
    

   
    public function index($groupId)
    {
        $files = File::where('group_id', $groupId)->get();
        return response()->json($files);
    }


















    public function telecharge($id){
        $file = File::findOrFail($id);

        return response()->download(storage_path('app/' .$file->file_path), $file->file_name);
    }
    
    public function show(){
        $files = File::all();
        return response()->json([
            'message' => 'Fichier affiche avec sucess',
            'file' => $files
        ], 201);
    }
    
    public function delete($id){
        $files = File::findOrFail($id);

        $files->delete();
        return response()->json([
            'message' => 'Fichier Supprimer avec sucess',
            'file' => true
        ], 201);
    }
    
   

}
