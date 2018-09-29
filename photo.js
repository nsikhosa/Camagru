document.getElementById("SaveButton").disabled = true;

(function (){
    var video = document.getElementById('video'),
        canvas = document.getElementById('canvas'),
        context = canvas.getContext('2d'),
        photo = document.getElementById('photo'),
        vendorUrl = window.URL || window.webKitURL;

navigator.getMedia =    navigator.getUserMedia ||
                        navigator.webkitGetUserMedia ||
                        navigator.mozGetUserMedia ||
                        navigator.msGetUserMedia;
                    
navigator.getMedia({
    video: true,
    audio: false
}, function(stream){
    video.src = vendorUrl.createObjectURL(stream);
    video.play();
}, function(error){
    error.code;
    //
});

    document.getElementById('capture').addEventListener('click', function(){
        context.drawImage(video, 0, 0, 400, 300);
        photo.setAttribute('src', canvas.toDataURL('image/png'));
        document.getElementById("SaveButton").disabled = false;
});
    
    document.getElementById('SaveButton').addEventListener('click', function(){
        var img = canvas.toDataURL('image/png');
        var field = document.getElementById('hidden_data');
        field.value = img;
        document.getElementById('saveImage').submit();

});
})();