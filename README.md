# Requisitos Técnicos y Funcionales
El archivo comicon.php debe cumplir estrictamente con los siguientes requisitos:

**Bloque 1: Configuración y Control de Errores**
Configura el archivo para que muestre todos los errores de PHP en pantalla durante el desarrollo.
Envuelve todo el procesamiento del formulario en un bloque try/catch/finally.
Si ocurre algún error de validación crítico, se debe lanzar una excepción. En el bloque catch se capturara el mensaje de error para mostrárselo al usuario.
En el bloque finally, utiliza la funcion error_log para registrar de forma interna en el servidor que la operacion ha sido procesada, indicando la fecha actual y si el resultado fue exitoso o fallido.


**Bloque 2: El Formulario HTML (La Vista)**
El formulario debe enviarse por el metodo POST al mismo archivo e incluir los siguientes campos:

Nombre completo: Campo de texto.
Edad: Campo numérico.
Tipo de Entrada: Selector desplegable con tres opciones: General (disponible), VIP (disponible) o Infantil (disponible).
Talleres Especiales: Grupo de casillas de verificación (checkboxes) para apuntarse a tres talleres independientes: Torneo de Videojuegos (10 euros), Taller de Cosplay (15 euros) y Zona de Rol en Vivo (5 euros).


**Bloque 3: Procesamiento y Lógica en PHP (El Controlador)**
El script debe detectar si se ha enviado el formulario por POST utilizando la superglobal correspondiente.

Saneamiento y Validación: * Recupera los datos de forma segura utilizando el operador de Fusión de Nulos (Null Coalescing) para evitar advertencias si el usuario no selecciona ningún taller.
Sanea el nombre utilizando funciones que eviten la inyección de código malicioso (XSS).
Valida que la edad sea un número entero positivo. Si la edad es menor de 18 años y ha seleccionado entrada VIP, la aplicación debe lanzar una excepción con el mensaje: "La entrada VIP está restringida a mayores de edad".
Funciones y Cálculos:
Crea una función con tipado estricto de parametros y de retorno llamada calcularPrecioBase(string $tipo): int. Usara una estructura switch para asignar los costes: General (30 euros), VIP (60 euros), Infantil (10 euros).
Crea otra función llamada procesarInscripcion() que calcule el precio total sumando el precio base de la entrada y el coste de cada taller seleccionado (recorriendo los talleres con un bucle foreach).
Control de Ámbitos: Las variables que almacenen los resultados finales deben ser accesibles para pintarse en el HTML inferior, gestionando correctamente su alcance.


**Bloque 4: Renderizado de Resultados (El Resguardo)**
Si el formulario ha sido procesado con éxito, se ocultará o se mostrará debajo del formulario un resguardo limpio con la sintaxis de plantilla alternativa de PHP (if(): ... endif;), detallando:

Nombre del asistente.
Tipo de entrada y su coste base.
Lista de talleres seleccionados y el coste individual de cada uno.
Precio total final a pagar.
