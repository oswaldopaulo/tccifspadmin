<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\DepartamentosRequest;
use Illuminate\Support\Facades\Auth;
class DepartamentosController extends Controller
{
    function index(){
      
           
        $t =  DB::table('departamentos') 
            ->where('idempresa',Auth::user()->idempresa)
            ->get();
        
        return view('departamentos/index')->with(['t' =>$t]);
    }
    
    
    function novo(){
     
        return view('departamentos/novo');
        
    }
    
    function insert(DepartamentosRequest $r){
        if($r->file('imagem')){
            $image = $r->file('imagem');
            $name = sha1(time() + rand(1,99)).'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/icones');
            
            $image->move($destinationPath, $name);
        } else {
            $name='semimage.png';
        }
            
        $id = DB::table('departamentos')->insertGetId([
            'descricao'=>Request::input('descricao'),
            'idempresa'=>Auth::user()->idempresa,
            'icone'=>$name,
            'ativo'=>Request::input('ativo') ? 'S': 'N'
        ]);
  
        
        
        return redirect()->action('DepartamentosController@index')->with(['id' => $id, 'desc'=> Request::input('descricao')]);
    }
    
    function remove($id){
        
        $r = Db::table('departamentos')
        ->select('icone')
        ->where(['id'=>$id])
        ->get();
        
        if($r[0]->icone){
            if(file_exists(public_path('/icone/' . $r[0]->icone))){
                unlink(public_path('/icones/' . $r[0]->icone));
            }
        }
        
        DB::table('departamentos')->where(['id'=>$id])->delete();
        return redirect()->action('DepartamentosController@index')->with(['id' => $id,'acao' => 'r']);
    }
    
    
    function editar($id){
      
        $r = Db::table('departamentos')
        ->where(['id'=>$id])
        ->get();
     
        return view('departamentos/editar')->with(['r'=>$r[0]] );
        
    }
    
    function update(DepartamentosRequest $r){
        
        if($r->file('imagem')) {
            $image = $r->file('imagem');
            $name = sha1(time() + rand(1,99)) .'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/icones');
            
            $image->move($destinationPath, $name);
            DB::table('departamentos')
            ->where('id',Request::input('id'))
            ->update([
                
                'icone'=>$name
                
                
            ]);
        
        
        
        }
        
        
        DB::table('departamentos')
        ->where('id',Request::input('id'))
        ->update([
            'idempresa'=>Auth::user()->idempresa,
            'descricao'=>Request::input('descricao'),
            'ativo'=>Request::input('ativo') ? 'S':'N'
            
            
        ]);
        
        return redirect()->action('DepartamentosController@index')->with(['id' => Request::input('id'), 'desc'=> Request::input('descricao')]);
    }
}
