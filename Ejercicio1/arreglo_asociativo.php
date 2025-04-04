<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SINTAXIS ARREGLO ASOCIATIVO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.4/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-DQvkBjpPgn7RC31MCQoOeC9TI2kdqa4+BSgNMNj8v77fdC77Kj5zpWFTJaaAoMbC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.4/dist/js/bootstrap.bundle.min.js" integrity="sha384-YUe2LzesAfftltw+PEaao2tjU/QATaW/rOitAq67e0CT0Zi2VVRL0oC4+gAaeBKu" crossorigin="anonymous"></script>
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
        //ARREGLO ASOCIATIVO
        $academia = [
            "básico" => ["inglés" => 25, "francés" => 10, "mandarin" => 8, "ruso" => 12, "portugués" => 30, "japonés" => 90],
            "intermedio" => ["inglés" => 15, "francés" => 5, "mandarin" => 4, "ruso" => 8, "portugués" => 15, "japonés" => 25],
            "avanzado" => ["inglés" => 10, "francés" => 2, "mandarin" => 1, "ruso" => 4, "portugués" => 10, "japonés" => 67]
        ];

      
        //recorre llaves (niveles) para guardar sus valores en filas
        function recorrido($matriz, $idioma) {
            $filas = '';
            foreach ($matriz as $nivel => $idiomas) {
                // Asignamos clases de Bootstrap según el nivel
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
                //               agrega clase para color    primer letra mayus            [basico][ingles]
            }
            return $filas;
        }
       
   // estrucctura de tabla por idioma
   function MostrarResultados($matriz, $idioma) {
    echo '<div class="col-md-6 col-lg-4 mb-3">';
    echo '<table class="table table-bordered tabla-idiomas">'; //para style
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