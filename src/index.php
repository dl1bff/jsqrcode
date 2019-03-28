<html>
<head>
<title>Messwerte</title>

<style type="text/css">
</style>

<script type="text/javascript" src="grid.js"></script>
<script type="text/javascript" src="version.js"></script>
<script type="text/javascript" src="detector.js"></script>
<script type="text/javascript" src="formatinf.js"></script>
<script type="text/javascript" src="errorlevel.js"></script>
<script type="text/javascript" src="bitmat.js"></script>
<script type="text/javascript" src="datablock.js"></script>
<script type="text/javascript" src="bmparser.js"></script>
<script type="text/javascript" src="datamask.js"></script>
<script type="text/javascript" src="rsdecoder.js"></script>
<script type="text/javascript" src="gf256poly.js"></script>
<script type="text/javascript" src="gf256.js"></script>
<script type="text/javascript" src="decoder.js"></script>
<script type="text/javascript" src="qrcode.js"></script>
<script type="text/javascript" src="findpat.js"></script>
<script type="text/javascript" src="alignpat.js"></script>
<script type="text/javascript" src="databr.js"></script>

<script type="text/javascript">
	
var gCtx = null;
var gCanvas = null;
var video = null;
var myUrl = "https://xf.md8.net/qr/";
var counter = 0;

function loadDoc(value) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
     document.getElementById("result").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", "data.php?v=" + value, true);
  xhttp.send();
}

function getQueryVariable(variable) {
    var query = window.location.search.substring(1);
    var vars = query.split('&');
    for (var i = 0; i < vars.length; i++) {
        var pair = vars[i].split('=');
        if (decodeURIComponent(pair[0]) == variable) {
            return decodeURIComponent(pair[1]);
        }
    }
    return null;
}

function read(a)
{
    if(a.indexOf(myUrl) === 0)
    {
	if (a != window.location.href)
	{
	    window.location.href = a;
	}
    }
}	

function capToCanvas()
{
   try
   {
	counter += 1;
	if ((counter & 0x03) == 0)
	{
		var v = getQueryVariable("v");
		if (v != null)
		{
		    loadDoc(v);
		}
	}
	gCtx.drawImage(video, 0, 0);
        qrcode.decode();
	setTimeout(capToCanvas, 500);
   }
   catch(e)
   {
	console.log(e);
	setTimeout(capToCanvas, 500);
   }
  
}
	
function load()
{
   var constraints = { audio: false, video: { width: 400, height: 400, facingMode: { exact: "environment" } } }; 

   qrcode.callback = read;

   gCanvas = document.getElementById("qr-canvas");
   gCtx = gCanvas.getContext("2d");



   navigator.mediaDevices.getUserMedia(constraints)
	.then(function(mediaStream) {
		video = document.querySelector('video');
		video.srcObject = mediaStream;
		video.onloadedmetadata = function(e) {
			video.play();
			setTimeout(capToCanvas, 100);
		};
	}).catch(function(err) { console.log(err.name + ": " + err.message); });
}

</script>
</head>

<body onload="load()">
<video id="v" width="400" height="400"></video>
<canvas id="qr-canvas" width="400" height="400"></canvas>
<div id="result"><?php
include "data.php";
?></div>
</body>
</html>
