<?php
    $db_host = 'localhost';
    $db_name = 'radio';
    $db_user = 'radio';
    $db_pass = 'issdnata';
    
    $db = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
    if(!$db) { die("Erro ao conectar no banco de dados: " . mysqli_connect_error()); }
?>

<!DOCTYPE html>
<html>
<head> 
<meta name="viewport" content="width=device-width, initial-scale=1"> 
<link rel="icon" href="logo/radio.png">
<link rel="preload" href="logo/speaker.png" as="image">
<link rel="preload" href="logo/mute.png" as="image">
<link rel="preload" href="logo/iplay.png" as="image">
<link rel="preload" href="logo/ipause.png" as="image">
<link rel="preload" href="logo/error-cloud.png" as="image">
</head>
<body onload="SetVolume(1)">

<label>Selecione a Radio:</label>
<select onchange="setRadio()" id="sradio">
    <option disabled selected> ------------ </option>
    <?php
        $menu = mysqli_query($db, "select id, nome from estacoes");
        
        while($menu_val = mysqli_fetch_array($menu)) {
            echo "<option value='". $menu_val['id'] ."'>" .$menu_val['nome'] ."</option>\n";
        }	
    ?>  
</select>

<br><br>

<table>
<tr valign="center">
<th><img onclick="PlayPause()" id="iplps" width="50" height="50"></th>
<th><img onclick="reload()" id="thumb" width="100" height="100"></th>
</tr><tr><th>
<BR>Volume:<BR> 
<img id="ivol" onclick="SetVolume(0)" src="logo/speaker.png">
<input type="range" min="0" max="100"><BR>
</th>
</tr>
</table>
<BR>
Buffer:
<meter id="buffer" min="0" max="5" low="2" optimum="2"> </meter>
<BR>
<label id="debug"></label>

<audio 	onstalled="Load(0)" 
		onwaiting="Load(1)" 
        onplaying="Load(2)" 
        onpause="logoPlPs()"
        onplay="logoPlPs()"
        onprogress="Buffer()"
        id="pradio">

<script>
	var svol  = document.querySelector('input');
    var vprad = document.getElementById("pradio");
	var vplps = document.getElementById("iplps");
    var vsrad = document.getElementById("sradio");
	var virad = document.getElementById("thumb");
    var vbuff = document.getElementById("buffer");
    var ithumb;
	    
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
                
        //document.getElementById("debug").innerHTML = vbuff.value;
            
    }
    
    function logoPlPs(){
    	if (vprad.paused) {
        	vplps.src = "logo/iplay.png";
        		
        }
        else {
        	vplps.src = "logo/ipause.png";
        	
        }
    }
    
    function PlayPause() {
    	if (vprad.readyState != 0) {
        	if (vprad.paused) {
        		vprad.play();
        	}
        	else {
        		vprad.pause();
        	}
        }
     }
    
    function reload() {
		vprad.load();
		setRadio();
	}
	
	function setRadio() { 
  		switch (vsrad.value) {
            <?php
                $case = mysqli_query($db, "select * from estacoes");
                
                while($case_val = mysqli_fetch_array($case)) {
                    echo 'case "'.$case_val['id'].'":'."\n";
                    echo 'vprad.src = "' . $case_val['url'] . '";' . "\n";
                    echo 'ithumb = "' . $case_val['logo'] . '";' . "\n";
                    echo "break;\n";
                }	
            ?>  			
		}
  		vprad.volume = svol.value / 100;
		vprad.play();
    }
</script>
<?php mysqli_close($db); ?>
