@extends('default')
@section('content')  
@php 

    use \App\Http\Controllers\EstadosController;
    $empresas = App\Http\Controllers\EmpresasController::getempresas(); 


@endphp
<main>
    <div class="container-fluid">
        <h1 class="mt-4">Usuários</h1>
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
                
              
			<form role="form" action="{{ url('usuarios/novo')}}" class="form" method="post">
                
                   <div class="form-group">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="1" id="tipo" name="tipo">
                      <label class="form-check-label" for="tipo">
                       Administrador 
                      </label>
                    </div>
                     
                     
                     
                  </div>
               
			 <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
				 <div class="form-group row">
                    <label for="name" class="col-sm-1 col-form-label">Nome</label>
                    <div class="col-sm-11">
                      <input type="text" name="name" id="name" class="form-control"  required value="{{old('name')}}">
                    </div>
                 </div>	
				
                <div class="form-group row">
                         <label for="idfornecedor" class="col-sm-1 col-form-label">Fornecedor </label>
                         <div class="col-sm-3">
                            <select class="form-control"  name="idempresa"  placeholder="Empresa" required>  
                                            <option value="">Selecione</option>
                                        @if($empresas)
                                            @foreach($empresas as $f)
                                                <option value="{{ $f->id}}" @if(old('idempresa')==$f->id) selected @endif>{{ $f->nome .  ' ' . $f->cpf }}</option>
                                            @endforeach
                                        @endif
                            </select>
                        </div>
                    </div>
        		
                 <div class="form-group row">
                    <label for="username" class="col-sm-1 col-form-label">Usuário</label>
                    <div class="col-sm-2">
                      <input type="text" name="username" id="username" class="form-control" value="{{old('username')}}">
                    </div>
                    
                   <label for="email" class="col-sm-1 col-form-label">Email</label>
                    <div class="col-sm-8">
                      <input type="email" name="email" id="email" class="form-control"  required  value="{{old('email')}}">
                    </div>
                 </div>	
                 
                  <div class="form-group row">
                    <label for="password" class="col-sm-1 col-form-label">Senha</label>
                    <div class="col-sm-5">
                      <input type="password" name="password" id="password" class="form-control"  required>
                    </div>
                     <label for="password_confirmation" class="col-sm-1 col-form-label">Confirma</label>
                    <div class="col-sm-5">
                      <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                    </div>
                 </div>	
                  
             	 <div class="form-group row">
             	   <label for="cpf" class="col-sm-1 col-form-label">CPF</label>
                    <div class="col-sm-5">
                      <input type="text" name="cpf" id="cpf" class="form-control" value="{{old('cpf')}}">
                    </div>
                    <label for="telefone" class="col-sm-1 col-form-label">Telefone</label>
                    <div class="col-sm-5">
                      <input type="tel" name="telefone" id="telefone" class="form-control" value="{{old('telefone')}}">
                    </div>
                 </div>	
               
                <div class="form-group row">
                    <label for="cep" class="col-sm-1 col-form-label">CEP</label>
                    <div class="col-sm-2">
                      <input type="text" name="cep" id="cep" class="form-control" required value="{{old('cep')}}">
                    </div>
                     <label for="rua" class="col-sm-1 col-form-label">Rua</label>
                    <div class="col-sm-6">
                      <input type="text" name="rua" id="rua" class="form-control" required value="{{old('rua')}}">
                    </div>
                    <label for="numero" class="col-sm-1 col-form-label">Nº</label>
                    <div class="col-sm-1">
                      <input type="text" name="numero" id="numero" class="form-control" required value="{{old('numero')}}">
                    </div>
                 </div>	
                   <div class="form-group row">
                    <label for="bairro" class="col-sm-1 col-form-label">Bairro</label>
                    <div class="col-sm-4">
                      <input type="text" name="bairro" id="bairro" class="form-control" required value="{{old('bairro')}}">
                    </div>
                     <label for="cidade" class="col-sm-1 col-form-label">Cidade</label>
                    <div class="col-sm-4">
                      <input type="text" name="cidade" id="cidade" class="form-control" required value="{{old('cidade')}}">
                    </div>
                    <label for="uf" class="col-sm-1 col-form-label">UF</label>
                    <div class="col-sm-1">
                     
                     <select id="uf" name="uf"  class="form-control" required"> 
                		<option value="">Selecione o Estado</option> 
                		@foreach(EstadosController::arrayforoptions() as $e)
                			<option value="{{$e->uf_estado}}" @if(old('uf')=='{{$e->uf_estado}}') selected @endif>{{$e->nome_estado}}</option> 
                		@endforeach
              			
                	</select>

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
               
					
					<a href="{{ url('usuarios') }}"  class="btn btn-secondary">Cancelar</a>
					<button type="submit" class="btn btn-primary">Salvar</button>
				
            </form>
		 
                
                
                
                
            </div>
        </div>
    </div>
</main>
<script type="text/javascript">
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#img')
                .attr('src', e.target.result)
                .width(200)
                .height(auto);
        };

        reader.readAsDataURL(input.files[0]);
    }
}

</script>
 @endsection        
