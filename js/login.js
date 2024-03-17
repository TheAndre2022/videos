// script.js

function enviarFormulario() {
    event.preventDefault();
    // Obter valores dos campos de entrada
    var nome = document.querySelector("input[name='usuario']").value;
    var senha = document.querySelector("input[name='senha']").value;
    var action = document.querySelector("input[name='action']").value;
    var chave = document.querySelector("input[name='chave']").value;
console.log (nome); 

    // Realizar validações, por exemplo:
    if (nome.trim() === "") {
        alert("Por favor, preencha o campo Nome.");
        return false;
    }

    if (senha.trim() === "") {
        alert("Por favor, preencha o campo Senha.");
        return false;
    }

    if (action.trim() === "") {
        alert("Algo errado em seu código, entre em contato com o suporte!");
        return false;
    }
    if (chave.trim() === "") {
        alert("Algo errado em seu código, entre em contato com o suporte!");
        return false;
    }


    // Se todas as validações passarem, envie o formulário usando AJAX
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "login/menulogin.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    var keys = "nome=" + encodeURIComponent(nome) + "&senha=" + encodeURIComponent(senha)
    + "&action=" +  encodeURIComponent(action) + "&chave=" + encodeURIComponent(chave);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);

                if (response && response.login === "sucesso") {
                   // location.reload();
                   window.location.replace ('https://oliveira2022.jumpingcrab.com/index.php');
                } else {
                    alert("Login falhou. Verifique suas credenciais.");
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
