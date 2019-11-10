var imageLoader = document.getElementById('imageLoader');
imageLoader.addEventListener('change', handleImage, false);
var canvas = document.getElementById('imageCanvas');
var ctx = canvas.getContext('2d');
var fd = new FormData(document.forms["get_image"]);
var sub = document.getElementById('image_submit');
var image = '';

function handleImage(e) {
    var reader = new FileReader();
    var oldCanvas = document.getElementById('imageCanvas');
    var contex = oldCanvas.getContext('2d');
    reader.onload = function(event) {
        var img = new Image();
        img.onload = function() {
            oldCanvas.width = 640;
            oldCanvas.height = 480;
            contex.drawImage(img, 0, 0, 640, 480);
        }
        img.src = event.target.result;
        image = img.src;
        document.getElementById('hidden_top').setAttribute('value', null);
        document.getElementById('hidden_data').value = event.target.result;
    }
    reader.readAsDataURL(e.target.files[0]);
}

(function() {
  var width = 640;    // We will scale the photo width to this
  var height = 0;     // This will be computed based on the input stream

  var streaming = false;

  var video = null;
  var startbutton = null;
  
  function startUp() {
      video = document.getElementById('video');
      startbutton = document.getElementById('startbutton');

    navigator.mediaDevices.getUserMedia({video: true, audio: false})
        .then (function(stream) {
            video.srcObject = stream;
            video.play();
        })
        .catch(function(err) {
            console.log('An error occured! ' + err);
        });
    
    video.addEventListener('canplay', function(ev){
        if (!streaming) {
            height = video.videoHeight / (video.videoWidth/width);

            if (isNaN(height)) {
                console.log('got here too');
                height = width / (4/3);
            }

            //video.setAttribute('width', width);
            //video.setAttribute('height', height);
            streaming = true;
        }
    }, false);

    startbutton.addEventListener('click', function(ev){
        takePicture();
        ev.preventDefault();
    }, false);

  }

  function takePicture() {
      oldCanvas = document.getElementById('imageCanvas');
      var context = oldCanvas.getContext('2d');
      if (width && height) {
          oldCanvas.width = width;
          oldCanvas.height = height;
          context.drawImage(video, 1, 0, width, height);

          var data = oldCanvas.toDataURL('image/png');
          document.getElementById('hidden_data').value = data;
          document.getElementById('hidden_top').setAttribute('value', null);
      }
  }

  window.addEventListener('load', startUp, false);
})();


//making an anonymous function to register clicks in the site.
(function(){
    var canvas = document.getElementById('imageCanvas');
    var hidden_top = document.getElementById('hidden_top');
    var ctx = canvas.getContext('2d');
    var topImage = new Image();
    var oldImage = new Image();
    var hidden = document.getElementById('hidden_data');
    document.addEventListener('click', function(event){
        if (event.target.matches('.frame')) {
            if (canvas.toDataURL().length < 1600)
                return ;
            hidden_top.value = event.target.src;
            topImage.src = event.target.src;
            oldImage.src = hidden.value;
            ctx.drawImage(oldImage, 0, 0, 640, 480);
            ctx.drawImage(topImage, 0, 0, 640 / 4, 480 / 4);
        } else if (event.target.matches('.user_images')) {
            var hidden_data = document.getElementById('hidden_data');
            var image = new Image();
            image.onload = function() {
                canvas.width = 640;
                canvas.height = 480;
                ctx.drawImage(image, 0, 0, 640, 480);
            };
            image.src = event.target.src;
            hidden_data.value = event.target.src;
        }
    }); 
})();