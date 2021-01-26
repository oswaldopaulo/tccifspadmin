<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    function index(){
      
           
        $t =  DB::table('vi_fluxo');
        
        
        if(Request::input('origem')!=  null){
            $t->where(['origem'=>Request::input('origem')]);
        }
        
        if(Request::input('descricao')!=  null){
            $t->where(['descricao'=>Request::input('descricao')]);
        }
        
        if(Request::input('datainicio')!=  null){
            $t->where('data','>=',Request::input('datainicio'));
        }
        
        
        if(Request::input('datafim')!=  null){
            $t->where('data','<=',Request::input('datafim'));
        }
        
        if(Request::input('placa')!=  null){
            $t->where(['placa'=>Request::input('placa')]);
        }
        
        if(Request::input('motoristas')!=  null){
            $t->where(['motoristas'=>Request::input('placa')]);
        }
        
        $t =  $t->get();
        
        
        $tipos = DB::table('vi_fluxo')
        ->select('origem')
        ->distinct()
        ->get();
        
        
        $desc = DB::table('vi_fluxo')
        ->select('descricao')
        ->distinct()
        ->get();
           
		
		session()->flashInput(Request::input());
           
        return view('dashboard/index')->with(['t' =>$t,'tipos'=>$tipos,'desc'=>$desc]);
    }
    
    
   
    
   
   
    
    
}

