@extends('default')
@section('content')  
@include('modalremover')
@php $te = 0; $ts = 0 @endphp

@php 
    $veiculos = App\Http\Controllers\FrotaController::getfrota();
    $motoristas = App\Http\Controllers\MotoristasController::getmotoristas();
    $fornecedores = App\Http\Controllers\FornecedoresController::getfornecedores();
    $tipodespesas = App\Http\Controllers\TipodespesasController::gettipodespesasfrete();

@endphp

 
<script type="text/javascript">
	function novo() {
		
		window.location.href = "#";
	}
</script>
<style>
 td {
    white-space: nowrap;
 }
	
.option-color{
    background-color: tomato;
}
</style>

<main>
    <div class="container-fluid">
        <h1 class="mt-4">Despesas </h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ url ('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Despesas</li>
        </ol>
        
        
                   @if (!empty($errors->all())) 
                    	 <div class="card bg-danger text-white mb-4 card mb-4" id="msg" style="padding: 5px">
                        	<ul>
                        	@foreach ($errors->all() as $error)
                        		<li>{{ $error }}</li>
                        	@endforeach
                        	</ul>
                    	</div>
                    @endif
                  					 
                              
                       
       
  
          			@if(session('acao'))
                    	 @if(session('id'))
                    	  <div class="card bg-warning text-white mb-4 card mb-4" id="msg" style="padding: 5px">
                                    <div class="card-body">
                                    <strong>Sucesso!</strong>
                                   	O registro {{ session('id')  }}  foi deletado.
                                     </div>   
                                    
                                </div>
                     @endif
                    @else
                    	@if(session('id'))
        				 <div class="card bg-success text-white mb-4 card mb-4" id="msg" style="padding: 5px">
                        	<div class="card-body">
                            	<strong>Sucesso! </strong>
                            	O registro {{ session('id')  }} {{ session('desc')  }} foi gravado.
                           </div>
                        </div>
                    
                      @endif
                    @endif
                <div class="card mb-4">
                            <div class="card-body">
                                <h4>Pesquisa </h4>
                               <form action="{{ url('dashboard')}}" method="POST">
                                   <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                                    <div class="form-row">
                                        
                                        <div class="col-md-2 mb-3">
                                           <label for="origem">Origem</label>
                                          <select name="origem"  class="form-control">
                                              <option   value="">Todos</option>
                                               @if(isset($tipos))
                                                   @foreach( $tipos as $tp)
                                                       <option value="{{ $tp->origem}}" @if(old('origem')==$tp->origem) class="option-color" selected  @endif>{{ $tp->origem }}</option>
                                                   @endforeach
                                               @endif

                                            </select>
                                        
                                        </div>
                                        
                                        
                                        <div class="col-md-2 mb-3">
                                           <label for="descricao">Descricao</label>
                                          <select name="descricao"  class="form-control" >
                                              <option value="">Todos</option>
                                               @if(isset($desc))
                                                   @foreach( $desc as $dc)
                                                       <option value="{{ $dc->descricao}}" @if(old('descricao')==$dc->descricao) class="option-color" selected  @endif>{{ $dc->descricao }}</option>
                                                   @endforeach
                                               @endif

                                            </select>
                                        
                                        </div>
                                        
                                        <div class="col-md-2 mb-3">
                                          <label for="datainicio">Data Inicial  </label>
                                          <input type="date" class="form-control" value="{{ old('datainicio', date('Y-m-d')) }}" name="datainicio" placeholder="Data Inicial">
                                        
                                        </div>
                                         <div class="col-md-2 mb-3">
                                          <label for="datafim">Data Final</label>
                                          <input type="date" class="form-control" value="{{ old('datafim')}}" name="datafim" placeholder="Data Final">
                                        
                                        </div>
                                        
                                        
                                       
                                         <div class="col-md-2 mb-3">
                                           <label for="placa">Veiculo</label>
                                          <select name="placa"  class="form-control">
                                              <option value="">Todos</option>
                                               @if(isset($veiculos))
                                                   @foreach( $veiculos as $v)
                                                       <option value="{{ $v->placa}}" @if(old('placa')==$v->placa) class="option-color" selected  @endif>{{ $v->modelo . ' ' . $v->placa}}</option>
                                                   @endforeach
                                               @endif

                                            </select>
                                        
                                        </div>
                                        
                                        <div class="col-md-2 mb-3">
                                           <label for="motoristas">Motorista</label>
                                            
                                          <select name="motoristas"  class="form-control">
                                                <option value="">Todos</option>
                                               @if(isset($motoristas))
                                                   @foreach( $motoristas as $m)
                                                       <option value="{{ $m->nome}}" @if(old('motoristas')==$m->nome) class="option-color" selected  @endif>{{ $m->nome }}</option>
                                                   @endforeach
                                               @endif
                                            </select>
                                        
                                        </div>
                                        
                                        
                                   </div>
                                     <button class="btn btn-primary" type="submit">Pesquisar</button>
                           			 <button class="btn btn-light" onClick="window.open({{ url('dashboard') }})">Mostrar Tudo</button>
                                </form>
                                
                            </div>
                        </div>
        <div class="card mb-4">
            <div class="card-header">
                 <i class="fas fa-table mr-1"></i>
                               Tabela
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width ="100%" cellspacing="0">
                        <thead>
                            <tr>
                            	
                                <th>ID</th>
                                <th>Origem</th>
                                <th>Descrição</th>
                                <th>Entrada</th>
                                <th>Saida</th>
                                <th>Data</th>
                                <th>Motorista</th>
                                 <th>Placa</th>
                                <th>Modelo</th>
                               
                                
                        
                            </tr>
                        </thead>
             
                        <tbody>
                        @foreach($t as $r)
                            <tr>
                            
                                <td>{{$r->idorigem}} </td>
                                <td>{{$r->origem}}</td>
                                   <td>{{$r->descricao}}</td>
                                 <td style="background-color:  cornflowerblue">{{$r->entrada }} @php $te += $r->entrada; $ts+= $r->saida  @endphp</td>
                                 <td style="background-color: darksalmon">{{$r->saida}}</td>
                                 <td>{{$r->data}}</td>
                                 <td>{{$r->motoristas}}</td>
                                 <td>{{$r->placa}}</td>
                                 <td>{{$r->modelo}}</td>
                            
                               
                        
                                
                           
                            </tr>
                          
                         @endforeach
                            
                               <thead>
                            <tr>
                            	
                                <th></th>
                                <th></th>
                                <th></th>
                                <th style="background-color:  cornflowerblue">{{ $te }}</th>
                                <th style="background-color: darksalmon">{{ $ts }}</th>
                                <th></th>
                                <th></th>
                                 <th></th>
                                <th></th>
                               
                                
                        
                            </tr>
                        </thead>
     
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
<script type="text/javascript">


 setInterval(function () {
    	 $('#msg').hide(); // show next div
    }, 5 * 1000); // do this every 10 seconds    


</script>
<script src="{{ asset('assets/demo/datatables-nopaging.js') }}"></script>
 @endsection        
