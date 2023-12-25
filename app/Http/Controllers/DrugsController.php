<?php

namespace App\Http\Controllers;

use App\Models\Drug;

use Illuminate\Http\Request;

class DrugsController extends Controller
{
    public function createNewDrug(Request $request){
        $drug=new Drug();
        $drug->scintific_name=$request->scintific_name; 
        $drug->commercial_name=$request->commercial_name; 
        $drug->category=$request->category; 
        $drug->company=$request->company;
        $drug->amount=$request->amount;
        $drug->expiration_date=$request->expiration_date; 
        $drug->price=$request->price; 
        $drug->save();
        return response()->json([
            'Added Successfuly'=>$drug
        ]);
    }

    public function listAllDrugs(){
        // $drugs=Drug::get('commercial_name')->toArray();
        $drugs=Drug::all()->map(function($drugs){
            return collect($drugs)->only(['commercial_name','amount']);
        });
        return response()->json([
            'ALL Drugs'=>$drugs
        ]);
    }

    public function listDetails($id){
        $drug=Drug::where('id',$id)->first();
        return response()->json([
            'data'=>$drug
        ]);
    }


    public function search(Request $request){
        $input= $request->input('NameOrCategory');
        $drug = Drug::where('commercial_name', $input)->orWhere('category', $input)->get();        
        if($drug){
            return response()->json([
                'found it'=>$drug
            ]);
        }
        else{
            return response()->json([
                'Not Found !!!'
            ]); 
        }
    }
}
