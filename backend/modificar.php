<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar programa</title>
    <link rel="stylesheet" href="../frontend/estilos/estilos.css">
    <script src="https://cdn.ckeditor.com/ckeditor5/37.0.1/decoupled-document/ckeditor.js"></script>
</head>

<body>
    <div class="contenedor">
        <h1>Editar programa</h1>
        <form method="post" action="Actualizar.php">
            <?php
            // Obtener el id del programa a editar
            $id = $_GET['id'];
            try {
                // Conectar a la base de datos
                $conn = new PDO("mysql:host=localhost;port=3308; dbname=plancurricular", "root", "");
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Obtener los datos del programa correspondiente al id
                $stmt = $conn->prepare("SELECT * FROM materias WHERE idmaterias = :id");
                $stmt->bindParam(':id', $id);
                $stmt->execute();
                $programa = $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                echo "Error de conexión: " . $e->getMessage();
            }
            ?>
            <div class="campo">
                <input type="text" name="codigo" readonly value="<?php echo $programa["idmaterias"]; ?>">

                <label for="titulo">Título:</label>
                <input type="text" name="Titulo" id="titulo" value="<?php echo $programa["titulo"]; ?>" required>

                <label for="pagina">Página:</label>
                <div id="toolbar-container"></div>
                <div id="Container">
                    <?php echo $programa["pagina"]; ?>
                </div>
                <input type="hidden" name="Pagina" id="editorContent">

                <label>Carreras:</label>
                <?php
                try {
                    $stmt = $conn->query("SELECT * FROM carreras");
                    $carreras = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    echo "<select name='Carrera' id='carreras'>";
                    foreach ($carreras as $carrera) {
                        if ($programa["idcarreras"] == $carrera["idcarreras"]) {
                            echo "<option value='{$carrera["idcarreras"]}' selected>{$carrera["descripcion"]}</option>";
                        } else {
                            echo "<option value='{$carrera["idcarreras"]}'>{$carrera["descripcion"]}</option>";
                        }
                    }
                    echo "</select>";
                } catch (PDOException $e) {
                    echo "Error de conexión: " . $e->getMessage();
                }
                ?>
            </div>
            <div class="boton">
                <button type="submit">Actualizar</button>
            </div>
        </form>
        <a href="mostrar.php?idmaterias=22">Ver página</a>
    </div>

    <script>
        DecoupledEditor
            .create(document.querySelector('#Container'))
            .then(editor => {
                const toolbarContainer = document.querySelector('#toolbar-container');

                toolbarContainer.appendChild(editor.ui.view.toolbar.element);

                document.querySelector('form').addEventListener('submit', function() {
                    document.querySelector('#editorContent').value = editor.getData();
                });
            })
            .catch(error => {
                console.error(error);
            });
    </script>
</body>

</html>