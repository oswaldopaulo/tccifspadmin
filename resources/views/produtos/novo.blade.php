@extends('default')
@section('content')  
<script type="text/javascript">
$(document).ready(function() {
    $('#ficha').summernote({
      height:300,
    });
});
    
</script>
<script type="text/javascript">
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#img')
                .attr('src', e.target.result)
                .width(64)
                .height(64);
        };

        reader.readAsDataURL(input.files[0]);
    }
}

</script>

<main>
    <div class="container-fluid">
        <h1 class="mt-4">Produtos</h1>
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
                
              
			<form role="form" action="{{ url('cadastros/produtos/novo')}}" class="form" method="post" enctype="multipart/form-data">
			 <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
			 
			 <div class="form-group row">
                    <label for="descricao" class="col-sm-1 col-form-label">Descrição</label>
                    <div class="col-sm-11">
                      <input type="text" name="descricao" id="descricao" class="form-control"  required value="{{old('descricao')}}">
                    </div>
              </div>   
			 
                    
                 <div class="form-group row">
                    <label for="cod_barra" class="col-sm-1 col-form-label">C.Barras</label>
                    <div class="col-sm-11">
                      <input type="number" name="cod_barra" id="cod_barra" class="form-control"  value="{{old('cod_barra') }}">
                    </div>
              </div> 
                
                
             	<div class="form-group row">
             	 <label for="imagens" class="col-sm-1 col-form-label"></label>
                   
                    <div class="form-check">
                                <input id="geral" name="geral" type="checkbox"  class="form-check-input" value="1" @if(old('geral')=='S') checked @endif>
    							<label class="form-check-label" for="geral" >Geral? (Marcando essa opção o produto poderá ser compartilhados com o sistema)</label>
							</div>
                          
             	</div>
    		
            	
				
             	
             	<div class="form-group row">
             	 <label for="imagens" class="col-sm-1 col-form-label">Imagens</label>
                    <div class="col-sm-5">
                      <input type="file" name="imagens[]" id="imagens" class="form-control"    multiple="multiple"   accept="image/gif, image/jpeg, image/png, imagen/svg">
                    </div>
                            
             	</div>
               
            
             	
             	<div class="form-group row">
                    <label for="detalhes" class="col-sm-1 col-form-label">Detalhes</label>
                    <div class="col-sm-11">
                    
                    <textarea  class="form-control" name="detalhes" id="detalhes" rows="3" cols="">{{old('detalhes') }}</textarea>
                   
                 </div>
                 </div>
                
                <div class="form-group row">
                    <label for="ficha" class="col-sm-1 col-form-label">Ficha</label>
                    <div class="col-sm-11">
                    
                    <textarea  class="form-control" name="ficha" id="ficha" rows="3" cols="">{{old('ficha') }}</textarea>
                   
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

 @endsection        
