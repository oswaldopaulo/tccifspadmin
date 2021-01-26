<script type="text/javascript">


	function modal(id){

		
		  $('#RemoveId').val(id);
		  $("#ModalRemover").modal("show");
	}

	function remove (){
		//alert($('#RemoveId').val());
		
		window.location.href =  $('#RemoveId').val();
	}
</script>

<!-- Modal -->
<div class="modal fade" id="ModalRemover" tabindex="-1" role="dialog" aria-labelledby="ModalRemoverTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Confirmação</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Confirma exclusão do registro?
      </div>
      <div class="modal-footer">
      	<input type="hidden" name="RemoveId" id="RemoveId" value=""/>
        <button type="button" class="btn btn-primary" data-dismiss="modal">Não</button>
        <button type="button" class="btn btn-primary" onclick="remove()">Sim</button>
      </div>
    </div>
  </div>
</div>