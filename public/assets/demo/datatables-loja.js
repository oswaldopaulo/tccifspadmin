// Call the dataTables jQuery plugin
$(document).ready(function() {
 $('#dataTable').DataTable({
	  dom: 'Bfrti',
	  
	  
	  buttons: {
		    dom: {
		      button: {
		        tag: 'button',
		        className: ''
		      }
		    },
		    buttons: [
	    	 {
	 		 
	 		      className: 'btn btn-primary xmargin-b',
	 		      titleAttr: 'Salvar Tudo.',
	 		      text: 'Salvar Tudo',
	 		     action: function(e, dt, node, config) {
	 	            formtable.submit();
	 	          }
	 		 },	
		    	
    	  
    	
		    
		    
		 
		    
		    ]
		  },
	  "oLanguage": {
			"sProcessing": "Processando...",
			"sLengthMenu": "Mostrar _MENU_ registros",
			"sZeroRecords": "Não foram encontrados resultados",
			"sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
			"sInfoEmpty": "Mostrando de 0 até 0 de 0 registros",
			"sInfoFiltered": "(filtrado de _MAX_ registros no total)",
			"sInfoClienteFix": "",
			"sSearch": "Buscar:",
			"sUrl": "",
			"oPaginate": {
				"sFirst":    "Primeiro",
				"sPrevious": "Anterior",
				"sNext":     "Seguinte",
				"sLast":     "ultimo"
			},
	  }
	  
  });

});


