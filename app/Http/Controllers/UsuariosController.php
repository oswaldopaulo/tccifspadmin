<?php

namespace App\Http\Controllers;


use App\User;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\UsuariosRequest;
use Illuminate\Support\Facades\Auth;

class UsuariosController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    
  
    public function index(){
        
       
        $t = User::all();
        return view('auth.index')->with(['t'=>$t]);
    }
    
    public function novo(){
        return  view('auth.novo');
    }
    
    function editar($id){
        
        $r = Db::table('usuarios')
        ->where(['id'=>$id])
        ->get();
        
     
        
        $ignore =array('email','username');
        
        //return var_dump($r);
        return view('auth.editar')->with(['r'=>$r[0],'ignore' => $ignore] );
        
    }
    
    function remove($id){
        if (DB::table('usuarios')->count()<=1) {
            return redirect()->back()->withErrors(['Voce não pode apagar todos usuários']);
        }
        
        DB::table('usuarios')->where(['id'=>$id])->delete();
        return redirect()->action('UsuariosController@index')->with(['id' => $id,'acao' => 'r']);
    }
    
    function update(UsuariosRequest $r){
        
        DB::table('usuarios')
        ->where('id',Request::input('id'))
        ->update([
            'name'=> Request::input('name'),
             'idempresa'=> Request::input('idempresa'),
            'tipo_contato'=> 'M',
            'telefone'=> Request::input('telefone'),
            'cep'=> str_replace(array('.','/','-'),'',Request::input('cep')),
            'tipo_endereco'=> 'B',
            'rua'=> Request::input('rua'),
            'numero'=> Request::input('numero'),
            'bairro'=> Request::input('bairro'),
            'cidade'=> Request::input('cidade'),
            'uf'=> Request::input('uf'),
            'cpf'=> str_replace(array('.','/','-'),'',Request::input('cpf')),
            'ativo'=> Request::input('ativo') ? 'S': 'N'
        ]);
        
        
        if(Request::input('password')){
            DB::table('usuarios')
            ->where('id',Request::input('id'))
            ->update([
                      
                'password'=> bcrypt(Request::input('password')),
              
            ]);
        }
        
        
        return redirect()->action('UsuariosController@index')->with(['id' => Request::input('id'), 'desc'=> Request::input('name')]);
    }
   
    public function insert(UsuariosRequest $r){
  
        
   
      $id =  DB::table('usuarios')->insertGetId([
            'name'=> Request::input('name'),
            'username'=> Request::input('username'),
            'idempresa'=> Request::input('idempresa'),
            'email'=> Request::input('email'),
            'password'=> bcrypt(Request::input('password')),
            'tipo_contato'=> 'M',
            'telefone'=> Request::input('telefone'),
            'cep'=> str_replace(array('.','/','-'),'',Request::input('cep')),
            'tipo_endereco'=> 'B',
            'rua'=> Request::input('rua'),
            'numero'=> Request::input('numero'),
            'bairro'=> Request::input('bairro'),
            'cidade'=> Request::input('cidade'),
            'uf'=> Request::input('uf'),
            'cpf'=> str_replace(array('.','/','-'),'',Request::input('cpf')),
            'tipo'=> Request::input('tipo') ? '1': '0',
            'ativo'=> Request::input('ativo') ? 'S': 'N'
        ]);
        
        return redirect()->action('UsuariosController@index')->with(['id' => $id, 'desc'=> Request::input('name')]);
    }
}
