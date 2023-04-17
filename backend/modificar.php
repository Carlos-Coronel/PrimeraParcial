<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar programa</title>
    <link rel="stylesheet" href="../frontend/estilos/estilos.css">
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
                <label for="pagina">Id:</label>
                <div class="container">
                    <input type="text" name="codigo" readonly value="<?php echo $programa["idmaterias"]; ?>" class="input-codigo">
                    <a href="mostrar.php?idmaterias=<?php echo $programa["idmaterias"]; ?>" class="ver-pagina">Ver página</a>
                </div>
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
                <button type="submit" class="boton-actualizar">Actualizar</button>
                <button onclick="window.location.href='listar.php'" class="boton-cancelar">Cancelar</button>
            </div>
        </form>
    </div>
    <script src="https://cdn.ckeditor.com/ckeditor5/37.0.1/super-build/ckeditor.js"></script>
    <script>
             CKEDITOR.ClassicEditor.create(document.getElementById("Container"), {
                toolbar: {
                    items: [
                        'exportPDF', 'exportWord', '|',
                        'findAndReplace', 'selectAll', '|',
                        'heading', '|',
                        'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript', 'superscript', 'removeFormat', '|',
                        'bulletedList', 'numberedList', 'todoList', '|',
                        'outdent', 'indent', '|',
                        'undo', 'redo',
                        '-',
                        'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
                        'alignment', '|',
                        'link', 'insertImage', 'blockQuote', 'insertTable', 'mediaEmbed', 'codeBlock', 'htmlEmbed', '|',
                        'specialCharacters', 'horizontalLine', 'pageBreak', '|',
                        'textPartLanguage', '|',
                        'sourceEditing'
                    ],
                    shouldNotGroupWhenFull: true
                },
                list: {
                    properties: {
                        styles: true,
                        startIndex: true,
                        reversed: true
                    }
                },
                heading: {
                    options: [{
                            model: 'paragraph',
                            title: 'Paragraph',
                            class: 'ck-heading_paragraph'
                        },
                        {
                            model: 'heading1',
                            view: 'h1',
                            title: 'Heading 1',
                            class: 'ck-heading_heading1'
                        },
                        {
                            model: 'heading2',
                            view: 'h2',
                            title: 'Heading 2',
                            class: 'ck-heading_heading2'
                        },
                        {
                            model: 'heading3',
                            view: 'h3',
                            title: 'Heading 3',
                            class: 'ck-heading_heading3'
                        },
                        {
                            model: 'heading4',
                            view: 'h4',
                            title: 'Heading 4',
                            class: 'ck-heading_heading4'
                        },
                        {
                            model: 'heading5',
                            view: 'h5',
                            title: 'Heading 5',
                            class: 'ck-heading_heading5'
                        },
                        {
                            model: 'heading6',
                            view: 'h6',
                            title: 'Heading 6',
                            class: 'ck-heading_heading6'
                        }
                    ]
                },
                placeholder: 'Welcome to CKEditor 5!',
                fontFamily: {
                    options: [
                        'default',
                        'Arial, Helvetica, sans-serif',
                        'Courier New, Courier, monospace',
                        'Georgia, serif',
                        'Lucida Sans Unicode, Lucida Grande, sans-serif',
                        'Tahoma, Geneva, sans-serif',
                        'Times New Roman, Times, serif',
                        'Trebuchet MS, Helvetica, sans-serif',
                        'Verdana, Geneva, sans-serif'
                    ],
                    supportAllValues: true
                },
                fontSize: {
                    options: [10, 12, 14, 'default', 18, 20, 22],
                    supportAllValues: true
                },
                htmlSupport: {
                    allow: [{
                        name: /.*/,
                        attributes: true,
                        classes: true,
                        styles: true
                    }]
                },
                htmlEmbed: {
                    showPreviews: true
                },
                link: {
                    decorators: {
                        addTargetToExternalLinks: true,
                        defaultProtocol: 'https://',
                        toggleDownloadable: {
                            mode: 'manual',
                            label: 'Downloadable',
                            attributes: {
                                download: 'file'
                            }
                        }
                    }
                },
                mention: {
                    feeds: [{
                        marker: '@',
                        feed: [
                            '@apple', '@bears', '@brownie', '@cake', '@cake', '@candy', '@canes', '@chocolate', '@cookie', '@cotton', '@cream',
                            '@cupcake', '@danish', '@donut', '@dragée', '@fruitcake', '@gingerbread', '@gummi', '@ice', '@jelly-o',
                            '@liquorice', '@macaroon', '@marzipan', '@oat', '@pie', '@plum', '@pudding', '@sesame', '@snaps', '@soufflé',
                            '@sugar', '@sweet', '@topping', '@wafer'
                        ],
                        minimumCharacters: 1
                    }]
                },
                removePlugins: [
                    'CKBox',
                    'CKFinder',
                    'EasyImage',
                    'RealTimeCollaborativeComments',
                    'RealTimeCollaborativeTrackChanges',
                    'RealTimeCollaborativeRevisionHistory',
                    'PresenceList',
                    'Comments',
                    'TrackChanges',
                    'TrackChangesData',
                    'RevisionHistory',
                    'Pagination',
                    'WProofreader',
                    'MathType'
                ]
            })
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