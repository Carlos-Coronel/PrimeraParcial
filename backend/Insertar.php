<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $link = new PDO("mysql:host=localhost;port=3308; dbname=plancurricular", "root", "");
    $statement = $link->prepare("INSERT INTO materias (pagina, titulo, idcarreras) VALUES (:pag, :tit, :idcar)");

    $pag = $_POST["Pagina"];
    $tit = $_POST["Titulo"];
    $idcar = $_POST["Carrera"];

    $statement->bindParam(':pag', $pag);
    $statement->bindParam(':tit', $tit);
    $statement->bindParam(':idcar', $idcar);

    if ($statement->execute()) {
        header('Location: listar.php');
    } else {
        echo 'Ocurrió un error al insertar los datos en la base de datos.';
    }
}
?>
