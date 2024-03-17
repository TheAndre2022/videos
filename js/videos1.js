var meuVideo = document.getElementById('myVideo');
var progressoSpan = document.getElementById('progresso');
var chave = document.getElementById('logado');


meuVideo.addEventListener('timeupdate', function() {
    var progresso = (meuVideo.currentTime / meuVideo.duration) * 100;

    // Verifica se progresso é NaN
    if (isNaN(progresso)) {
        progresso = 0;
    }

    // Atualiza o registro de andamento do vídeo a cada 10 segundos
    if (Math.floor(meuVideo.currentTime) % 10 === 0) {
        atualizarRegistroDeAndamento();
    }
});

setTimeout(atualizarRegistroDeAndamento(), 7000);
atualizarRegistroDeAndamento() 

function atualizarRegistroDeAndamento() {
    var playbackTime = Math.floor(meuVideo.currentTime);
    
    var url = 'https://oliveira2020.zanity.net/ajaxinfos/quevideoestatocando.php?chave=' + chave.value + '&playback_time=' + playbackTime;

    // Faz a requisição usando XMLHttpRequest
    var xhr = new XMLHttpRequest();
    xhr.open('GET', url, true);

    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 300) {

            
            var listaDeVideos = JSON.parse(xhr.responseText);
            var tocandoElement = document.getElementById('tocando1');
            var tocand2Element = document.getElementById('tocando2');
          
     
            tocandoElement.innerHTML = listaDeVideos  ['ouvindoagora'] ['0'] ['div'] +  listaDeVideos  ['ouvindoagora'] ['1'] ['div']
            +  listaDeVideos  ['ouvindoagora'] ['2'] ['div']  + listaDeVideos  ['ouvindoagora'] ['3'] ['div'] +   listaDeVideos  ['ouvindoagora'] ['4'] ['div'] 
            +  listaDeVideos  ['ouvindoagora'] ['5'] ['div']  + listaDeVideos  ['ouvindoagora'] ['6'] ['div'] +   listaDeVideos  ['ouvindoagora'] ['7'] ['div'] 
            +  listaDeVideos  ['ouvindoagora'] ['8'] ['div']  + listaDeVideos  ['ouvindoagora'] ['9'] ['div'] ;  
            

            tocand2Element.innerHTML =  listaDeVideos ['sugestoes']  ['10'] ['div'] +  listaDeVideos ['sugestoes']  ['11'] ['div']
            +  listaDeVideos  ['sugestoes'] ['12'] ['div']  + listaDeVideos ['sugestoes']  ['13'] ['div'] +   listaDeVideos ['sugestoes']  ['14'] ['div'] 
            +  listaDeVideos  ['sugestoes'] ['15'] ['div']  + listaDeVideos   ['sugestoes'] ['16'] ['div'] +   listaDeVideos ['sugestoes']  ['17'] ['div'] 
            +  listaDeVideos ['sugestoes']  ['18'] ['div']  + listaDeVideos  ['sugestoes'] ['19'] ['div'] ;  


        } else {
            console.error('Erro ao atualizar o registro de andamento do vídeo.');
        }
    };

    xhr.onerror = function() {
        console.error('Erro de rede ao atualizar o registro de andamento do vídeo.');
    };

    xhr.send();
}

//Aqui é outro script
//
        document.addEventListener("DOMContentLoaded", function () {
            var video = document.getElementById("myVideo");
            var videoSource = document.getElementById("videoSource");
          //  video.removeAttribute("controls");  

          function loadAndPlayVideo(videoNumber) {
            var chave = document.getElementById('logado');
            
            // Desativa os controles do vídeo
            video.removeAttribute("controls");
        
            // Carrega o próximo vídeo
            videoSource.src = `https://oliveira2022.jumpingcrab.com/streaming/videos-to-play.php?video=${videoNumber}&chave=${chave.value}`;
            video.load();
        
            // Define um evento para quando o vídeo estiver carregado
            video.onloadeddata = function() {
                // Ativa os controles do vídeo
               // video.setAttribute("controls", "true");
                
                // Inicia a reprodução do vídeo
                video.play();
            };
        }
        

            video.addEventListener("ended", function () {
    // Quando um vídeo termina, avança para o próximo
 
    window.location.reload();
 
 } );


            video.addEventListener("timeupdate", function () {
                // Salva o ponto de reprodução atual no localStorage
                if (typeof (Storage) !== "undefined") {
                    localStorage.setItem("videoTime", video.currentTime);
                }
            });

            // Verifica se há um ponto de reprodução salvo e o define
            if (typeof (Storage) !== "undefined" && localStorage.getItem("videoTime")) {
                video.currentTime = localStorage.getItem("videoTime");
            }

            // Adiciona event listener para teclas
            document.addEventListener("keydown", function (event) {
                switch (event.key) {
                    case "ArrowRight":
                        // Tecla para a próxima música
                        var nextVideoNumber = parseInt(videoSource.src.match(/unique_id=(\d+)/)[1]) + 1;
                        if (nextVideoNumber <= 70000) {
                            loadAndPlayVideo(nextVideoNumber);
                        }
                        break;

                    case "ArrowLeft":
                        // Tecla para a música anterior
                        var prevVideoNumber = parseInt(videoSource.src.match(/unique_id=(\d+)/)[1]) - 1;
                        if (prevVideoNumber >= 1) {
                            loadAndPlayVideo(prevVideoNumber);
                        }
                        break;

                    case "Home":
                        // Tecla para selecionar uma música específica (você pode ajustar conforme necessário)
                        var selectedVideoNumber = prompt("Digite o número da música desejada:");
                        if (selectedVideoNumber && !isNaN(selectedVideoNumber) && selectedVideoNumber >= 1 && selectedVideoNumber <= 70000) {
                            loadAndPlayVideo(parseInt(selectedVideoNumber));
                        }
                        break;

                    // Adicione outros casos conforme necessário
                }
            });
        });
 
// Seletor para todos os links de vídeo na página
var links = document.querySelectorAll("a.video-link");

// Iterar sobre cada link de vídeo
for (var i = 0; i < links.length; i++) {
    // Adicionar um evento de clique a cada link
    links[i].addEventListener("click", function(event) {
        // Impedir o comportamento padrão do link
        event.preventDefault();

        // Obtendo o URL do vídeo a partir do atributo href do link clicado
        var videoUrl = this.getAttribute("href");

        // Obtendo o unique_id do URL do vídeo
        var uniqueId = getUniqueIdFromUrl(videoUrl);

        // Atualizar o vídeo com o novo unique_id
        var videoElement = document.getElementById("myVideo");
        videoElement.src = "https://oliveira2022.jumpingcrab.com/streaming/videos-to-play.php?unique_id=" + uniqueId;
        videoElement.load();
        videoElement.play();

        // Retornar false para evitar recarregar a página
        return false;
    });
}
