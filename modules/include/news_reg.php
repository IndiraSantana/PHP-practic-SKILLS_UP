<?php
require "../require/config.php"; //Conexión con el fichero config.
//Definir las variables, El name que le tengo en el formulario (index.html)
$nombre = $email = $telefono = $direccion = $ciudad = $provincia = $zip = $check = $noticia = $otrostemas ="";
$nombre_err = $email_err = $telefono_err = false;
$checkeado;    
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
            echo"<br>El teléfono está validado<br><br>";
        }else{
            $telefono_err = true;   //si el teléfono es erróneo, lo pasa a verdadero
        }

        if( validar_nombre($nombre) && validar_email($email) && validar_telefono($telefono)){//abrir el if de validar 

            /*Usamos los ISSET para comprobar que las variables llegan correctamente*/
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

            /* if(isset($_POST["check"])){
                $check =limpiar_dato($_POST["check"]);
            }else{
                $check = NULL;
            } */
            $check= filter_input(
                INPUT_POST,
                "check",
                FILTER_SANITIZE_SPECIAL_CHARS,
                FILTER_REQUIRE_ARRAY
            );
            var_dump($check);
            echo "<br>La longitud del check es: " . count($check) . ". <br>";
            
            $lengArray = count($check); //count devuelve todos los elementos de la array

            switch ($lengArray){
                case 1:
                    if ($check[0] == "HTML"){
                        $checkeado = bindec ("100");    
                    } elseif($check[0] == "CSS"){
                        $checkeado = bindec ("010");
                    } else {
                        $checkeado = bindec ("001");
                    }
                    break;

                case 2:
                    if($check[0] != "HTML"){
                        $checkeado = bindec ("011"); /*Devuelve el decimal del binario */
                        } elseif ($check[0] != "CSS"){
                        $checkeado = bindec ("101");
                        } else{
                        $checkeado = bindec ("110");
                        }
                    break;

                    case 3:
                        $checkeado = bindec ("110");
                        break;
                default:
                    $checkeado = bindec ("100");
            }
            

            echo "Valor a devolver " . $checkeado . "<br>";
            //== Usa un array y muestra sus valores separados por coma (o lo que se ponga entre las comillas)
            $string=implode(", ", $check);
            echo $string. "<br>";
            //Deja de mostrar el valor de la aray

            //el isset sirve para comprobar que llega
            if(isset($_POST["noticia"])){
                $noticia =limpiar_dato($_POST["noticia"]);
                if($noticia=="HMTL"){
                    $noticia=1; //valor de html en los radios.
                } else{
                    $noticia=0; //valor de Texto plano en los radios.
                }

            }else{
                $noticia = 1;
            }
            
            if(isset($_POST["otrostemas"])){
                $otrostemas =limpiar_dato($_POST["otrostemas"]);
            }else{
                $otrostemas = NULL;
            }
                //------------------------------------BORRAR------------------------------------------
            echo "<strong>Nombre: </strong>" . $nombre . "<br>"; 
            echo "<strong>Email: </strong>" . $email . "<br>";
            echo "<strong>Teléfono: </strong>" . $telefono . "<br>";
            echo "<strong>Dirección: </strong>" . $direccion . "<br>";
            echo "<strong>Ciudad: </strong>" . $ciudad . "<br>";
            echo "<strong>Provincia: </strong>" . $provincia . "<br>";
            echo "<strong>Código Postal: </strong>" . $zip . "<br>";
            //echo "<strong>Check: </strong>" . $check . "<br>";
            echo "<strong>Noticias: </strong>" . $noticia . "<br>";
            echo "<strong>Otros temas: </strong>" . $otrostemas . "<br>";
                //------------------------------------BORRAR------------------------------------------
            //Comprobar que no existen los datos que se van a enviar: los 3 datos requeridos.
            try {
                $sql= "SELECT * from news_reg  WHERE fullname = :fullname OR email= :email OR phone = :phone";
                
                $stmt =$conn-> prepare ($sql);

                $stmt->bindParam(":fullname", $nombre, PDO:: PARAM_STR);
                $stmt->bindParam(":email", $email, PDO:: PARAM_STR);
                $stmt->bindParam(":phone", $telefono, PDO:: PARAM_STR);

                $stmt-> execute();
                $resultado = $stmt-> fetchAll();
                echo "El resultado es " .var_dump($resultado) . "<br>";
                if($resultado){
                    echo "<br>La información ya existe. <br>";
                    } else{
                        try {
                            $sql ="INSERT INTO news_reg (fullname, email, phone, address, city, state, zipcode, newsletters, format_news, suggestion) VALUES (:fullname, :email, :phone, :address, :city, :state, :zipcode, :newsletters, :format_news, :suggestion)";
                            $stmt = $conn->prepare($sql);
                            $stmt->bindParam(":fullname", $nombre, PDO:: PARAM_STR);
                            $stmt->bindParam(":email", $email, PDO:: PARAM_STR);
                            $stmt->bindParam(":phone", $telefono, PDO:: PARAM_STR);
                            $stmt->bindParam(":address", $direccion, PDO:: PARAM_STR);
                            $stmt->bindParam(":city", $ciudad, PDO:: PARAM_STR);
                            $stmt->bindParam(":state", $provincia, PDO:: PARAM_STR);
                            $stmt->bindParam(":zipcode", $zip, PDO:: PARAM_STR);
                            $stmt->bindParam(":newsletters", $checkeado, PDO:: PARAM_STR);
                            $stmt->bindParam(":format_news", $noticia, PDO:: PARAM_STR);
                            $stmt->bindParam(":suggestion", $otrostemas, PDO:: PARAM_STR);

                            $stmt-> execute();
                            echo "Nuevo registro creado con éxito <br>";   
                        } catch(PDOException $e){
                            echo $sql . "<br>" . $e->getMessage();
                        }
                        $conn = null;
                    }
            } catch(PDOException $e){
                echo $sql . "<br>" . $e->getMessage();
            }

        } else {                          /*cerrar el if de validar */
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
    

} else {         /*Cierra el primer if */
    echo "No se ha recibido el método post";
}

/* Si (llega datos) Entonces 
    tratamos datos
        Si si hay información Entonces
            Si no llegan variables?**
            limpiar la información. check!!
            validar la informacinon.                 
            Si datos necesarios Entonces
                asegurar de que están bien escrito.                 
                SiNo             
                    mandamos dato tal cual.                 
            Fin Si                 
            Mostrar que todos los datos son correctos para enviar a BBDD.
                SiNo             
                enviar datos necesarios         
        Fin Si 
            SiNo     
                avisar no han llegado. Fin Si */


?> 