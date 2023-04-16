<?php
try {
    $pdo = new PDO("mysql:host=localhost;port=3308; dbname=plancurricular", "root", "");
} catch (PDOException $e) {
    echo 'Error al conectarse a la base de datos: ' . $e->getMessage();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM materias WHERE idmaterias = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    header('Location: listar.php');
}
?>