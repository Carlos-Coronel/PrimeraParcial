<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carga de programas</title>
    <link rel="stylesheet" href="../frontend/estilos/estilos.css">
    <script src="https://cdn.ckeditor.com/ckeditor5/37.0.1/decoupled-document/ckeditor.js"></script>
</head>
<body>
    <div class="contenedor">
        <h1>Carga de programas</h1>
        <form method="post" action="Insertar.php">
            <div class="campo">
                <label for="titulo">Título:</label>
                <input type="text" name="Titulo" id="titulo" required>
            </div>
            <div class="campo">
                <label for="pagina">Página:</label>
                <div id="toolbar-container"></div>

                <div id="Container">
                </div>

                <input type="hidden" name="Pagina" id="editorContent">
            </div>
            <div class="campo">
                <label>Carreras:</label>
                <?php
                try {
                    $conn = new PDO("mysql:host=localhost;port=3308; dbname=plancurricular", "root", "");
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $stmt = $conn->query("SELECT * FROM carreras");
                    $carreras = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    echo "<select name='Carrera' id='carreras'>";
                    foreach ($carreras as $carrera) {
                        echo "<option value='{$carrera["idcarreras"]}'>{$carrera["descripcion"]}</option>";
                    }
                    echo "</select>";
                } catch (PDOException $e) {
                    echo "Error de conexión: " . $e->getMessage();
                }
                ?>
            </div>
            <div class="boton">
                <button type="submit">Enviar</button>
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