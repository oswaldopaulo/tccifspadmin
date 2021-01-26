<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\EmpresasRequest;
class EmpresasController extends Controller
{
    function index(){
      
           
        $t =  DB::table('empresas') ->get();
        
        return view('empresas/index')->with(['t' =>$t]);
    }
    
    
    function novo(){
     
        return view('empresas/novo');
        
    }
    
    function insert(EmpresasRequest $r){
       
 
        $id = DB::table('empresas')->insertGetId([
            'nome'=>Request::input('nome'),
            'telefone'=>Request::input('telefone'),
            'celular'=>Request::input('celular'),
            'cep_end'=>Request::input('cep_end'),
            'num_end'=>Request::input('num_end'),
            'observacao'=>Request::input('observacao'),
            'compl_num_end'=>Request::input('compl_num_end'),
            'cpf'=>Request::input('cpf'),
            'email'=>Request::input('email'),
            'token'=>Request::input('token'),
            'des_end'=>Request::input('des_end'),
            'bairro'=>Request::input('bairro'),
            'des_cidade'=>Request::input('des_cidade'),
            'des_uf'=>Request::input('des_uf'),
            'ativo'=>Request::input('ativo') ? 'S': 'N'
        ]);
  
        
  
        return redirect()->action('EmpresasController@index')->with(['id' => $id, 'desc'=> Request::input('descricao')]);
    }
    
    function remove($id){
        
   
        
        DB::table('empresas')->where(['id'=>$id])->delete();
        return redirect()->action('EmpresasController@index')->with(['id' => $id,'acao' => 'r']);
    }
    
    
    function editar($id){
      
        $r = Db::table('empresas')
        ->where(['id'=>$id])
        ->get();
     
        return view('empresas/editar')->with(['r'=>$r[0]] );
        
    }
    
    function update(EmpresasRequest $r){
        
  
        
        
        DB::table('empresas')
        ->where('id',Request::input('id'))
        ->update([
            
             'nome'=>Request::input('nome'),
            'telefone'=>Request::input('telefone'),
            'celular'=>Request::input('celular'),
            'cep_end'=>Request::input('cep_end'),
            'num_end'=>Request::input('num_end'),
            'observacao'=>Request::input('observacao'),
            'compl_num_end'=>Request::input('compl_num_end'),
            'cpf'=>Request::input('cpf'),
            'email'=>Request::input('email'),
            'token'=>Request::input('token'),
            'des_end'=>Request::input('des_end'),
            'bairro'=>Request::input('bairro'),
            'des_cidade'=>Request::input('des_cidade'),
            'des_uf'=>Request::input('des_uf'),
            'ativo'=>Request::input('ativo') ? 'S': 'N'
            
            
        ]);
        
        return redirect()->action('EmpresasController@index')->with(['id' => Request::input('id'), 'desc'=> Request::input('descricao')]);
    }
      public static function getempresas(){
        
        return DB::table('empresas')
             ->select('id', 'nome', 'cpf')
             ->where(['ativo'=>'S'])
             ->get();
    }
    
     public static function getempresa($id){
        
        return DB::table('empresas')
             ->select('id', 'nome', 'cpf')
             ->where(['ativo'=>'S','id'=>$id])
             ->get();
    }
}
