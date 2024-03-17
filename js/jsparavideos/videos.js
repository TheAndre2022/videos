var meuVideo = document.getElementById('myVideo');
var progressoSpan = document.getElementById('progresso');
var chave = document.getElementById('logado');

// Adicione um ouvinte de evento 'ended' ao seu vídeo
meuVideo.addEventListener('ended', function() {
    // Este bloco de código será executado quando o vídeo terminar
   
    window.location.replace("https://oliveira2022.jumpingcrab.com/videoplayer.php");
  
    // Não é necessário retornar false aqui, pois não afeta o comportamento padrão do evento 'ended'
});


meuVideo.addEventListener('timeupdate', function() {
            atualizarRegistroDeAndamento();
    });



//setTimeout(atualizarRegistroDeAndamento(), 7000);
atualizarRegistroDeAndamento();  

function atualizarRegistroDeAndamento() {
    var playbackTime = Math.floor(meuVideo.currentTime);
    var chave = document.getElementById('logado');
  
    var url = 'https://oliveira2020.zanity.net/ajaxinfos/quevideoestatocando.php?chave=' + chave.value + '&playback_time=' + playbackTime;

    // Faz a requisição usando XMLHttpRequest
    var xhr = new XMLHttpRequest();
    xhr.open('GET', url, true);

    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 300) {

            
            var listaDeVideos = JSON.parse(xhr.responseText);
            var tocandoElement = document.getElementById('tocando1');
            var tocand2Element = document.getElementById('tocando2');
          
     
            tocandoElement.innerHTML = "<center>" + listaDeVideos  ['ouvindoagora'] ['0'] ['div'] +  listaDeVideos  ['ouvindoagora'] ['1'] ['div']
            +  listaDeVideos  ['ouvindoagora'] ['2'] ['div']  + listaDeVideos  ['ouvindoagora'] ['3'] ['div'] +   listaDeVideos  ['ouvindoagora'] ['4'] ['div'] 
            +  listaDeVideos  ['ouvindoagora'] ['5'] ['div']  + listaDeVideos  ['ouvindoagora'] ['6'] ['div'] +   listaDeVideos  ['ouvindoagora'] ['7'] ['div'] 
            +  listaDeVideos  ['ouvindoagora'] ['8'] ['div']  + listaDeVideos  ['ouvindoagora'] ['9'] ['div'] + "</center>" ;  
            

            tocand2Element.innerHTML =   "<center>" + listaDeVideos ['sugestoes']  ['10'] ['div'] +  listaDeVideos ['sugestoes']  ['11'] ['div']
            +  listaDeVideos  ['sugestoes'] ['12'] ['div']  + listaDeVideos ['sugestoes']  ['13'] ['div'] +   listaDeVideos ['sugestoes']  ['27'] ['div'] 
            +  listaDeVideos  ['sugestoes'] ['15'] ['div']  + listaDeVideos   ['sugestoes'] ['16'] ['div'] +   listaDeVideos ['sugestoes']  ['17'] ['div'] 
            +  listaDeVideos ['sugestoes']  ['18'] ['div']  + listaDeVideos  ['sugestoes'] ['19'] ['div']  +  listaDeVideos ['sugestoes']  ['20'] ['div'] 
            +  listaDeVideos ['sugestoes']  ['21'] ['div']  + listaDeVideos  ['sugestoes'] ['22'] ['div']  +  listaDeVideos ['sugestoes']  ['23'] ['div'] 
            +  listaDeVideos ['sugestoes']  ['24'] ['div']  + listaDeVideos  ['sugestoes'] ['25'] ['div']  +  listaDeVideos ['sugestoes']  ['26'] ['div'] 
            +  listaDeVideos ['sugestoes']  ['27'] ['div']  + listaDeVideos  ['sugestoes'] ['28'] ['div']  +  listaDeVideos ['sugestoes']  ['29'] ['div'] 
            +  listaDeVideos ['sugestoes']  ['30'] ['div']  + listaDeVideos  ['sugestoes'] ['31'] ['div']  +  listaDeVideos ['sugestoes']  ['32'] ['div'] 
            +  listaDeVideos ['sugestoes']  ['38'] ['div']  + listaDeVideos  ['sugestoes'] ['37'] ['div']  +  listaDeVideos ['sugestoes']  ['36'] ['div'] 
            +  "</center>";  






        } else {
            console.error('Erro ao atualizar o registro de andamento do vídeo.');
        }
    };

    xhr.onerror = function() {
        console.error('Erro de rede ao atualizar o registro de andamento do vídeo.');
    };

    xhr.send();
}

