
(function() {
    var video = document.getElementById('video'),
        canvas = document.getElementById('canvas'),
        context = canvas.getContext('2d');

    navigator.getMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia;

    navigator.getMedia({
       video: true,
       audio: false
    }, function(stream) {
       video.srcObject = stream;
       video.play();
    }, function(error) {
    });
    document.getElementById('capture').addEventListener('click', function() {
    context.drawImage(video, 0, 0, 500, 375);
    document.getElementById("canvas").style.zIndex = "1";
});
})();

function camReset() {
    document.getElementById("canvas").style.zIndex = "-1";
 }

