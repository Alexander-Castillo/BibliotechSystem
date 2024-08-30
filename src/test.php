<?php
require_once 'Libro.php';
require_once 'Usuario.php';
require_once 'Biblioteca.php';

//crear instancia biblioteca
$biblioteca = new Biblioteca();
//crear y agregar libros
$libro1 = new Libro(0001, '1984','George Orwell','Ficcion');
$libro2 = new Libro(0002, 'El Principito','Antoine de Saint-Exupéry','Infantil');
$libro3 = new Libro(0003, 'Cien Años de Soledad','Gabriel García Márquez','Realismo Mágico');

$biblioteca->agregarLibro($libro1);
$biblioteca->agregarLibro($libro2);
$biblioteca->agregarLibro($libro3);

// Imprimir listado de libros antes del préstamo
echo "Listado de libros antes del préstamo:\n";
print_r($biblioteca->buscarLibros('')); // Imprimir todos los libros

//Busqueda de Libros por título o autor
$libroEncontrado = $biblioteca->buscarLibros('Gabriel');
echo "libro buscado: \n";
print_r($libroEncontrado);

//Crear usuario prestatario
$usuario = new Usuario(0001,'Alexander Castillo','prestatario');
$usuario2 = new Usuario(0002, 'María López', 'prestatario');

//El usuario presta libro
try{
    $usuario->librosPrestados($libro2);
    $usuario2->librosPrestados($libro3);
} catch (Exception $e){
    echo $e->getMessage();
}

// Imprimir listado de libros después del préstamo
echo "\nListado de libros después del préstamo:\n";
print_r($biblioteca->buscarLibros('')); // Imprimir todos los libros

//Guardar Cambios en  Biblioteca 
$biblioteca->guardarLibros();

// Mostrar todos los usuarios y sus libros prestados
$usuarios = json_decode(file_get_contents('../data/users.json'), true);
foreach ($usuarios as $user) {
    echo "Usuario: {$user['nombre']} - Libros Prestados: ";
    print_r($user['prestados']);
}
?>