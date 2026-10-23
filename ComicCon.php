<?php
declare(strict_types=1); //Activamos el tipado estricto.

//Control de errores y configuración.

ini_Set('display_errors', '1'); //Mostramos errores por pantalla.
ini_set('display_startup_errors', '1'); //Errores al arrancar el PHP.
error_reporting(E_ALL); //Avisa del error en todos los niveles del código.

//Talleres de la Comicon

const TALLERES = [
    'juegos' => ['nombre' => 'Torneo de juegos', 'precio' => 10],
    'disfraz' => ['nombre' => 'Taller de disfraces', 'precio' => 15],
    'rol' => ['nombre' => 'Zona de rol', 'precio' => 5],
];

//Devolverá el precio de la entrada según su tipo.

function calcularPrecioBase(string $tipo): int
{
    switch ($tipo) {
        case 'General':
            return 30;
        case 'VIP':
            return 60;
        case 'Infantil':
            return 10; //Return que sale de la función.
        default: //Default con excepción para evitar datos inexistentes.
            throw new Exception('Esta clase de entrada no está permitida');
    }
}

//Calculamos el precio total de las entradas con su taller seleccionado.
function procesarInscripcion(string $tipo, array $talleres): array
{
    $precioBase = calcularPrecioBase($tipo);
    $total = $precioBase;
    $detalleTalleres = [];

    //Recorremos las claves de los talleres que se marquen.
    foreach ($talleres as $clave) {
        if (!isset(TALLERES[$clave])) {
            throw new Exception('Este taller no existe.');
        }
        $detalleTalleres[] = TALLERES[$clave];
        $total += TALLERES[$clave]['precio'];
    }

    //Devolver array con resguardo.
    return [
        'precioBase' => $precioBase,
        'talleres' => $detalleTalleres,
        'total' => $total,
    ];

}

//Declaración de variables para su uso en HTML:
$exito = false;
$error = '';
$nombre = '';
$tipo = '';
$resultado = [];

//Procesar si se ha enviado correctamente el formulario.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $nombre = htmlspecialchars(trim($_POST['nombre'] ?? ''), ENT_QUOTES, 'UTF-8');
        $edad = filter_var($_POST['edad'] ?? '', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
        $tipo = $_POST['tipo'] ?? '';
        $talleres = (array) ($_POST['talleres'] ?? []);
        if ($nombre === '') {
            throw new Exception('El nombre del comprador es obligatorio.');
        }
        if ($edad === false) {
            throw new Exception('La edad debe ser un número entero positivo.');
        }
        if ($edad < 18 && $tipo === 'VIP') {
            throw new Exception('La entrada VIP está restringida a mayores de edad.');
        }
        //Cálculo. 
        $resultado = procesarInscripcion($tipo, $talleres);
        $exito = true;

    } catch (Exception $e) {
        $error = $e->getMessage();
    } finally {
        error_log(date('Y/m/d-H:i:s') . '-Inscripción Comic-Con procesada: ' . ($exito ? 'EXITOSA' : 'FALLIDA'));
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INSCRIPCIÓN A LA COMI-CON</title>
</head>

<body>
    <h1> Inscripción Comic-Con</h1>

        <form>
        <method= "post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">
            <p>
                <label for="nombre">Nombre completo:</label>
                <input type="text" id="nombre" name="nombre" required>
            </p>
            <p>
                <label for="edad">Edad:</label>
                <input type="number" id="edad" name="edad" min="1" step="1" required>
            </p>

            <p>
                <label for="tipo">Tipo de entrada:</label>
                <select id="tipo" name="tipo">
                    <option value="General">General (disponible)</option>
                    <option value="VIP">VIP (disponible)</option>
                    <option value="Infantil">Infantil (disponible)</option>
                </select>
            </p>

            <fieldset>
                <legend>Talleres especiales</legend>
                <?php foreach (TALLERES as $clave => $taller): ?>
                    <label>
                        <input type="checkbox" name="talleres[]" value="<?= $clave ?>">
                        <?= $taller['nombre'] ?> (
                        <?= $taller['precio'] ?> €)
                    </label><br>
                <?php endforeach; ?>
            </fieldset>

            <button type="submit">Inscribirme</button>
    </form>
    </form>
</body>

</html>