<?php
class Libro {
    public $id;
    private $titulo;
    private $autor;
    private $categoria;
    public $status;

    public function __construct($id, $titulo, $autor, $categoria, $status = 'disponible') {
        $this->id = $id;
        $this->setTitulo($titulo);
        $this->setAutor($autor);
        $this->setCategoria($categoria);
        $this->status = $status;
    }
    public function setTitulo($titulo){
        $this->titulo = $titulo;
    }
    public function getTitulo(){
        return $this->titulo;
    }
    public function setAutor($autor){
        $this->autor = $autor;
    }
    public function getAutor(){
        return $this->autor;
    }
    public function setCategoria($categoria){
        $this->categoria = $categoria;
    }
    public function getCategoria(){
        return $this->categoria;
    }
    public function getLibro(){
        return [
            'id'=> $this->id,
            'titulo'=> $this->titulo,
            'autor'=> $this->autor,
            'categoria'=> $this->categoria,
            'status'=> $this->status
        ];
    }
    public function editLibro($titulo, $autor, $categoria){
        $this->titulo = $titulo;
        $this->autor = $autor;
        $this->categoria = $categoria;
    }
    public function cambiarEstado($status){
        $this->status = $status;
    }

}
?>