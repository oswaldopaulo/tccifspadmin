<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\SubdepartamentosRequest;
use Illuminate\Support\Facades\Auth;
class SubdepartamentosController extends Controller
{
    function index(){
      
           
        $t =  DB::table('subdepartamentos') 
            ->where('idempresa',Auth::user()->idempresa)
            ->get();
        
        return view('subdepartamentos/index')->with(['t' =>$t]);
    }
    
    
    function novo(){
     
        return view('subdepartamentos/novo');
        
    }
    
    function insert(SubdepartamentosRequest $r){
        if($r->file('imagem')){
            $image = $r->file('imagem');
            $name = sha1(time() + rand(1,99)).'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/icones');
            
            $image->move($destinationPath, $name);
        } else {
            $name='semimage.png';
        }
            
        $id = DB::table('subdepartamentos')->insertGetId([
            'descricao'=>Request::input('descricao'),
            'idempresa'=>Auth::user()->idempresa,
            'icone'=>$name,
            'ativo'=>Request::input('ativo') ? 'S': 'N'
        ]);
  
        
        
        return redirect()->action('SubdepartamentosController@index')->with(['id' => $id, 'desc'=> Request::input('descricao')]);
    }
    
    function remove($id){
        
        $r = Db::table('subdepartamentos')
        ->select('icone')
        ->where(['id'=>$id])
        ->get();
        
        if($r[0]->icone){
            if(file_exists(public_path('/icone/' . $r[0]->icone))){
                unlink(public_path('/icones/' . $r[0]->icone));
            }
        }
        
        DB::table('subdepartamentos')->where(['id'=>$id])->delete();
        return redirect()->action('SubdepartamentosController@index')->with(['id' => $id,'acao' => 'r']);
    }
    
    
    function editar($id){
      
        $r = Db::table('subdepartamentos')
        ->where(['id'=>$id])
        ->get();
     
        return view('subdepartamentos/editar')->with(['r'=>$r[0]] );
        
    }
    
    function update(SubdepartamentosRequest $r){
        
        if($r->file('imagem')) {
            $image = $r->file('imagem');
            $name = sha1(time() + rand(1,99)) .'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/icones');
            
            $image->move($destinationPath, $name);
            DB::table('subdepartamentos')
            ->where('id',Request::input('id'))
            ->update([
                
                'icone'=>$name
                
                
            ]);
        
        
        
        }
        
        
        DB::table('subdepartamentos')
        ->where('id',Request::input('id'))
        ->update([
            'idempresa'=>Auth::user()->idempresa,
            'descricao'=>Request::input('descricao'),
            'ativo'=>Request::input('ativo') ? 'S':'N'
            
            
        ]);
        
        return redirect()->action('SubdepartamentosController@index')->with(['id' => Request::input('id'), 'desc'=> Request::input('descricao')]);
    }
}
