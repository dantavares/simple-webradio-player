<?php 
    error_reporting(0);
	include('db-connect.php'); 
    $rphp = 'radio-config.php';
            
    function radioform($f_id, $f_type , $f_nrad, $f_url, $f_bt){
        echo "<form name='form' action='radio-config.php' method='post' enctype='multipart/form-data'><table>\n";
        echo "<tr><td>Nome da Radio: </td><td><input type='text' id='n_rad' name='n_rad' value='$f_nrad' maxlength='20'></td></tr>\n";
        echo "<tr><td>URL: </td><td><input type='text' id='n_url' name='n_url' value='$f_url' maxlength='100'></td></tr>\n";
        if ($f_type != "add"){
			echo "<tr><td>Logo da rádio:</td><td>";
			echo "<a href='upload.php?id=$f_id'><img src='display.php?id=$f_id' width='100' height='100' /></a></td></tr>\n";
			echo "<tr><td>Clique na imagem para atualizá-la</td><td>";
		}
		else {
			echo "Primeiro adicione a rádio, depois clique na imagem em branco para atualizá-la<BR>\n";
		};
		echo "<input type='hidden' name='type' value='$f_type' />\n";
        echo "<input type='hidden' name='id' value='$f_id' /></table>\n";
        echo "<table><tr><td><input type='submit' name='submit' value='$f_bt' id='printbt'/></td></form>\n";
	}
     
	function btform($bt_id, $bt_nform, $bt_type, $bt_name, $bt_clk){
		echo "<form name='$bt_nform' action='$rphp' method='post' enctype='multipart/form-data'>\n";
        echo "<input type='hidden' name='type' value='$bt_type'>\n";
        echo "<input type='hidden' name='id' value='$bt_id' />\n";
        echo "<input type='submit' name='bt' value='$bt_name'".' onclick="'.$bt_clk.'"/>'."\n";
        echo "</form>\n";
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nrad   = $_POST['n_rad'];
        $nurl   = $_POST['n_url'];
        $id     = $_POST['id'];
        $type   = $_POST['type'];
    }
    
	switch ($type){
        case "up":
            $db->query("update estacoes set nome='$nrad', url='$nurl' where id=$id");
		break;
        
        case "nreg":
            radioform("", "add", "", "", "Adicionar");
            echo "<br></tr></table>\n";
			$fadd = true;
        break;
        
        case "add":
            $query = $db->query("select id FROM estacoes ORDER by id DESC LIMIT 1");
			$last_id = $query->fetchArray(SQLITE3_ASSOC);
			$last_id = intval($last_id['id']) + 1;
			$db->query("INSERT INTO estacoes(id, nome, url) VALUES ($last_id,'$nrad','$nurl')");
        break;
        
        case "dreg":
            $db->query("DELETE FROM estacoes WHERE id=$id");
        break;
    }
	
	if (!($fadd)) {
		echo '<!DOCTYPE html> <html>';
		echo '<head><meta name="viewport" content="width=device-width, initial-scale=1"/></head> <body>';
		echo '<table><tr><td>';
		echo '<label>Selecione a Radio:</label>';
		echo '<select onchange="setRadio()" id="sradio">';
		echo '<option disabled selected> ----------------------- </option>';
    	$key = $_GET['vsrad'];
		$menu = $db->query("SELECT id, nome FROM estacoes ORDER BY nome");
		while ($menu_val = $menu->fetchArray(SQLITE3_ASSOC)) {
			if ($key == $menu_val['id']) {
				echo "<option value='".$menu_val['id']."' selected>".$menu_val['nome']."</option>\n";
			} else {
				echo "<option value='".$menu_val['id']."'>".$menu_val['nome']."</option>\n";
			}
		}
	
		echo '</select></td>';
		echo "<td>";
		btform("$key", "f_add", "nreg", "Adicionar Radio", ""); 
		echo "</td></tr></table><br>\n";
	};
	
	if ($key != "") {
        $inbox = $db->query("select * from estacoes where id=$key");
        $inb_val = $inbox->fetchArray(SQLITE3_ASSOC);
        radioform($key, "up", $inb_val['nome'], $inb_val['url'], "Atualizar");
        echo "<br><td>\n";
		btform($key, "f_del", "dreg", "Excluir",'return confirm('."'Tem certeza que deseja excluir esta estação?');");
        echo "</td></tr></table><br>\n";
		
    }
?>

<BR><a href='index.php'>Voltar para a Rádio</a>

<script>
    function setRadio() { 
        var vsrad = document.getElementById("sradio");
        window.location.href="radio-config.php?vsrad="+vsrad.value;
    }
</script>
