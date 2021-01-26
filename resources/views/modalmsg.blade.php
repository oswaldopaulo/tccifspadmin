<script type="text/javascript">


	function modal(msg){

		
		  $('#msg').html(msg);
		  $("#ModalRemover").modal("show");
	}


</script>

<!-- Modal -->
<div class="modal fade" id="ModalRemover" tabindex="-1" role="dialog" aria-labelledby="ModalRemoverTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Informação</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="msg">
        
      </div>
      <div class="modal-footer">
      	<input type="hidden" name="RemoveId" id="RemoveId" value=""/>
        <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
        
      </div>
    </div>
  </div>
</div>