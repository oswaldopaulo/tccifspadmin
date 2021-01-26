@extends('default')
@section('content')  
@include('modalremover')
<script type="text/javascript">
	function novo() {
		
		window.location.href = "{{ url('cadastros/departamentos/novo')}}";
	}
</script>
<style>
 td {
    white-space: nowrap;
 }
</style>

<main>
    <div class="container-fluid">
        <h1 class="mt-4">Departamentos</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ url ('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Departamentos</li>
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
            <div class="card-header">
                 <i class="fas fa-table mr-1"></i>
                               Cadastros
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width ="100%" cellspacing="0">
                        <thead>
                            <tr>
                            	<th></th>
                                <th>ID</th>
                                <th>Descriçao</th>
                                <th>Imagem</th>
                                <th>Ativo</th>
                                
                               
                            </tr>
                        </thead>
              
                        <tbody>
                        @foreach($t as $r)
                            <tr>
                            	<td style="text-align: right"><a href="{{ url('cadastros/departamentos/editar/' . $r->id)}}"> <i class="fas fa-edit mr-1 blue"></i></a><a href="#" onclick="modal('{{ url('cadastros/departamentos/remove/' . $r->id) }}')"><i class="fas fa-trash-alt mr-1 red"></i></a></td>
                                <td>{{$r->id}} </td>
                                <td>{{$r->descricao}}</td>
                                <td>@if($r->icone)<img src="{{asset('icones/' . $r->icone)}}" alt="Minha Figura" height="32" width="32">@endif</td>
                                <td>{{$r->ativo}}</td>
                                
                           
                            </tr>
                          
                         @endforeach
     
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
 @endsection        
