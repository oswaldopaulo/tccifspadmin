<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\PlataformasRequest;

class OpenController extends ControllerOpen
{
 
    
    function getbyitem($id){
        
        $r = DB::table('produtos_imagens')->where(['id_produto'=>$id])->take('1')->get();
        $image=$r[0]->imagem;
        if(is_file(public_path('produtos/' . $image))){
            return response()->file( public_path('produtos/' . $image));
        } else {
            return response()->file( public_path('produtos/semimage.png'));
        }
       
    }
    
    function getbyname($image){
        
        if(is_file(public_path('produtos/' . $image))){
            return response()->file( public_path('produtos/' . $image));
        } else {
            return response()->file( public_path('produtos/semimage.png'));
        }
        
    }
    
    function getbyid($id){
         
        $r = DB::table('produtos_imagens')->where(['id'=>$id])->take('1')->get();
        $image=$r[0]->imagem;
       if(is_file(public_path('produtos/' . $image))){
            return response()->file( public_path('produtos/' . $image));
        } else {
            return response()->file( public_path('produtos/semimage.png'));
        }
    }
    
    function compras(){
        return redirect()->away("http://127.0.0.1:8000/compras");
    }
 
        
    
}
