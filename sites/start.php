<h2>
	Willkommen
</h2>
<br/>
<?php
	if(isset($parse))
		var_dump($parse);
?>
<h1>W.I.P.</h1>
<div id="playerContainer"></div>
<script type="text/javascript" src="scripts/modernizr-custom.js"></script>
<script type="text/javascript">
	var playerContainer = document.getElementById('playerContainer');
	setTimeout(loadEE, 60000);
	
	function loadEE() {
		if(Modernizr.video.webm && Modernizr.videoautoplay) {
			insertVideo();
		} else {
			insertAudio();
		}
	}
	function insertAudio() {
		playerContainer.innerHTML = '<audio id="player" style="width: 100%;" autoplay loop controls><source src="media/JustDoIt.ogg" type="audio/ogg"><source src="media/JustDoIt.mp3" type="audio/mpeg">Your browser does not support the audio element.</audio>&nbsp;<button id="playButton" onClick="insertVideo()">Video</button>';
	}
	function insertVideo() {
		playerContainer.innerHTML = '<video id="player" style="width: 100%;" autoplay loop controls>	<source src="media/JustDoIt.webm" type="video/webm">Your browser does not support HTML5 video.</video>&nbsp;<button id="playButton" onClick="insertAudio()">Audio</button>';
	}
</script>