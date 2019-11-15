var save;
(function() {
    var video = document.getElementById('video'),
        canvas = document.getElementById('canvas'),
        context = canvas.getContext('2d');
        place1 = document.getElementById('place1'),
        place2 = document.getElementById('place2'),
        place3 = document.getElementById('place3'),
    
    
    navigator.getMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia;
    // upload = new Image("/tmp/tmp.png");
    // console.log(sessionStorage.getItem('uploaded_image'));
        var upload = new Image();
        upload.src = "./tmp/tmp.png";
        upload.onerror = function() {
            console.log("I know about the above error. \n This is how I check if there is a user uploaded image");
        };
        upload.onload = function(){
            context.drawImage(upload, 0,0, 500, 375);
            document.getElementById("canvas").style.zIndex = "2";
            save = 1;
            console.log(save);
        };
    console.log(save);

    
    
        
     
        
    navigator.getMedia({
    video: true,
    audio: false
    }, function(stream) {
    video.srcObject = stream;
    video.play();
    }, function(error) {
    });
    
    document.getElementById('capture').addEventListener('click', function() {
        save = 1;
        context.drawImage(video, 0, 0, 500, 375);
        document.getElementById("canvas").style.zIndex = "1";
    });

    place1.addEventListener('click', function() {
        if (document.getElementById("stick1").style.visibility === "visible") {
            document.getElementById("stick1").style.visibility = "hidden"
        } else {
            document.getElementById("stick1").style.visibility = "visible"
        }
    });

    place2.addEventListener('click', function() {
        if (document.getElementById("stick2").style.visibility === "visible") {
            document.getElementById("stick2").style.visibility = "hidden"
        } else {
            document.getElementById("stick2").style.visibility = "visible"
        }
    });

    place3.addEventListener('click', function() {
        if (document.getElementById("stick3").style.visibility === "visible") {
            document.getElementById("stick3").style.visibility = "hidden"
        } else {
            document.getElementById("stick3").style.visibility = "visible"
        }
    });


    document.getElementById("save").addEventListener('click', function() {
        console.log(save);
        if (save) {
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
            save = 0;
        }
    });

})();

function camReset() {
    save = 0;
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
window.onbeforeunload = function()
{

};