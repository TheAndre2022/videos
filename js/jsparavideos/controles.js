document.addEventListener('DOMContentLoaded', function() {
    const video = document.getElementById('myVideo');
    const playButton = document.getElementById('play');

    playButton.addEventListener('click', function() {
        togglePlay(video, playButton);
    });

    function togglePlay(video, playButton) {
      
        if (video.paused) {
            video.play();
            playButton.innerHTML = "<img src = 'imagens/pause.svg' width = '25' height = '25' alt = 'Pause' >";
        } else {
            video.pause();
            playButton.innerHTML = "<img src = 'imagens/play.svg' width = '25' height = '25' alt = 'Play' >";
        }
    }
});
