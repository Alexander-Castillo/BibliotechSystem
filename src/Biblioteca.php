<?php
class Biblioteca {
    private $libros = [];
    private $filePath = '../data/books.json';

    #biblioteca tiene cargar libros
    public function __construct(){
        $this->cargarLibros();
    }

    #metodo cargar libros
    public function cargarLibros(){
        #si no existe archivo json crearlo
        if (!file_exists($this->filePath)) {
            $this->crearInicialFileJson();
        }

        #en la variable json extrae los archivos de la ruta data los decodifica para que php pueda leerlos
        $json = file_get_contents($this->filePath);
        $data = json_decode($json, true);

        #recorrer el arreglo del json
        foreach ($data['libros'] as $bookData) {
            $libro = new Libro(
                $bookData['id'],
                $bookData['titulo'],
                $bookData['autor'],
                $bookData['categoria']
            );
            
            $libro->cambiarEstado($bookData['status']);
            $this->libros[] = $libro;
        }
    }

    #funcion crear archivo Json
    private function crearInicialFileJson(){
        $initialData = [
            'libros' => [],
            'usuarios' => []
        ];
        file_put_contents($this->filePath, json_encode($initialData, JSON_PRETTY_PRINT));
    }

    #metodo agregar libro
    public function agregarLibro(Libro $libro){
        $this->libros[] = $libro;
        $this->guardarLibros();
    }

    #metodo guardar Libros
    public function guardarLibros(){
        $data = ['libros' => []];
        foreach ($this->libros as $book) {
            $data['libros'][] = $book->getLibro();
        }
        file_put_contents($this->filePath, json_encode($data, JSON_PRETTY_PRINT));
    }

    #metodo para buscar un libro
    public function buscarLibros($buscado){
        $result = [];
        foreach ($this->libros as $book) {
            $details = $book->getLibro();
            if (strpos($details['titulo'], $buscado) !== false || strpos($details['autor'], $buscado) !== false || strpos($details['categoria'], $buscado) !== false) {
                $result[] = $details;
            }
        }
        return $result;
    }
}
?>