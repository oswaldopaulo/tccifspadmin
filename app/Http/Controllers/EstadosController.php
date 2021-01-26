<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\EstadosRequest;

class EstadosController extends Controller
{
    //
   
    
    function index(){
        
        
      
        $t =  DB::table('estados')
        ->select('id_estado','nome_estado','uf_estado','codigo_estado')
        ->get();
        // return var_dump($t);
        
        
        return view('estados.index')->with(['t' =>$t]);
    }
    
    
    function novo(){
        
        
      
        
        return view('estados.novo');
        
    }
    
    
    function insert(EstadosRequest $r){
        
        
        $id = DB::table('estados')->insertGetId([
            'nome_estado'=>Request::input('nome_estado'),
            'uf_estado'=>Request::input('uf_estado'),
            'codigo_estado'=>Request::input('codigo_estado')
        ]);
        
        
        return redirect()->action('EstadosController@index')->with(['id' => $id, 'desc'=> Request::input('nome_estado')]);
    }
    
    function remove($id){
        
        DB::table('estados')->where(['id_estado'=>$id])->delete();
        return redirect()->action('EstadosController@index')->with(['id' => $id,'acao' => 'r']);
    }
    
    
    function editar($id){
        
        
                
        $r = Db::table('estados')
        ->where(['id_estado'=>$id])
        ->get();
        
        $ignore =array('uf_estado','codigo_estado');
        
        //return var_dump($r);
        return view('estados.editar')->with(['r'=>$r[0],'ignore' => $ignore] );
        
    }
    
    function update(EstadosRequest $r){
        
        
        DB::table('estados')
        ->where('id_estado',Request::input('id_estado'))
        ->update([
            'nome_estado'=>Request::input('nome_estado'),
            'uf_estado'=>Request::input('uf_estado'),
            'codigo_estado'=>Request::input('codigo_estado')
        ]);
        
        
        return redirect()->action('EstadosController@index')->with(['id' => Request::input('id_estado'), 'desc'=> Request::input('nome_estado')]);
    }
    
    
   public static function arrayforoptions(){
       return DB::table('estados')
        ->select('uf_estado','nome_estado','id_estado')
        ->get();
        
       
        
         
    }
}
