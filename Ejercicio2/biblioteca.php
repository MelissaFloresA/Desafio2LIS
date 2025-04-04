

<?php
session_start(); 

// inicializar arreglo para guardar n numero de libros
if (!isset($_SESSION['libros'])) {
    $_SESSION['libros'] = [];
}

class Libro {
    public $autor;
    public $titulo;
    public $nedicion;
    public $lugar;
    public $editorial;
    public $añoedicion;
    public $npag;
    public $nota;
    public $isbn;

    function __construct($autor, $titulo, $nedicion, $lugar, $editorial, $añoedicion, $npag, $nota, $isbn) {
        $this->autor = $autor;
        $this->titulo = $titulo;
        $this->nedicion = $nedicion;
        $this->lugar = $lugar;
        $this->editorial = $editorial;
        $this->añoedicion = $añoedicion;
        $this->npag = $npag;
        $this->nota = $nota;
        $this->isbn = $isbn;
    }
}

$errores = [];
$autor = $titulo = $nedicion = $lugar = $editorial = $añoedicion = $npag = $nota = $isbn = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Expresiones regulares
    $expTitulo = '/^[^"]+$/';
    $expAutor = "/^[A-Za-z\s]+,\s?[A-Za-z\s]+$/";
    $expTexto = "/^[A-Za-z\s]+$/";
    $expNumero = "/^[0-9]+$/";
    $expAño = "/^\([1-2][0-9]{3}\)$/";
    $expISBN = "/^\d{4}[-]\d{4}[-]\d{4}[-]\d{1}$/";
    //$expISBN = "/^(97[89])[-]\d{3}[-]\d{4}[-]\d{2}[-]\d{1}$/";

   
   // validar autor
function validarAutor(&$errores, $expAutor) {
    
    $tipo_autor = $_POST['tipo_autor'] ?? "no";
    if ($tipo_autor === "si") {
        return "VARIOS AUTORES";
    } else {
        if (empty($_POST['autor']) || !preg_match($expAutor, $_POST['autor'])) {
            $errores['autor'] = "Ingrese un autor válido";
            return "";
        } else {
            return $_POST['autor'];
        }
    }
}


$autor = validarAutor($errores,$expAutor);
   
    // validar título
    if (empty($_POST['titulo']) || !preg_match($expTitulo, $_POST['titulo'])) {
        $errores['titulo'] = "Ingrese un título válido ";
    } else {
        $titulo = $_POST['titulo'];
    }

   

    // validar número de edición
    if (empty($_POST['nedicion']) || !preg_match($expNumero, $_POST['nedicion'])) {
        $errores['nedicion'] = "Ingrese un número de edición válido";
    } else {
        $nedicion = $_POST['nedicion'];
    }

    // validar lugar
    if (empty($_POST['lugar']) || !preg_match($expTexto, $_POST['lugar'])) {
        $errores['lugar'] = "Ingrese un lugar válido ";
    } else {
        $lugar = $_POST['lugar'];
    }

    // editorial
    if (empty($_POST['editorial']) || !preg_match($expTexto, $_POST['editorial'])) {
        $errores['editorial'] = "Ingrese una editorial válida ";
    } else {
        $editorial = $_POST['editorial'];
    }

    // año de edicion
    if (empty($_POST['añoedicion']) || !preg_match($expAño, $_POST['añoedicion'])) {
        $errores['añoedicion'] = "Ingrese un año válido entre parentesis";
    } else {
        $añoedicion = $_POST['añoedicion'];
    }

    // numero de pagina
    if (empty($_POST['npag']) || !preg_match($expNumero, $_POST['npag'])) {
        $errores['npag'] = "Ingrese un número de páginas válido (solo números).";
    } else {
        $npag = $_POST['npag'];
    }

    // validar isbn
    if (empty($_POST['isbn']) || !preg_match($expISBN, $_POST['isbn'])) {
        $errores['isbn'] = "Ingrese un ISBN válido con el formato: XXXX-XXXX-XXXX-X.";
    } else {
        $isbn = $_POST['isbn'];
    }

    // Validar nota
    $nota = empty($_POST['nota']) ? "Sin nota" : $_POST['nota'];

    
    if (empty($errores)) {
        $libro = new Libro($autor, $titulo, $nedicion, $lugar, $editorial, $añoedicion, $npag, $nota, $isbn);
       $_SESSION['libros'][] = $libro; 
        mostrarDatos(); 

        // limpiar formulario
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.4/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-DQvkBjpPgn7RC31MCQoOeC9TI2kdqa4+BSgNMNj8v77fdC77Kj5zpWFTJaaAoMbC" crossorigin="anonymous">
</head>



<script>
    function desactivarAutor(valor) {
        const desactivar = (valor === 'si');
        const input = document.getElementById('autor');
        input.disabled = desactivar;
    }
</script>

<body class="container bg-light">
    <header class="text-center">
        <h1 class="mt-4">Biblioteca</h1>
        
    </header>
    <div class="card mt-4 shadow">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0">Registro de libros</h4>
        </div>
        <div class="card-body">
            <form method="POST" class="row g-3">
        <div class="col-md-6">
            
            <div class="col-md-6 d-flex align-items-center">
            <label class="form-label me-2">Autor</label>
    <label for="tipo_autor" class="form-label me-2">¿Varios autores?</label>
    <select class="form-select form-select-sm w-auto" id="tipo_autor" name="tipo_autor" onchange="desactivarAutor(this.value)">
        <option value="no" <?= isset($_POST['tipo_autor']) && $_POST['tipo_autor'] === "no" ? "selected" : "" ?>>No</option>
        <option value="si" <?= isset($_POST['tipo_autor']) && $_POST['tipo_autor'] === "si" ? "selected" : "" ?>>Sí</option>
    </select>
</div>
            <input type="text" class="form-control" id="autor" name="autor" placeholder="Apellidos , Nombres" value="<?= htmlspecialchars($_POST['autor'] ?? '') ?>" <?= isset($_POST['tipo_autor']) && $_POST['tipo_autor'] === "si" ? "disabled" : "" ?>>
            <span style="color: red;"><?= $errores['autor'] ?? "" ?></span>
        </div>
        <div class="col-md-6">
            <label class="form-label">Título del libro</label>
            <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Titulo" value="<?= htmlspecialchars($_POST['titulo'] ?? '') ?>">
            <span style="color: red;"><?= $errores['titulo'] ?? "" ?></span>
        </div>
        <div class="col-md-6">
            <label class="form-label">Número de edición</label>
            <input type="text" class="form-control" id="nedicion" name="nedicion" placeholder="XXXX" value="<?= htmlspecialchars($_POST['nedicion'] ?? '') ?>">
            <span style="color: red;"><?= $errores['nedicion'] ?? "" ?></span>
        </div>
        <div class="col-md-6">
            <label class="form-label">Lugar de la publicación</label>
            <input type="text" class="form-control" id="lugar" name="lugar" placeholder="Lugar" value="<?= htmlspecialchars($_POST['lugar'] ?? '') ?>">
            <span style="color: red;"><?= $errores['lugar'] ?? "" ?></span>
        </div>
        <div class="col-md-6">
            <label class="form-label">Editorial</label>
            <input type="text" class="form-control" id="editorial" name="editorial" placeholder="Nombre de la editorial" value="<?= htmlspecialchars($_POST['editorial'] ?? '') ?>">
            <span style="color: red;"><?= $errores['editorial'] ?? "" ?></span>
        </div>
        <div class="col-md-6">
            <label class="form-label">Año de la edición</label>
            <input type="text" class="form-control" id="añoedicion" name="añoedicion" placeholder="(XXXX)" value="<?= htmlspecialchars($_POST['añoedicion'] ?? '') ?>">
            <span style="color: red;"><?= $errores['añoedicion'] ?? "" ?></span>
        </div>
        <div class="col-md-6">
            <label class="form-label">Número de páginas</label>
            <input type="text" class="form-control" id="npag" name="npag" placeholder="XXXX" value="<?= htmlspecialchars($_POST['npag'] ?? '') ?>">
            <span style="color: red;"><?= $errores['npag'] ?? "" ?></span>
        </div>
        <div class="col-md-6">
            <label class="form-label">Nota</label>
            <input type="text" class="form-control" id="nota" name="nota" placeholder="Escribe una observacion" value="<?= htmlspecialchars($_POST['nota'] ?? '') ?>">
        </div>
        <div class="col-md-6">
            <label class="form-label">ISBN</label>
            <input type="text" class="form-control" id="isbn" name="isbn" placeholder="XXXX-XXXX-XXXX-X" value="<?= htmlspecialchars($_POST['isbn'] ?? '') ?>">
            <span style="color: red;"><?= $errores['isbn'] ?? "" ?></span>
        </div>
        <div class="col-12 d-flex justify-content-center mt-3">
           
        <button type="submit" class="btn btn-secondary">Agregar</button>

        </div>
            </form>
        </div>
    </div>


    <?php
    // mostrar los libros ingresados n veces
    function mostrarDatos(){
if (!empty($_SESSION['libros'])) {
    echo "<h3 class='mt-4 text-center  table-title'>Libros registrados</h3>";
    echo "<div class='table-responsive'>";
    echo "<table class='table table-light table-striped table-bordered'>";
    echo "<thead '>";
    echo "<tr class='text-center table-success '>";
    echo "<th>Autor</th>";
    echo "<th>Título</th>";
    echo "<th>Número de edición</th>";
    echo "<th>Lugar</th>";
    echo "<th>Editorial</th>";
    echo "<th>Año de edición</th>";
    echo "<th>Número de páginas</th>";
    echo "<th>Nota</th>";
    echo "<th>ISBN</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    foreach ($_SESSION['libros'] as $libro) {
        echo "<tr>";
        echo "<td>{$libro->autor}</td>";
        echo "<td>{$libro->titulo}</td>";
        echo "<td>{$libro->nedicion}</td>";
        echo "<td>{$libro->lugar}</td>";
        echo "<td>{$libro->editorial}</td>";
        echo "<td>{$libro->añoedicion}</td>";
        echo "<td>{$libro->npag}</td>";
        echo "<td>{$libro->nota}</td>";
        echo "<td>{$libro->isbn}</td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
}
};
mostrarDatos();
?>
  

</body>
</html>