<?php
require "../require/config.php"; //Conexión con el fichero config.
//Definir las variables, El name que le tengo en el formulario (index.html)
$nombre = $email = $telefono = $direccion = $ciudad = $provincia = $zip = $check = $noticia = $otrostemas ="";
$nombre_err = $email_err = $telefono_err = false;
    
    //con esta función limpiaremos los datos antes de validarlos y enviarlos
function limpiar_dato($dato){
    $dato = trim($dato); //trim sirve para eliminar espacios en blancos del inicio y del final
    $dato = stripslashes($dato); // Devuelve una cadena con las barras invertidas o comillas eliminadas.
    $dato = htmlspecialchars($dato); // Devuelve una cadena con las barras invertidas eliminadas
    return $dato; //Devuelve el dato añadido en el formulario
}

        /**
         * la  siguiente función va a validar el nombre
         * @param $nombre
         * @return Boolean 
         */
function validar_nombre($nombre){
    if (!preg_match("/^[a-zA-Z-' ]*$/",$nombre)) /*si no se cumple la expresión regular...*/ {
        return false; //devuelve falso
    }else{
        return true; //devuelve verdadero
    }
}

function validar_telefono($telefono){
    if(!preg_match('/^[0-9]{9}+$/', $telefono)){
        return false;
    }else{
        return true;
    }
}

function validar_email($email){
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    }else{
        return true;
    }
}


if($_SERVER["REQUEST_METHOD"] == "POST"){ //abre el primer if
    print_r ($_POST);
    if(!empty($_POST["nombre"]) || !empty($_POST["email"]) || !empty($_POST["telefono"])) /*empty= si la variable está vacía*/{//abre el segundo if
        echo "<br><strong>Metodo post enviado</strong><br>";
        //Asignar las variables (del formulario)
        $nombre= limpiar_dato($_POST["nombre"]);
        echo "<strong>Nombre: </strong>" . $nombre . "<br>"; 
        $email= limpiar_dato($_POST["email"]);
        echo "<strong>Email: </strong>" . $email . "<br>";
        $telefono= limpiar_dato($_POST["telefono"]);
        echo "<strong>Telefono: </strong>" . $telefono . "<br>";

        if(validar_nombre($nombre)){
            echo"<br>El nombre está validado<br>";
        }else{
            $nombre_err = true; //si el nombre es erróneo, lo pasa a verdadero
        }

        if(validar_email($email)){
            echo"<br>El email está validado<br>";
        }else{
            $email_err = true;  //si el email es erróneo, lo pasa a verdadero
        }
        
        if(validar_telefono($telefono)){
            echo"<br>El teléfono está validado<br>";
        }else{
            $telefono_err = true;   //si el teléfono es erróneo, lo pasa a verdadero
        }

        if( validar_nombre($nombre) && validar_email($email) && validar_telefono($telefono)){//abrir el if de validar 

            /*Usamos los ISSET para quitar los warning */
            if(isset($_POST["direccion"])){
                $direccion =limpiar_dato($_POST["direccion"]);
            }else{
                $direccion = NULL;
            }

            if(isset($_POST["ciudad"])){
                $ciudad =limpiar_dato($_POST["ciudad"]);
            }else{
                $ciudad = NULL;
            }

            if(isset($_POST["provincia"])){
                $provincia =limpiar_dato($_POST["provincia"]);
            }else{
                $provincia = NULL;
            }

            if(isset($_POST["zip"])){
                $zip =limpiar_dato($_POST["zip"]);
            }else{
                $zip = NULL;
            }

            if(isset($_POST["check"])){
                $check =limpiar_dato($_POST["check"]);
            }else{
                $check = NULL;
            }

            if(isset($_POST["noticia"])){
                $noticia =limpiar_dato($_POST["noticia"]);
            }else{
                $noticia = NULL;
            }

            if(isset($_POST["otrostemas"])){
                $otrostemas =limpiar_dato($_POST["otrostemas"]);
            }else{
                $otrostemas = NULL;
            }

            echo "<strong>Nombre: </strong>" . $nombre . "<br>"; 
            echo "<strong>Email: </strong>" . $email . "<br>";
            echo "<strong>Teléfono: </strong>" . $telefono . "<br>";
            echo "<strong>Dirección: </strong>" . $direccion . "<br>";
            echo "<strong>Ciudad: </strong>" . $ciudad . "<br>";
            echo "<strong>Provincia: </strong>" . $provincia . "<br>";
            echo "<strong>Código Postal: </strong>" . $zip . "<br>";
            echo "<strong>check: </strong>" . $check . "<br>";
            echo "<strong>Noticias: </strong>" . $noticia . "<br>";
            echo "<strong>Otros temas: </strong>" . $otrostemas . "<br>";


        }else{                          /*cerrar el if de validar */
            if ($nombre_err == true){
                echo "la validación del nombre está errónea";
            }elseif($email_err == true){
                echo "La validación del email está errónea";
            }elseif($telefono_err == true);
                echo "La validación del teléfono está errónea";
        }

        
    } else{         /*Cierra el segundo if */
        echo "Uno de los datos requeridos no ha sido rellenado";
    }
    

}else{         /*Cierra el primer if */
    echo "No hemos recibido método post";
}


?>   