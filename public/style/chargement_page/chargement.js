// Masquer la vidéo après 5 secondes
setTimeout(() => {
    const video = document.getElementById('background-video');
    if (video) {
        video.style.display = 'none';
    }
}, 5000);