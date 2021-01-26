<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CategoriasRequest;
use Illuminate\Support\Facades\Auth;
class CategoriasController extends Controller
{
    function index(){
      
           
        $t =  DB::table('categorias') 
            ->where('idempresa',Auth::user()->idempresa)
            ->get();
        
        return view('categorias/index')->with(['t' =>$t]);
    }
    
    
    function novo(){
     
        return view('categorias/novo');
        
    }
    
    function insert(CategoriasRequest $r){
        if($r->file('imagem')){
            $image = $r->file('imagem');
            $name = sha1(time() + rand(1,99)).'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/icones');
            
            $image->move($destinationPath, $name);
        } else {
            $name='semimage.png';
        }
            
        $id = DB::table('categorias')->insertGetId([
            'descricao'=>Request::input('descricao'),
            'idempresa'=>Auth::user()->idempresa,
            'icone'=>$name,
            'ativo'=>Request::input('ativo') ? 'S': 'N'
        ]);
  
        
        
        return redirect()->action('CategoriasController@index')->with(['id' => $id, 'desc'=> Request::input('descricao')]);
    }
    
    function remove($id){
        
        $r = Db::table('categorias')
        ->select('icone')
        ->where(['id'=>$id])
        ->get();
        
        if($r[0]->icone){
            if(file_exists(public_path('/icone/' . $r[0]->icone))){
                unlink(public_path('/icones/' . $r[0]->icone));
            }
        }
        
        DB::table('categorias')->where(['id'=>$id])->delete();
        return redirect()->action('CategoriasController@index')->with(['id' => $id,'acao' => 'r']);
    }
    
    
    function editar($id){
      
        $r = Db::table('categorias')
        ->where(['id'=>$id])
        ->get();
     
        return view('categorias/editar')->with(['r'=>$r[0]] );
        
    }
    
    function update(CategoriasRequest $r){
        
        if($r->file('imagem')) {
            $image = $r->file('imagem');
            $name = sha1(time() + rand(1,99)) .'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/icones');
            
            $image->move($destinationPath, $name);
            DB::table('categorias')
            ->where('id',Request::input('id'))
            ->update([
                
                'icone'=>$name
                
                
            ]);
        
        
        
        }
        
        
        DB::table('categorias')
        ->where('id',Request::input('id'))
        ->update([
            'idempresa'=>Auth::user()->idempresa,
            'descricao'=>Request::input('descricao'),
            'ativo'=>Request::input('ativo') ? 'S':'N'
            
            
        ]);
        
        return redirect()->action('CategoriasController@index')->with(['id' => Request::input('id'), 'desc'=> Request::input('descricao')]);
    }
}
