<?php include('db-connect.php'); ?>

<!DOCTYPE html>
<html>
<head><meta name="viewport" content="width=device-width, initial-scale=1"></head>
<body>

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
</select>
<BR>
<label id="debug"></label>

<script>
    var vsrad = document.getElementById("sradio");
   
    function setRadio() { 
        window.location.href="radio-config.php?vsrad="+vsrad.value;
                
        <?php
            $vsrad = $_GET['vsrad'];
            if ($vsrad != ""){
                echo $vsrad;
            }
        ?>
              			
        }

</script>
<?php mysqli_close($db);

