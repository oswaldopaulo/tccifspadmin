<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ProdutosRequest;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Auth;
class ProdutosController extends Controller
{
    function index(){
      
           
        $t =  DB::table('produtos');
        
        if(!Auth::user()->tipo==1){
            $t->where(['geral'=>'N','verificado'=>'N','idempresa'=>Auth::user()->idempresa]);
        }
      
        $t =$t->get();
        
           
        return view('produtos/index')->with(['t' =>$t]);
    }
    
    
    function novo(){
     
      
        return view('produtos/novo');
        
    }
    
    function insert(ProdutosRequest $r){
   
           
        $id = DB::table('produtos')->insertGetId([
            'descricao'=>Request::input('descricao'),
            'detalhes'=>Request::input('detalhes'),
            'idempresa'=>Auth::user()->idempresa,
            'cod_barra'=>Request::input('cod_barra'),
            'ficha'=>Request::input('ficha'),
            'geral'=>Request::input('geral') ? 'S': 'N',
            'ativo'=>Request::input('ativo') ? 'S': 'N'
        ]);
  
        if(is_array(Request::file('imagens'))){
            foreach($r->file('imagens') as $image){
                
                $name = sha1($id + time()+ rand(1,99)).'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/produtos');
                
                $image_resize = Image::make($image->getRealPath());
                
                $h = (400 * $image_resize->height())/$image_resize->width();
                
                $image_resize->resize(400, $h);
                $image_resize->save($destinationPath . '/min' . $name);
                
                
                $image->move($destinationPath, $name);
                
                DB::table('produtos_imagens')->insert([
                    'id_produto'=>$id,
                    'imagem'=>$name
                    
                ]);
            }
        }
        return redirect()->action('ProdutosController@index')->with(['id' => $id, 'desc'=> Request::input('descricao')]);
    }
    
    function remove($id){
        
        $r = Db::table('produtos_imagens')
        ->select('imagem')
        ->where(['id_produto'=>$id])
        ->get();
        
        if(!empty($r[0]->imagem)){
            if(file_exists(public_path('/produtos/' . $r[0]->imagem))){
                unlink(public_path('/produtos/' . $r[0]->imagem));
            }
            if(file_exists(public_path('/produtos/min' . $r[0]->imagem))){
                unlink(public_path('/produtos/min' . $r[0]->imagem));
            }
        }
        
        DB::table('produtos')->where(['id'=>$id])->delete();
        return redirect()->action('ProdutosController@index')->with(['id' => $id,'acao' => 'r']);
    }
    
    function removeimagem($id){
        
        $r = Db::table('produtos_imagens')
        ->where(['id'=>$id])
        ->get();
        
        
        $id_produto = $r[0]->id_produto;
        foreach($r as $e){
            if(file_exists(public_path('/produtos/' . $e->imagem))){
                unlink(public_path('/produtos/' . $e->imagem));
            }
            if(file_exists(public_path('/produtos/min' . $e->imagem))){
                unlink(public_path('/produtos/min' . $e->imagem));
            }
            
        }
        
        DB::table('produtos_imagens')->where(['id'=>$id])->delete();
        
        
        return $this->editar($id_produto);
    }
    
    function editar($id){
     
        
        $r = Db::table('produtos')->where(['id'=>$id])->get();
        $ri = Db::table('produtos_imagens')->where(['id_produto'=>$id])->get();
     
        return view('produtos/editar')->with(['r'=>$r[0],'ri'=>$ri] );
        
    }
    
    function update(ProdutosRequest $r){
        
      
        
        
        DB::table('produtos')
        ->where('id',Request::input('id'))
        ->update([
            
            'descricao'=>Request::input('descricao'),
            'detalhes'=>Request::input('detalhes'),
            'idempresa'=>Auth::user()->idempresa,
            'cod_barra'=>Request::input('cod_barra'),
            'ficha'=>Request::input('ficha'),
            'geral'=>Request::input('geral') ? 'S': 'N',
            'ativo'=>Request::input('ativo') ? 'S': 'N'
            
            
        ]);
        
        if(Request::input('apaga')){
            $ri = Db::table('produtos_imagens')
            ->select('imagem')
            ->where(['id_produto'=>Request::input('id')])
            ->get();
            
            
            foreach($ri as $e){
                if(file_exists(public_path('/produtos/' . $e->imagem))){
                    unlink(public_path('/produtos/' . $e->imagem));
                    
                }
                if(file_exists(public_path('/produtos/min' . $e->imagem))){
                    unlink(public_path('/produtos/min' . $e->imagem));
                }
            }
            
            DB::table('produtos_imagens')->where(['id_produto'=>Request::input('id')])->delete();
        }
        
        if(is_array(Request::file('imagens'))){
            foreach(Request::file('imagens') as $image){
                
                $name = sha1(Request::input('id')+ time()+ rand(1,99)).'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/produtos');
                
                $image_resize = Image::make($image->getRealPath());
                
                $h = (400 * $image_resize->height())/$image_resize->width();
                
                $image_resize->resize(400, $h);
                $image_resize->save($destinationPath . '/min' . $name);
                
                $image->move($destinationPath, $name);
                
                DB::table('produtos_imagens')->insert([
                    'id_produto'=>Request::input('id'),
                    'imagem'=>$name
                    
                ]);
            }
        }
        
        
        
        return redirect()->action('ProdutosController@index')->with(['id' => Request::input('id'), 'desc'=> Request::input('nome')]);
    }
}
