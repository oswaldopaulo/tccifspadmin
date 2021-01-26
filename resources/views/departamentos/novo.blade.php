@extends('default')
@section('content')  

<main>
    <div class="container-fluid">
        <h1 class="mt-4">Departamentos</h1>
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
                
              
			<form role="form" action="{{ url('cadastros/departamentos/novo')}}" class="form" method="post" enctype="multipart/form-data">
			 <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
        			 <div class="form-group row">
        			 	<div style="margin-left: 10px"><img id="img" src="{{ asset('/icones/semimage.png')}}" alt="icone" style="width: 64px;height: 64px"> </div>
        			 </div>
				 	<div class="form-group row">
                    <label for="descricao" class="col-sm-1 col-form-label">Descrição</label>
                    <div class="col-sm-5">
                      <input type="text" name="descricao" id="descricao" class="form-control"  required value="{{old('descricao')}}">
                    </div>
                      <label for="imagem" class="col-sm-1 col-form-label">Imagem</label>
                    <div class="col-sm-5">
                      <input type="file" name="imagem" id="imagem" class="form-control"  value="{{old('imagem')}}" onchange="readURL(this)"  accept="image/gif, image/jpeg, image/png, imagen/svg">
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
                 
                 
             
             	
        
               
					
					<a href="{{ url('departamentos') }}"  class="btn btn-secondary">Cancelar</a>
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
                .width(64)
                .height(64);
        };

        reader.readAsDataURL(input.files[0]);
    }
}

</script>
 @endsection        
