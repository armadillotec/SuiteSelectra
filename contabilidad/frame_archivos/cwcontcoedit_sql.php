<?php
 $Accion    = $_GET['Accion'];
 include("config_bd.php"); // archivo que llama a la base de datos 
 if ($Accion == 'Modificar')
 {
     $Codigo     = $_POST['Codtipo'];
     $Descrip    = $_POST['Descrip'];  
	  	
     $result = mysql_query("UPDATE cwcontco SET Descrip='$Descrip' WHERE Codtipo='$Codigo'", $conectar);	 	 
     mysql_close($conectar);
     header("Location: cwcontcolist.php");   
 } else if ($Accion == 'Borrar')
 {
    $Codigo       = $_GET['Codtipo'];
    $result = mysql_query("DELETE FROM cwcontco WHERE Codtipo = '$Codigo'", $conectar);	 	 
    mysql_close($conectar);
    header("Location: cwcontcolist.php"); 
	 
 }	else if ($Accion == 'Agregar')
 {
     $Codtipo      = $_POST['Codtipo'];
     $Descrip      = $_POST['Descrip'];   
	 
     $result = mysql_query("SELECT * FROM cwcontco WHERE Codtipo ='$Codtipo'", $conectar); 
     
	 $num_rows = mysql_num_rows($result);
	 
	 if ($num_rows > 0)
	 {
	   echo "Regresa, este c�digo no es v�lido, ya existe.";
	   mysql_close($conectar);
	 } else if ($num_rows == 0)
	 {
	   $row = mysql_fetch_row($result);
	
       $result = mysql_query("INSERT INTO cwcontco (Descrip) VALUES ('$Descrip')", $conectar);	 	 
       mysql_close($conectar);
       header("Location: cwcontcolist.php");   
     }
 }			
?>