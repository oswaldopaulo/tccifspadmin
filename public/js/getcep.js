function getcep(cep){
	if (cep.length > 0 && cep.length==8) {
        fetch("https://viacep.com.br/ws/" + cep + "/json/").then(function(response) {
          var contentType = response.headers.get("content-type");
          if(contentType && contentType.indexOf("application/json") !== -1) {
            return response.json().then(function(json) {
              // process your JSON further


                              console.log(json.logradouro);

                            des_end.value  = json.logradouro;
                            des_cidade.value  = json.localidade;
                            des_uf.value  = json.uf;
                            bairro.value = json.bairro;
                
                
                           
                           
                
                            /*

                           
                            bairro: "Vila Nova"
                            'cep: "18200-420"
                            complemento: ""
                            ddd: "15"
                            gia: "3712"
                            ibge: "3522307"
                            localidade: "Itapetininga"
                            logradouro: "Rua Fermino José de Araújo"
                            siafi: "6547"
                            uf: "SP"'
                          
                            */



            });

          } else {
            console.log("Oops, we haven't got JSON!");
          }
        });
    
    } else {
        console.log("Cep invalido");
		modal("Cep invalido ou não encotrado");
    }
}