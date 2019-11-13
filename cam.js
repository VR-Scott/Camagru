
(function() {
    var video = document.getElementById('video'),
        canvas = document.getElementById('canvas'),
        context = canvas.getContext('2d');

    navigator.getMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia;
    upload = new Image();
    upload.src = "./tmp/tmp.png";
    upload.onload = function(){
        context.drawImage(upload, 0,0, 500, 375);
        document.getElementById("canvas").style.zIndex = "2";
        navigator.getMedia({
           video: true,
           audio: false
        }, function(stream) {
           video.srcObject = stream;
           video.play();
        }, function(error) {
        });
    }
    
    
    document.getElementById('capture').addEventListener('click', function() {
    context.drawImage(video, 0, 0, 500, 375);
    document.getElementById("canvas").style.zIndex = "1";
});
})();

function camReset() {
    document.getElementById("canvas").style.zIndex = "-1";
 }

// function  upload() {
//     var canvas2 = document.getElementById('canvas2'),
//         context = canvas2.getContext('2d');
//     upload = new Image();
//     upload.src = "./tmp/tmp.png";
//     context.drawImage(upload, 0,0, 500, 375);
//         document.getElementById("canvas2").style.zIndex = "1";
//     // context = canvas.getContext('2d');
//     // context.drawImage(upload, 0, 0, 500, 375);
//     // document.getElementById("canvas").style.zIndex = "99";
// }
