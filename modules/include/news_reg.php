<?php
require "../require/config.php"; //Conexión con el fichero config.
//Definir las variables, El name que le tengo en el formulario (index.html)
$nombre = $email = $telefono = $direccion = $ciudad = $provincia = $Zip = $check = $formato = $otrostemas = " ";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "<br><strong>Metodo post enviado</strong><br>";
    if(!empty($__POST["name"]) || !empty($__POST["email"]) || !empty($__POST["telefono"])){
        
    }
}
?>   