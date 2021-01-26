@extends('default')
@section('content')  
@include('modalmsg')

<main>
    <div class="container-fluid">
        <h1 class="mt-4">Motoristas</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ url ('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ url ('cadastros/motoristas') }}">Motoristas</a></li>
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
                
              
			<form role="form" action="{{ url('cadastros/motoristas/novo')}}" class="form" method="post">
			 <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
        			 
				 	<div class="form-group row">
                        <label for="nome" class="col-sm-1 col-form-label">Nome</label>
                        <div class="col-sm-5">
                          <input type="text" name="nome"  class="form-control"  required value="{{old('nome')}}">
                        </div>

                         <label for="cpf" class="col-sm-2 col-form-label">CPF/CNPJ</label>
                        <div class="col-sm-4">
                          <input type="text" name="cpf"  class="form-control"  required value="{{old('cpf')}}">
                        </div>
                        
                     
                            
             	    </div>  
                
                    <div class="form-group row">
                             <label for="email" class="col-sm-1 col-form-label">Email</label>
                            <div class="col-sm-11">
                              <input type="email" name="email"  class="form-control"  required value="{{old('email')}}">
                            </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="tipo_cnh" class="col-sm-1 col-form-label">T.CNH</label>
                        <div class="col-sm-2">
                          <input type="text" name="tipo_cnh"  class="form-control"  value="{{old('tipo_cnh')}}">
                        </div>

                         <label for="cnh" class="col-sm-1 col-form-label">CNH</label>
                        <div class="col-sm-4">
                          <input type="text" name="cnh"  class="form-control"  value="{{old('cnh')}}">
                        </div>
                          <label for="validade_cnh" class="col-sm-1 col-form-label">Validade</label>
                        <div class="col-sm-3">
                          <input type="date" name="validade_cnh"   class="form-control"  value="{{old('validade_cnh')}}">
                            
                        </div>
                        
                     </div>
                
                    <div class="form-group row">
                        <label for="telefone" class="col-sm-1 col-form-label">Telefone</label>
                        <div class="col-sm-3">
                          <input type="text" name="telefone"  class="form-control"  value="{{old('telefone')}}">
                        </div>

                         <label for="celular" class="col-sm-1 col-form-label">Celular</label>
                        <div class="col-sm-3">
                          <input type="text" name="celular"  class="form-control"  value="{{old('celular')}}">
                        </div>
                          <label for="cep_end" class="col-sm-1 col-form-label">CEP</label>
                        <div class="col-sm-3 input-group">
                          <input type="text" name="cep_end" id="cep_end"  class="form-control"  value="{{old('cep')}}">
                             <div class="input-group-append">
                            <button class="btn btn-primary" type="button"  onClick="getcep(cep_end.value)"title="Baixar do ViaCep"><i class="fas fa-cloud-download-alt"></i></button>
                        </div>
                        </div>
                        
                     </div>
                
                    
                    <div class="form-group row">
                      
                        
                         <label for="des_end" class="col-sm-1 col-form-label">Endereço</label>
                        <div class="col-sm-5">
                          <input type="text" name="des_end" id="des_end"  class="form-control"  value="{{old('des_end')}}">
                        </div>
                        
                        <label for="num_end" class="col-sm-1 col-form-label">Nº</label>
                        <div class="col-sm-2">
                          <input type="text" name="num_end" id="num_end"  class="form-control"  value="{{old('num_end')}}">
                        </div>
                        
                          <label for="compl_num_end" class="col-sm-1 col-form-label">Compl.</label>
                        <div class="col-sm-2">
                          <input type="text" name="compl_num_end" id="compl_num_end"  class="form-control"  value="{{old('compl_num_end')}}">
                        </div>
                      
                     </div> 
                
                <div class="form-group row">
                    
                    
                         <label for="bairro" class="col-sm-1 col-form-label">Bairro</label>
                        <div class="col-sm-4">
                          <input type="text" name="bairro" id="bairro"  class="form-control"  value="{{old('bairro')}}">
                        </div>
                    
                      <label for="des_cidade" class="col-sm-1 col-form-label">Cidade</label>
                        <div class="col-sm-3">
                          <input type="text" name="des_cidade" id="des_cidade"  class="form-control"  value="{{old('des_cidade')}}">
                        </div>
                        
                         <label for="des_uf" class="col-sm-1 col-form-label">UF</label>
                        <div class="col-sm-2">
                          <input type="text" name="des_uf" id="des_uf"  class="form-control"  value="{{old('des_uf')}}">
                        </div>
                    
                       
                       
                    
                     </div>  
                
                  <div class="form-group row">
                      <label for="observacao" class="col-sm-1 col-form-label">Observação</label>
                        <div class="col-sm-11">
                            <textarea name="observacao" id="observacao"   rows="5" class="form-control">{{old('observacao')}}</textarea>
                         
                        </div>
                    </div>
               
        		 <div class="form-group">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="S" id="ativo" name="ativo"  checked>
                      <label class="form-check-label" for="ativo">
                       Ativo 
                      </label>
                    </div>
                  </div>
                 
                 
             
             	
        
               
					
					<a href="{{ url()->previous() }}"  class="btn btn-secondary">Cancelar</a>
					<button type="submit" class="btn btn-primary">Salvar</button>
				
            </form>
		 
                
                
                
                
            </div>
        </div>
    </div>
</main>
<script type="text/javascript" src="{{ asset('js/getcep.js')}}"/></script>
 @endsection        
