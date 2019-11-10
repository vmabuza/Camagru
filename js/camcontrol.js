window.onload = function(){
    var camera = document.querySelector('.camera');
    var body = this.document.querySelector('.container-fluid');

    camera.setAttribute('style', 'display: none');
}

function toggleCamera() {
    var camera = document.querySelector('.camera');
    if (camera.style.display == 'none') {
        camera.setAttribute('style', 'display: inline block');
    } else {
        camera.setAttribute('style', 'display: none');
    }
}