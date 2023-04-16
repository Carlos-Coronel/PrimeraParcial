<!DOCTYPE html>
<html>

<head>
    <title>Listado de usuarios</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4-4.6.0/jq-3.6.0/dt-1.11.2/datatables.min.css" />
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4-4.6.0/jq-3.6.0/dt-1.11.2/datatables.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="../frontend/estilos/estilos.css">
</head>

<body>
    <div class="container-table">
        <table id="miTabla" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Identificador</th>
                    <th>Titulo</th>
                    <th>Carrera</th>
                    <th>
                        <a href="agregar.php" style="color: white;"><i class="fas fa-plus-circle"></i> Acciones</a>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                try {
                    $pdo = new PDO("mysql:host=localhost;port=3308; dbname=plancurricular", "root", "");
                } catch (PDOException $e) {
                    echo 'Error al conectarse a la base de datos: ' . $e->getMessage();
                }

                // Consulta SQL para obtener los datos de la tabla "usuarios"
                $sql = "SELECT materias.idmaterias as id, materias.titulo, carreras.descripcion as carrera FROM materias
                INNER JOIN carreras ON materias.idcarreras = carreras.idcarreras";

                // Ejecutar la consulta y obtener los resultados
                $resultado = $pdo->query($sql);

                // Mostrar los resultados en una tabla HTML
                foreach ($resultado as $fila) {
                    echo "<tr><td>" . $fila['id'] . "</td><td>" . $fila['titulo'] . "</td><td>" . $fila['carrera'] . "</td>
                    <td><a href='eliminar.php?id=" . $fila['id'] . "'><i class='fas fa-trash-alt'></i> Eliminar</a><br><a href='modificar.php?id=" . $fila['id'] . "'><i class='fas fa-edit'></i> Modificar</a></td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script>
        // Inicialización de DataTables en la tabla
        $(document).ready(function() {
            $('#miTabla').DataTable();
        });
    </script>
</body>

</html>