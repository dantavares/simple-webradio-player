<?php include('db-connect.php'); ?>
<!DOCTYPE html>
<html><head>
<script src="imp/icecast-metadata-player-1.17.1.main.min.js"></script> 
<script>
	let icecastMetadataPlayer, metadataEl, metadataQueueEl;

    const onMetadata = (metadata) => {
		if (mtype == "ogg"){
			metadataEl.innerHTML = `<p>Tocando Agora:<BR>${metadata.TITLE} - ${metadata.ARTIST}<BR></p>`;
		}else{
			metadataEl.innerHTML = `<p>Tocando Agora:<BR>${metadata.StreamTitle}<BR></p>`;
		};
		
        if (metadata.StreamUrl != "" && !(metadata.StreamUrl === undefined)) {
			virad.src = metadata.StreamUrl;
		}else{
			virad.src = ithumb;
		};
		onMetadataEnqueue();
    };

    const onMetadataEnqueue = () => {
		if (mtype == "ogg"){
			metadataQueueEl.innerHTML = icecastMetadataPlayer.metadataQueue.reduce(	(acc, {metadata} ) =>
				acc +
				`${metadata.TITLE} - ${metadata.ARTIST}<BR>`,
				`Em Seguida:<BR>`,
			);
		}else {
				metadataQueueEl.innerHTML = icecastMetadataPlayer.metadataQueue.reduce(	(acc, {metadata} ) =>
				acc +
				`${metadata.StreamTitle}<BR>`,
				`Em Seguida:<BR>`,
			);
		};
    };
	
	const onCodecUpdate = (codecInformation, updateTimestamp) => {
			bitrateinfo.innerHTML = `<p>Bitrate: ${codecInformation.bitrate} kbps`;
	};
</script>
<meta name="viewport" content="width=device-width, initial-scale=1"> 
<link rel="icon" href="logo/radio.png">
</head>
<body onload="SetVolume(1)">
<label>Selecione a Radio:</label>
<select onchange="setRadio()" id="sradio">
    <option disabled selected> ----------------------- </option>
    <?php
        $key = $_GET['vsrad'];
        $menu = mysqli_query($db, "select id, nome from estacoes order by nome");
        while($menu_val = mysqli_fetch_array($menu)) {
            if ($key == $menu_val['id']){
                echo "<option value='".$menu_val['id']."' selected>".$menu_val['nome']."</option>\n";
            }
            else{
                echo "<option value='".$menu_val['id']."'>".$menu_val['nome']."</option>\n";
            }
        }	
    ?>  
</select>
<br><br>
<table>
<tr align="center">
<th><img draggable="false" onclick="PlayPause()" id="iplps" width="50" height="50"></th>
<th><img draggable="false" onclick="reload()" id="thumb" width="100" height="100"></th>
</tr><tr><th>
<BR>Volume:<BR> 
<img draggable="false" id="ivol" onclick="SetVolume(0)" src="logo/speaker.png">
<input type="range" min="0" max="100"><BR>
</th></tr></table><table>
<tr align="left">
<th>Buffer: <meter id="buffer" min="0" max="5" low="2" optimum="2"></meter></th>
<th><span id="bitrate"></span></th></tr>
</table>
<audio onstalled="Load(0)" onwaiting="Load(1)" onplaying="Load(2)" onpause="logoPlPs()"
       onplay="logoPlPs()" onprogress="Buffer()" id="pradio"></audio>
<label></label><input name="endpoint" id="endpoint" type="hidden" value=""/>
<span id="metadata"></span>
<span id="metadataQueue"></span>
<label id="debug"></label>

<script>
    var svol  = document.querySelector('input');
    var vprad = document.getElementById("pradio");
    var vplps = document.getElementById("iplps");
    var vsrad = document.getElementById("sradio");
    var virad = document.getElementById("thumb");
    var vbuff = document.getElementById("buffer");
    var ithumb, ctry = 0, erro, url, mtype;
	endpoint;
    audioElement = document.getElementById("pradio");
    metadataEl = document.getElementById("metadata");
    metadataQueueEl = document.getElementById("metadataQueue");
	bitrateinfo = document.getElementById("bitrate");
	    
	const getIcecastMetadataPlayer = () => {
		erro = 0;
		icecastMetadataPlayer = new IcecastMetadataPlayer(endpoint, {
			audioElement, 					//audio element in HTML
			onMetadata, 					//called when metadata is synced with the audio
			onMetadataEnqueue, 				//called when metadata is discovered in the stream
			onCodecUpdate,					//called wnen have informatiom about Codec
			playbackMethod: "html5",		//preferred playback method. "mediasource", "webaudio", "html5"
			metadataTypes: [mtype], 		//detect ICY metadata
			icyCharacterEncoding: "utf8",	//character encoding of the ICY metadata
			icyDetectionTimeout: 1000, 		//attempt to detect ICY metadata for seconds
			enableLogging: true, 			//enable error logs to the console
			onWarn: (message) => {
				//metadataQueueEl.innerHTML = message;
				if (message == "This stream is not an Ogg stream. No Ogg metadata will be returned.") {
					mtype = "icy";
					vprad.load();
					ReloadMetadata(url);
				};
				if (message == "This stream was requested with ICY metadata.") {
					mtype = "ogg";
					ctry++;
					if (ctry > 1) {
						erro = 1;
						ctry = 0;
					};
					vprad.load();
					ReloadMetadata(url);
				};
			},
		});
    };
	
	getIcecastMetadataPlayer();
	
	async function ReloadMetadata(nurl) {
		endpoint = nurl;
		if (erro) {
			mtype = "";
		};
		await icecastMetadataPlayer.detachAudioElement();
		getIcecastMetadataPlayer();
		icecastMetadataPlayer.play();
	}
	
	vprad.addEventListener("play", (event) => {
		icecastMetadataPlayer.play();
	});
	
	function reload() {
        vprad.load();
		setRadio();
	}
	
    svol.addEventListener('input', 
        function () {
            vprad.volume = svol.value / 100;
            document.cookie = "vol=" + svol.value;
        }, 
    false);

    function SetVolume(pg) {
    	if (vol != "" && pg) {
            var vol = getCookie("vol");
            svol.value = vol;
            if (pg > 1) {
                reload();
                document.getElementById("debug").innerHTML = pg;
            }
        }
        else {
            if (vprad.muted) {
                document.getElementById('ivol').src = "logo/speaker.png";    
            }
            else {
                document.getElementById('ivol').src = "logo/mute.png";
            }
            vprad.muted = !vprad.muted;
        }         
    }
    
    function getCookie(cname) {
        var name = cname + "=";
  	var decodedCookie = decodeURIComponent(document.cookie);
  	var ca = decodedCookie.split(';');
  	for(var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
  	}
        return "";
    }
    
    function Load(st) {
    	vbuff.value = "0";
	    switch (st) {
                case 0:
                    virad.src = "logo/error-cloud.png";
                    break;
        	case 1:
                    virad.src = "logo/loading.gif";
                    break;
                case 2:
                    virad.src = ithumb;
            }
    }
    
    function Buffer() {
    	vbuff.value = vprad.buffered.end(0) - vprad.currentTime;
        //document.getElementById("debug").innerHTML = vprad.src;
    }
    
    function logoPlPs(){	
        if (icecastMetadataPlayer.state == "playing") {
			icecastMetadataPlayer.stop();
			vplps.src = "logo/iplay.png";
        }
        else {
        	icecastMetadataPlayer.play();
			vplps.src = "logo/ipause.png";
        }
    }
    
    function PlayPause() {
		if (vprad.paused) {
			icecastMetadataPlayer.play();
        }
        else {
			vprad.pause();
        }
     }
        
    function setRadio() { 
  	switch (vsrad.value) {
        <?php
            $case = mysqli_query($db, "select * from estacoes");
                
            while($case_val = mysqli_fetch_array($case)) {
                echo 'case "'.$case_val['id'].'":'."\n";
                echo 'url = "' . $case_val['url'] . '";' . "\n";
                echo 'ithumb = "display.php?id=' . $case_val['id'] . '";' . "\n";
                echo "break;\n";
            }	
        ?>  			
	}
        mtype = "ogg";
		bitrateinfo.innerHTML = "";
		metadataEl.innerHTML = "";
		metadataQueueEl.innerHTML = "";
		vprad.volume = svol.value / 100;
		ReloadMetadata(url);
    }
</script>
<?php mysqli_close($db); ?>
