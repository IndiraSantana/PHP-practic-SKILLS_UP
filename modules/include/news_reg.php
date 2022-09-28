<?php
require "../require/config.php"; //Conexión con el fichero config.
//Definir las variables, El name que le tengo en el formulario (index.html)
$nombre = $email = $telefono = $direccion = $ciudad = $provincia = $zip = $check = $formato = $otrostemas = " ";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "<br><strong>Método post enviado</strong><br>";
    if(!empty($_POST["nombre"]) || !empty($_POST["email"]) || !empty($_POST["telefono"])){
        echo "<br><strong>nombre post enviado</strong><br>";
        //Asignar las variables (del formulario)
        $nombre = $_POST["nombre"];
        $email = $_POST["email"];
        $telefono = $_POST["telefono"];
        $direccion = $_POST["direccion"];
        $ciudad = $_POST["ciudad"];
        $provincia = $_POST["provincia"];
        $zip = $_POST["zip"];
        $check = $_POST["check"];
        $formato = $_POST["formato"];
        $otrostemas = $_POST["otrostemas"];

        function limpiar_dato ($dato){
            $dato = trim($dato);    //trim sirve para eliminar espacios en blancos del inicio y del final
            $dato = stripcslashes($dato);   // Devuelve una cadena con las barras invertidas eliminadas
            $dato = htmlspecialchars($dato); //Para limpiar caracteres especiales: puntos, almohadillas, etc...
        }
        //nombre, email y telefono
        function validar_nombre($nombre){
            if (!preg_match("/^[a-zA-Z-' ]*$/",$nombre))/*si no se cumple la expresión regular...*/  {
                $nombreErr = "Sólo se permiten letras y espacio en blanco";/*... muestra un error */
                return false; //devuelve falso
            } else{
                return true; //devuelve verdadero
            }
        }//termina la función del nombre validado
        function validar_email($email){
            if (!filter_var($email, FILTER_VALIDATE_EMAIL))/*Valida una dirección de correo electrónico */ {
                return false;
            }else{
                return true;
            }
        }
        function validar_telefono($telefono){
            if(!preg_match('/^[0-9]{10}+$/', $telefono)){
                return false;
            }else{
                return true;
            }
        }
    }
}
?>   