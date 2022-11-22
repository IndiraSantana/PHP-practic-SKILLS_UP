<?php
    require "../modules/require/config.php";
    htmlspecialchars($_SERVER['PHP_SELF']);
    $_SERVER['REQUEST_METHOD'] == null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./css/reset.css">
    <link rel="stylesheet" type="text/css" href="./css/normalize.css">
    <link rel="stylesheet" type="text/css" href="./css/tablaobra.css">
    <title>Usuarios inscritos</title>
    <!-- <link rel="icon" type="image/png" hrfe="./images/pfae.png" size="64x64"> -->
</head>

<body>
    <main>
        <?php if ($_SERVER['REQUEST_METHOD'] === 'GET') : ?>
            <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
                <button type="submit" name="MostrarInscritos">MOSTRAR DATOS</button>
            </form>
        <?php else :?>
            <?php /* Redenrerizar la tabla */
                //require_DIR_ . '/inc/post.php';
                $sql = "SELECT * FROM news_reg";
                $stmt = $conn-> prepare($sql);
                $stmt -> execute();

                if($result = $stmt -> setFetchMode(PDO:: FETCH_ASSOC)){
                    echo "<table>
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Email</th>
                                        <th>Telefono</th>
                                        <th>Direccion</th>
                                        <th>Ciudad</th>
                                        <th>Provincia</th>
                                        <th>Código Postal</th>
                                        <th>Boletín</th>
                                        <th>Radio</th>
                                        <th>Comentario</th>
                                    </tr>
                                </thead>";
                    foreach (($rows = $stmt ->fetchAll()) as $row){
                        echo "<tr>
                                <td>".$row["fullname"]."</td>
                                <td>".$row["phone"]."</td>
                                <td>".$row["email"]."</td>
                                <td>".$row["address"]."</td>
                                <td>".$row["city"]."</td>
                                <td>".$row["state"]."</td>
                                <td>".$row["zipcode"]."</td>
                                <td>".$row["newsletters"]."</td>
                                <td>".$row["format_news"]."</td>
                                <td>".$row["suggestion"]."</td>
                            </tr>";
                    }
                    echo "</tr>
                    </table>";
                } else {
                    echo "<p> 0 resultados, no se han encontrado datos.</p><br>";
                }
                $conn = null;
            ?> <!-- Se termina de redenrerizar la tabla -->
            <?php endif ?>
    </main>
</body>
</html>