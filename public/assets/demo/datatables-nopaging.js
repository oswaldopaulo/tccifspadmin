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
	 		      titleAttr: 'Novo Registro.',
	 		      text: 'Novo',
	 		     action: function(e, dt, node, config) {
	 	           novo();
	 	          }
	 		 },	
		    	
    	   {
 		      extend: 'copy',
 		      className: 'btn btn-primary xmargin-b',
 		      titleAttr: 'Copy table data.',
 		      text: 'Copy'
 		    },
    	
		    {
		      extend: 'excel',
		      className: 'btn btn-primary xmargin-b',
		      titleAttr: 'Excel export.',
		      text: 'Excel',
		      filename: 'excel-export',
		      extension: '.xlsx'
		    },
 		   {
 		      extend: 'pdf',
 		      className: 'btn btn-primary xmargin-b',
 		      titleAttr: 'Excel export PDF.',
 		      text: 'PDF',
 		      filename: 'pdf-export',
 		      extension: '.pdf'
 		    }
		    
		 
		    
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


