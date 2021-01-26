@extends('default')
@section('content')  
@include('modalremover')

 <link href="{{ asset ('vendor/bootstrap-select-1.13.14/dist/css/bootstrap-select.min.css') }}" rel="stylesheet">
 <script src="{{ asset ('vendor/bootstrap-select-1.13.14/dist/js/bootstrap-select.min.js') }}"></script>

<script type="text/javascript">
	function submit() {
		
		window.location.href = "{{ url('cadastros/loja/novo')}}";
	}
</script>
<style>
 td {
    white-space: nowrap;
 }
</style>

<script type="text/javascript">
function setchange(idloja,campo){
	
	 $("#change-" + idloja).val("1");
	 $("#" + $(campo).attr("id")).attr("class", "change");
	
	
}

</script>

 <style media="screen" type="text/css">
+     td {
+       max-width: 120px;
+       white-space: nowrap;
+       text-overflow: ellipsis;
+     }
	  th {
+       max-width: 120px;
+       white-space: nowrap;
+       text-overflow: ellipsis;
+     }

        .change{
            background-color:LightPink;
        }
+    </style>

<main>
    <div class="container-fluid">
        <h1 class="mt-4">Loja</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ url ('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Loja</li>
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
                              Adicionar item a loja
            </div>
            
           
            <div class="card-body">
            
            <div class="row">
                
                
                <form  role="form" action="{{ url('/loja/novo') }}" method="post" class="form-inline">    
                          <input type="hidden"
										name="_token" value="{{{ csrf_token() }}}" />
                              <div class="form-group" style="padding: 5px">
                        		 <label for="idproduto">Produtos</label>
                                <select id="idproduto" name="idproduto" class="form-control selectpicker" data-live-search="true" required="required">
                                 @foreach($itens as $i)
                                              <option value="{{$i->id}}">{{ $i->descricao }}</option>
                                            @endforeach
                                </select>
                                </div>
                                <div class="form-group" style="padding: 5px" >
                                    <label for="preco">Preco R$</label>
                                    <input id="preco" name="preco" class="form-control"  value="{{ old('preco') }}" required="required" type="number" step="0.01">
                              </div>
                    
                            <div class="form-group" style="padding: 5px" >
                                    <label for="damanda">Estoque</label>
                                    <input id="demanda" name="demanda" class="form-control"  value="{{ old('demanda') }}" required="required" type="number" step="0.01">
                              </div>
                              <div class="form-group" style="padding: 5px">
                                    <label for="desconto">Desconto %</label>
                                    <input id="desconto" name="desconto" class="form-control"  value="{{ old('desconto') }}" required="required"  type="number" step="0.01">
                                </div>
                                <div class="form-group" style="padding: 5px">
                                <label for="datainicioloja">D. Ini.Loja</label>
                                <input id="datainicioloja" name="datainicioloja" class="form-control"  value="{{ old('datainicioloja') }}" required="required"  type="date">
                                
                                <label for="datafimloja">D. Fim Loja</label>
                                <input id="datafimloja" name="datafimloja" class="form-control"  value="{{ old('datafimloja') }}" required="required"  type="date">
                                </div>
                                <div class="form-group" style="padding: 5px">
                                <label for="datainiciopromo">D. Ini. Desc.</label>
                                <input id="datainiciopromo" name="datainiciopromo" class="form-control"  value="{{ old('datainiciopromo') }}"   type="date">
                              
                                <label for="datafimpromo">D. Ini. Desc.</label>
                                <input id="datafimpromo" name="datafimpromo" class="form-control"  value="{{ old('datafimopromo') }}"  type="date">
                              
                              </div>
                              <div class="form-group">
                              <button type="submit" class="btn btn-primary mb-2">Adicionar a loja</button>
                              </div>
                            </form>
            
             
             </div>
                        
            
         </div>
      </div>
        
        
        
        
        
        <div class="card mb-4">
            <div class="card-header">
                 <i class="fas fa-table mr-1"></i>
                               Produtos a venda
            </div>
              <form id='formtable' role="form" action="{{ url('/loja/saveall') }}" method="post"> 
                  	 <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width ="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Produto</th> 
                                <th>Estoque</th>  
                                <th>Preco (R$)</th> 
                                <th>Desconto %</th> 
                                <th>D. Ini. Loja</th>
                                <th>D. Fim. Loja</th>
                                <th>D. Ini. Desc</th>
                                <th>D. Fim. Desc</th>
                                <th>ativo</th>
                                
                               
                            </tr>
                        </thead>
                        
      
                        <tbody>
                        @foreach($t as $r)
                            <tr>
                            	<td style="text-align: right">	
                            									<a href="#" onclick="modal('{{ url('loja/remove/' . $r->idloja) }}')"><i class="fas fa-trash-alt mr-1 red"></i></a>
                            									
                            	</td>
                              
                                <td>{{$r->descricao}}<input id="change-{{$r->idloja}}" name="change-{{$r->idloja}}" type="hidden" value="0"></td>
                                                         
                                 <td><input id="demanda-{{$r->idloja}}" name="demanda-{{$r->idloja}}" type="number" step="1" value="{{ $r->demanda }}" onchange="setchange({{$r->idloja}},this)"  style="width: 40px" required/></td> 
                                 <td><input id="preco-{{$r->idloja}}" name="preco-{{$r->idloja}}" type="number" step="0.01" value="{{ $r->preco }}" onchange="setchange({{$r->idloja}},this)" required/></td> 
                                 <td><input id="desconto-{{$r->idloja}}" name="desconto-{{$r->idloja}}" type="number" step="0.01" value="{{ $r->desconto }}" onchange="setchange({{$r->idloja}},this)" required /></td> 
                                 <td><input id="datainicioloja-{{$r->idloja}}" name="datainicioloja-{{$r->idloja}}" type="date" value="{{$r->datainicioloja}}" onchange="setchange({{$r->idloja}},this)" required/></td>
                                 <td><input id="datafimloja-{{$r->idloja}}" name="datafimloja-{{$r->idloja}}" type="date" value="{{$r->datafimloja}}" onchange="setchange({{$r->idloja}},this)" required/></td>
                                 <td><input id="datainiciopromo-{{$r->idloja}}" name="datainiciopromo-{{$r->idloja}}" type="date" value="{{$r->datainiciopromo}}" onchange="setchange({{$r->idloja}},this)"/></td>
                                 <td><input id="datafimpromo-{{$r->idloja}}" name="datafimpromo-{{$r->idloja}}" type="date" value="{{$r->datafimpromo}}" onchange="setchange({{$r->idloja}},this)"/></td>
                                 <td><input id="ativo-{{$r->idloja}}" name="ativo-{{$r->idloja}}" type="checkbox" onchange="setchange({{$r->idloja}},this)" value="S" {{ $r->ativo=='S'?'checked="checked"':'' }} ></td>
                             

                           
                            </tr>
                          
                         @endforeach
     
                        </tbody>
                    </table>
                </div>
            </div>
            </form>
        </div>
    </div>
</main>
<script type="text/javascript">


 setInterval(function () {
    	 $('#msg').hide(); // show next div
    }, 5 * 1000); // do this every 10 seconds    


</script>
 @endsection        
