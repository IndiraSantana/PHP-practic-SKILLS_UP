<?php
require "../require/config.php"; //Conexión con el fichero config.
//Definir las variables, El name que le tengo en el formulario (index.html)
$nombre = $email = $telefono = $direccion = $ciudad = $provincia = $zip = $check = $formato = $otrostemas = "";
    function limpiar_dato($dato){
        $dato = trim($dato);    //trim sirve para eliminar espacios en blancos del inicio y del final
        $dato = stripcslashes($dato);   // Devuelve una cadena con las barras invertidas eliminadas
        $dato = htmlspecialchars($dato); //Para limpiar caracteres especiales: puntos, almohadillas, etc...
        return $dato; //Devuelve el dato añadido en el formulario
    }
//nombre, email y telefono
        /**
         * la  siguiente función va a validar el nombre
         * @param $nombre
         * @return Boolean 
         */
    function validar_nombre($nombre){
        if (!preg_match("/^[a-zA-Z-' ]*$/",$nombre))/*si no se cumple la expresión regular...*/  {
            $nombreErr = "Sólo se permiten letras y espacio en blanco";/*... muestra un error */
            return false; //devuelve falso
        } else{
            return true; //devuelve verdadero
        }
    }//termina la función del nombre validado

        /**
         * la función siguiente va a validar el email
         * @param $email
         * @return Boolean 
         */
    function validar_email($email){
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))/*Valida una dirección de correo electrónico */ {
            return false;
        }else{
            return true;
        }
    }
    //Para documentar la función
        /**<br>
         * la función siguiente va a validar un teléfono
         * @param $telefono
         * @return Boolean 
         */
    function validar_telefono($telefono){
        if(!preg_match('/^[0-9]{9}+$/', $telefono)){
            return false;
        }else{
            return true;
        }
    }

echo "<br>";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    print_r($_POST); //devuelve el post de forma legible 
    echo "<br><strong>Método post enviado</strong><br>";

    if(!empty($_POST["nombre"]) || !empty($_POST["email"]) || !empty($_POST["telefono"])){
        echo "<br><strong>datos post enviados</strong><br>";
        //Asignar las variables (del formulario)
        $nombre = limpiar_dato($_POST["nombre"]);
        echo "<strong> Nombre:</strong>" . $nombre . "<br>";
        $email = limpiar_dato($_POST["email"]);
        echo "<strong> Correo:</strong>" . $email . "<br>";
        $telefono = limpiar_dato($_POST["telefono"]);
        echo "<strong> Teléfono:</strong>" . $telefono . "<br>";

        /*Empezamos a usar los ISSET ya que tenemos warning */
        //$dirección
        if (isset($_POST["direccion"])){
            $direccion = limpiar_dato($_POST["direccion"]);
        }else{
            $direccion = NULL;
        }

        //$ciudad
        if (isset($_POST["ciudad"])){
            $ciudad = limpiar_dato($_POST["ciudad"]);
        }else{
            $ciudad = NULL;
        }

        //$provincia
        if (isset($_POST["provincia"])){
            $provincia = limpiar_dato($_POST["provincia"]);
        }else{
            $provincia = NULL;
        }

        //$zip 
        if (isset($_POST["zip"])){
            $zip = limpiar_dato($_POST["zip"]);
        }else{
            $zip = NULL;
        }
        
        //$check
        if (isset($_POST["check"])){
            $check = limpiar_dato($_POST["check"]);
            echo "<br>check limpio<br>";
        }else{
            $check = NULL;
            echo "<br>check vacío<br>";
        };

        //$formato
        if (isset($_POST["formato"])){
            $formato = limpiar_dato($_POST["formato"]);
            echo "<br>formato limpio<br>";
        }else{
            $formato = NULL;
            echo "<br>formato vacío<br>";
        };

         //$otrostemas
        if (isset($_POST["otrostemas"])){
            $otrostemas = limpiar_dato($_POST["otrostemas"]);
            echo "<br> otrostemas limpio<br>";
        }else{
            $otrostemas = NULL;
            echo "<br> otrostemas vacío<br>";
        };

        //validar que el nombre esté bien escrito
        if(validar_nombre($nombre)){
            echo "<br>Nombre Válido<br>";
        }else{
            echo "<br>El nombre NO está validado<br>";
        }; //Fin de validar_nombre

        //validar que el email esté bien escrito
        if(validar_email($email)){
            echo "<br>email Válido<br>";
        }else{
            echo "<br>El email NO está validado<br>";
        }; 

        //validar que el teléfono esté bien escrito
        if(validar_telefono($telefono)){
            echo "<br>teléfono Válido<br>";
        }else{
            echo "<br>El teléfono NO está validado<br>";
        }; 
    }
}

        
?>   








