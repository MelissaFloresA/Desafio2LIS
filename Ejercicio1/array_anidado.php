<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SINTAXIS ARREGLO con array() anidado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.4/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
          body {
            background-image: url('https://img.freepik.com/vector-gratis/fondo-abstracto-azul-grunge-efecto-semitono_1017-32529.jpg');
            background-repeat: no-repeat;
            background-size: cover;
        }
        .contenedor {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
           
        }
        .tabla-idiomas {
            font-size: 1.05rem;
        }
        .tabla-idiomas th {
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="contenedor">
            <h1 class="text-center mb-4">Academia de Idiomas</h1>
        <?php
        // ARREGLO con sintaxis array() anidado en vez de [*]
        $academia = array(
            "básico" => array(
                "inglés" => 25, 
                "francés" => 10, 
                "mandarin" => 8, 
                "ruso" => 12, 
                "portugues" => 30, 
                "japones" => 90
            ),
            "intermedio" => array(
                "inglés" => 15, 
                "francés" => 5, 
                "mandarin" => 4, 
                "ruso" => 8, 
                "portugues" => 15, 
                "japones" => 25
            ),
            "avanzado" => array(
                "inglés" => 10, 
                "francés" => 2, 
                "mandarin" => 1, 
                "ruso" => 4, 
                "portugues" => 10, 
                "japones" => 67
            )
        );

        // Función para generar filas de la tabla
        function recorrido($matriz, $idioma) {
            $filas = '';
            foreach ($matriz as $nivel => $idiomas) {
                $clase = '';
                switch($nivel) {
                    case 'básico':
                        $clase = 'table-success';
                        break;
                    case 'intermedio':
                        $clase = 'table-warning';
                        break;
                    case 'avanzado':
                        $clase = 'table-danger';
                        break;
                }
                $filas .= '<tr class="'.$clase.'"><td>'.ucfirst($nivel).'</td><td>'.$idiomas[$idioma].'</td></tr>';
            }
            return $filas;
        }

        // Función para mostrar la tabla de cada idioma
        function MostrarResultados($matriz, $idioma) {
            echo '<div class="col-md-6 col-lg-4 mb-3">';
            echo '<table class="table table-bordered">';
            echo '<thead><tr class="text-center table-primary"><th colspan="2">'.ucfirst($idioma).'</th></tr></thead>';
            echo '<tbody>';
            echo recorrido($matriz, $idioma);
            echo '</tbody>';
            echo '</table>';
            echo '</div>';
        }

        // Imprimir todos los idiomas
        echo '<div class="row">';
        foreach (array_keys($academia['básico']) as $idioma) {
            MostrarResultados($academia, $idioma);
        }
        echo '</div>';
        ?>
    </div>
    </div>
</body>
</html>