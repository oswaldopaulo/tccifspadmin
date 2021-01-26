<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\LojaRequest;
use Illuminate\Support\Facades\Auth;
class LojaController extends Controller
{
    function index(){
        
        $itens = DB::Select('select id, descricao, cod_barra from produtos where id not in (select idproduto from loja where idempresa=' . Auth::user()->idempresa . ')');
           
    
        $t = DB::select("SELECT `idloja`, loja.idproduto as idproduto, `preco`, `desconto`, `datainicioloja`, `datafimloja`, `datainiciopromo`, `datafimpromo`, destaque, loja.ativo as ativo, descricao, demanda 
FROM `loja` 
INNER JOIN produtos ON produtos.id = loja.idproduto
where loja.idempresa=" . Auth::user()->idempresa . "

GROUP by  `idloja`, loja.idproduto, `preco`, `desconto`, `datainicioloja`, `datafimloja`, `datainiciopromo`, `datafimpromo`,destaque, loja.ativo, descricao, demanda
");
        return view('loja/index')->with(['t' =>$t,'itens'=>$itens]);
    }
    
    
    function novo(){
     
        return view('loja/novo');
        
    }
    
    function insert(LojaRequest $r){
      
        

        $id = DB::table('loja')->insertGetId([
            'idproduto'=>Request::input('idproduto'),
            'idempresa'=>Auth::user()->idempresa,
            'preco'=>Request::input('preco'),
            'demanda'=>Request::input('demanda'),
            'desconto'=>Request::input('desconto'),
            'datainicioloja'=>Request::input('datainicioloja'),
            'datafimloja'=>Request::input('datafimloja'),
            'datainiciopromo'=>Request::input('datainiciopromo'),
            'datafimpromo'=>Request::input('datafimpromo'),
            
            'ativo'=>'S'
        ]);
        
        
        return redirect()->action('LojaController@index')->with(['id' => $id, 'desc'=> Request::input('descricao')]);
    }
    
    function remove($id){
        
        DB::table('loja')->where(['idloja'=>$id])->delete();
        return redirect()->action('LojaController@index')->with(['id' => $id,'acao' => 'r']);
    }
    
    
    function editar($id){
      
        $r = Db::table('loja')
        ->where(['idloja'=>$id])
        ->get();
     
        return view('loja/editar')->with(['r'=>$r[0]] );
        
    }
    
    function update(LojaRequest $r){
        
        if($r->file('icone')) {
            $image = $r->file('icone');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/icones');
            
            $image->move($destinationPath, $name);
            DB::table('loja')
            ->where('idloja',Request::input('idloja'))
            ->update([
                
                'icone'=>$name
                
                
            ]);
        
        
        
        }
        
        
        DB::table('loja')
        ->where('idloja',Request::input('idloja'))
        ->update([
            
            'descricao'=>Request::input('descricao'),
            'ativo'=>Request::input('ativo') ? 'S':'N'
            
            
        ]);
        
        return redirect()->action('LojaController@index')->with(['id' => Request::input('idloja'), 'desc'=> Request::input('descricao')]);
    }
    
    function saveall(){
        foreach($_POST as $name => $value) {
            $s = explode("-", $name);
            $campo = $s[0];
           
            
            
            if($campo=='change' && $value=='1'){
                $id=$s[1];
               
                DB::table('loja')
                ->where('idloja',$id)
                ->update([
                    
                    
                    'preco'=>Request::input('preco-' . $id),
                    'desconto'=>Request::input('desconto-'  . $id),
                    
                    'datainicioloja'=>Request::input('datainicioloja-'  . $id),
                    'datafimloja'=>Request::input('datafimloja-'  . $id),
                    'datainiciopromo'=>Request::input('datainiciopromo-'  . $id),
                    'datafimpromo'=>Request::input('datafimpromo-'  . $id),
					'demanda'=>Request::input('demanda-'  . $id),
                                  
                    'ativo'=>Request::input('ativo-' . $id) ? 'S': 'N'
                    
                    
                ]);
            
                
            }
    
        }
        return redirect()->action('LojaController@index')->with(['id' => Request::input('idloja'), 'desc'=> Request::input('descricao')]);
    }
}
