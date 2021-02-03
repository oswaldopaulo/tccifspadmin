<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;
use FlyingLuscas\Correios\Client;
use FlyingLuscas\Correios\Service;
use Canducci\ZipCode\Facades\ZipCode;
use Canducci\ZipCode\ZipCodeException;

class ApiController extends ControllerOpen
{
 
    
       
    function getcep($token, $cep){
        
        $empresa = DB::table('empresas')->where(['token'=>$token])->get();
        
        if(!isset($empresa[0])){
            $resultado['erro']="token invalido";
            return response()->json($resultado);
        } 
        
        
        try{
            $r = ZipCode::find($cep);
        }catch(ZipCodeException $e){
             $resultado['erro']="cep invalido";
            return response()->json($resultado);
        }
        
        
        
        if($r){
             return response()->json($r->getArray());
        } else {
            $resultado['erro']="cep invalido";
            return response()->json($resultado);
        }
    }
    
    function getfrete($token, $cep){
        
        $empresa = DB::table('empresas')->where(['token'=>$token])->get();
        
        if(!isset($empresa[0])){
            $resultado['erro']="token invalido";
            return response()->json($resultado);
        } 
        
        
    
        
        $webservice_url     = 'http://webservice.kinghost.net/web_frete.php';
        $webservice_query    = array(
        'auth'    => '999999999999999999999999999999999999', //Chave de autenticação do WebService - Consultar seu painel de controle
        'formato' => 'json', //Valores possíveis: xml, query_string ou javascript
        'tipo'      => 'sedex',         //Tipo de pesquisa: sedex, carta, pac,
        'cep_origem'  => '18209245',      //CEP de Origem - CEP que irá postar a encomenda
        'cep_destino' => $cep,      //CEP de Destino - CEP que irá receber a encomenda
        'mao_propria' => '0', //Serviço adicional - Mão própria (MP), para utilizar valor "S" ou "1"
        'aviso_de_recebimento' => '0', //Serviço adicional - Mão própria (MP), para utilizar valor "S" ou "1"
        'peso'         => 450, //em gr
        'cep'          => '18209245',      //CEP que será pesquisado
        );

        //Forma URL
        $webservice_url .= '?';
        foreach($webservice_query as $get_key => $get_value){
        $webservice_url .= $get_key.'='.urlencode($get_value).'&';
        }
        
       
      // parse_str(file_get_contents($webservice_url), $resultado);
        
   //  Initiate curl
        $ch = curl_init();
        // Will return the response, if false it print the response
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Set the url
        curl_setopt($ch, CURLOPT_URL,$webservice_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        // Execute
        $resultado=curl_exec($ch);
        // Closing
        curl_close($ch);

        // Will dump a beauty json :3
        //var_dump(json_decode($result, true));
       
        $resultado = json_decode($resultado, true);
        $resultado['tipo'] = 'sedex';
       // $resultado = json_encode($resultado);
        
        
        
        $webservice_url     = 'http://webservice.kinghost.net/web_frete.php';
        $webservice_query    = array(
        'auth'    => '999999999999999999999999999999999999', //Chave de autenticação do WebService - Consultar seu painel de controle
        'formato' => 'json', //Valores possíveis: xml, query_string ou javascript
        'tipo'      => 'pac',         //Tipo de pesquisa: sedex, carta, pac,
        'cep_origem'  => '18209245',      //CEP de Origem - CEP que irá postar a encomenda
        'cep_destino' => $cep,      //CEP de Destino - CEP que irá receber a encomenda
        'mao_propria' => '0', //Serviço adicional - Mão própria (MP), para utilizar valor "S" ou "1"
        'aviso_de_recebimento' => '0', //Serviço adicional - Mão própria (MP), para utilizar valor "S" ou "1"
        'peso'         => 450, //em gr
        'cep'          => '18209245',      //CEP que será pesquisado
        );

        //Forma URL
        $webservice_url .= '?';
        foreach($webservice_query as $get_key => $get_value){
        $webservice_url .= $get_key.'='.urlencode($get_value).'&';
        }
        
       
      // parse_str(file_get_contents($webservice_url), $resultado);
        
   //  Initiate curl
        $ch = curl_init();
        // Will return the response, if false it print the response
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Set the url
        curl_setopt($ch, CURLOPT_URL,$webservice_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        // Execute
        $resultado2=curl_exec($ch);
        // Closing
        curl_close($ch);

        // Will dump a beauty json :3
        //var_dump(json_decode($result, true));
       
        $resultado2 = json_decode($resultado2, true);
        $resultado2['tipo'] = 'pac';
        
        $resultado = array($resultado, $resultado2);
        
        return response()->json($resultado); 
      
      
     
     
       
       
    }
    
  
    
    
    
}
