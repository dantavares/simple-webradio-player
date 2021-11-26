<?php 
    include('db-connect.php'); 
    $rphp = 'index.php';
            
    function radioform($f_id, $f_type , $f_nrad, $f_url, $f_logo, $f_bt){
        echo "<form name='form' action='radio-config.php' method='post'><table>\n";
        echo "<tr><td>Radio: </td><td><input type='text' id='n_rad' name='n_rad' value='$f_nrad'></td></tr>\n";
        echo "<tr><td>URL: </td><td><input type='text' id='n_url' name='n_url' value='$f_url'></td></tr>\n";
        echo "<tr><td>Logo: </td><td><input type='text' id='n_logo' name='n_logo' value='$f_logo'></td></tr>\n";
        echo "<input type='hidden' name='type' value='$f_type' />\n";
        echo "<input type='hidden' name='id' value='$f_id' /></table>\n";
        echo "<table><tr><td><input type='submit' name='submit' value='$f_bt' id='printbt'/></td></form>\n";
     }
     
     function btform($bt_id, $bt_nform, $bt_type, $bt_name, $bt_clk){
        echo "<form name='$bt_nform' action='radio-config.php' method='post'>\n";
        echo "<input type='hidden' name='type' value='$bt_type'>\n";
        echo "<input type='hidden' name='id' value='$bt_id' />\n";
        echo "<input type='submit' name='bt' value='$bt_name'".' onclick="'.$bt_clk.'"/>'."\n";
        echo "</form>\n";
     }
?>

<!DOCTYPE html>
<html>
<head><meta name="viewport" content="width=device-width, initial-scale=1"/></head>
<body>
<table><tr><td>
<label>Selecione a Radio:</label>
<select onchange="setRadio()" id="sradio">
    <option disabled selected> ----------------------- </option>
    <?php
        $key = $_GET['vsrad'];
        $menu = mysqli_query($db, "select id, nome from estacoes");
        while($menu_val = mysqli_fetch_array($menu)) {
            if ($key == $menu_val['id']){
                echo "<option value='".$menu_val['id']."' selected>".$menu_val['nome']."</option>\n";
            }
            else{
                echo "<option value='".$menu_val['id']."'>".$menu_val['nome']."</option>\n";
            }
        }	
    ?>  
</select></td>

<?php 
    echo "<td>";
    btform("$key", "f_add", "nreg", "Adicionar Radio", ""); 
    echo "</td></tr></table><br>\n";
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nrad   = $_POST['n_rad'];
        $nurl   = $_POST['n_url'];
        $nlogo  = $_POST['n_logo'];
        $id     = $_POST['id'];
        $type   = $_POST['type'];
    }
    
    switch ($type){
        case "up":
            mysqli_query($db,"update estacoes set nome='$nrad', url='$nurl', logo='$nlogo' where id=$id");
            header("Location: $rphp");
            break;
        
        case "nreg":
            radioform("", "add", "", "", "", "Adicionar");
            echo "<br></tr></table>\n";
            break;
        
        case "add":
            mysqli_query($db,"INSERT INTO estacoes(nome, url, logo) VALUES ('$nrad','$nurl','$nlogo')");
            header("Location: $rphp");
            break;
        
        case "dreg":
            mysqli_query($db,"DELETE FROM estacoes WHERE id=$id");
            header("Location: $rphp");
            break;
    }
    
    if ($key != "") {
        $inbox = mysqli_query($db, "select * from estacoes where id=$key");
        $inb_val = mysqli_fetch_array($inbox);
        radioform($key, "up", $inb_val['nome'], $inb_val['url'], $inb_val['logo'], "Atualizar");
        echo "<br><td>\n";
        btform($key, "f_del", "dreg", "Excluir",'return confirm('."'Tem certeza que deseja excluir esta estação?');");
        echo "</td></tr></table><br>\n";
    }
?>

<script>
    function setRadio() { 
        var vsrad = document.getElementById("sradio");
        window.location.href="radio-config.php?vsrad="+vsrad.value;
    }
</script>

<?php mysqli_close($db);

