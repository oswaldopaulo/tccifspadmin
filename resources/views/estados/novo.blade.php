@extends('default')
@section('content')  

<main>
    <div class="container-fluid">
        <h1 class="mt-4">Estados</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ url ('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Novo Cadastro</li>
        </ol>
        <!-- 
        <div class="card mb-4">
        
            <div class="card-body">
         		
             
            </div>
        </div>
         -->
        <div class="card mb-4">
            <div class="card-header">
                 <i class="fas fa-table mr-1"></i>
                               Novo Cadastros
            </div>
            
           
            <div class="card-body">
              
                 @if (!empty($errors->all())) 
                    	<div class="alert alert-danger col-lg-12">
                    	<ul>
                    	@foreach ($errors->all() as $error)
                    		<li>{{ $error }}</li>
                    	@endforeach
                    	</ul>
                    	</div>
                    @endif  
                
              
			<form role="form" action="{{ url('cadastros/estados/novo')}}" class="form" method="post">
			 <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
				 <div class="form-group row">
                    <label for="name" class="col-sm-1 col-form-label">Nome</label>
                    <div class="col-sm-4">
                      <input type="text" name="nome_estado" id="nome_estado" class="form-control"  required value="{{old('nome_estado')}}">
                    </div>
                      <label for="uf_estado" class="col-sm-1 col-form-label">UF</label>
                    <div class="col-sm-2">
                      <input type="text" name="uf_estado" id="uf_estado" class="form-control" required value="{{old('uf_estado')}}">
                    </div>
                    
                   <label for="codigo_estado" class="col-sm-1 col-form-label">C. IBGE</label>
                    <div class="col-sm-3">
                      <input type="text" name="codigo_estado" id="codigo_estado" class="form-control"  required  value="{{old('codigo_estado')}}">
                    </div>
                 </div>	
				
        		
                 
                 
             
             	
                   
             
               
					
					<a href="{{ url('estados') }}"  class="btn btn-secondary">Cancelar</a>
					<button type="submit" class="btn btn-primary">Salvar</button>
				
            </form>
		 
                
                
                
                
            </div>
        </div>
    </div>
</main>
 @endsection        
