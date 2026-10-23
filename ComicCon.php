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