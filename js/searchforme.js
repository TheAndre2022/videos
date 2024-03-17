function search_form() {
    event.preventDefault();
    // Obter valor do campo de entrada
    var nome = document.querySelector("input[name='termo']").value;

    if (nome.length <= 3) {
        // Se o comprimento do nome for menor ou igual a 3, retorne nulo
        return null;
    }

    // Se todas as validações passarem, envie o formulário usando AJAX
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "https://oliveira2020.zanity.net/ajaxinfos/search.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    var keys = "termo=" + encodeURIComponent(nome);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                var listaDeVideos = JSON.parse(xhr.responseText);

                if (listaDeVideos && listaDeVideos.login === "sucesso") {
                    var tocandoElement = document.getElementById('tocando3');
                    var linhas = listaDeVideos['ouvindoagora']['totallinhas']; 
                   
                    if (linhas > 1) {
                        var htmlContent = "<center>";
                    
                        for (var i = 0; i < linhas; i++) {
                            htmlContent += listaDeVideos['ouvindoagora'][i];
                        }
                    
                        htmlContent += "</center>";
                        tocandoElement.innerHTML = htmlContent;
                    }
                   
               
                } else {
                    // Não faça nada aqui
                    // se não houver nada, retorne graciosamente
                }
            } else {
                console.error("Erro ao enviar dados via AJAX:", xhr.statusText);
            }
        }
    };

    xhr.send(keys);

    // Impedir o envio padrão do formulário
    return false;
}
