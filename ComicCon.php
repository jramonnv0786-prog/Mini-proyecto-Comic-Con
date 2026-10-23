<?php
declare(strict_types=1); //Activamos el tipado estricto.

//BLOQUE 1: Control de errores y configuración.

ini_Set('display_errors', '1'); //Mostramos errores por pantalla.
ini_set('display_startup_errors', '1'); //Errores al arrancar el PHP.
error_reporting(E_ALL); //Avisa del error en todos los niveles del código.

//Talleres de la Comicon

const talleres = [
    'juegos' => ['nombre' => 'Torneo de juegos', 'precio' => 10],
    'disfraz' => ['nombre' => 'Taller de disfraces', 'precio' => 15],
    'rol' => ['nombre' => 'Zona de rol', 'precio' => 5],
];
// FUNCIONES
//Devolverán el precio de la entrada según su tipo

function calcularPrecioBase(string $tipo): int
{
    switch ($tipo) {
        case 'General':
            return 30;
        case 'VIP':
            return 60;
        case 'Infantil':
            return 10;
        default:
            throw new Exception('Esta clase de entrada no está permitida');
    }
}