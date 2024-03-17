

var contagem = +localStorage.getItem("contagem"); // Antigo dono
window.addEventListener("storage", storageChanged, false);
localStorage.setItem("contagem", contagem+1); // Tenta se tornar o novo dono

function storageChanged(event) {
    if ( event.newValue <= contagem )    // Se o antigo dono ainda estiver por aí
        alert("Já tem uma aba aberta."); // Vai embora
    else                                              // Senão
        localStorage.setItem("contagem", contagem+1); // torna-se o novo dono
} 
