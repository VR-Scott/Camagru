
(function() {
    var video = document.getElementById('video'),
        canvas = document.getElementById('canvas'),
        vaughan = document.getElementById('submit'),
        context = canvas.getContext('2d');
    vaughan.addEventListener
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

    document.getElementById("save").addEventListener('click', function() {
        var layer1 = canvas.toDataURL('image/png');
        console.log(layer1);
        // var layer2 = overlaycanvas.toDataURL('image/png');
        const url = "./upload_canvas.php";
        var xhttp = new XMLHttpRequest();
        var values = "baseimage=" + layer1 /*+ "&overlayimage=" + layer2*/;
        // alert("Your image has been posted\nPlease refresh");
        xhttp.open("POST", url, true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.onreadystatechange = function() {
            if (xhttp.readyState == 4 && xhttp.status == 200) {
                var response = xhttp.responseText;
                // document.getElementById("imgsec").innerhtml = xhhtp.
                console.log(response);
            }
        }
        xhttp.send(values);
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
