<?php
#01 crear la clase Usuarios
class Usuario{
    private $id;
    public $nombre;
    private $rol;
    private $prestados = [];
    private $filePath = '../data/users.json';


    #03 constructor
    public function __construct($id, $nombre, $rol){
        $this->setId($id);
        $this->nombre = $nombre;
        $this->SetRol($rol);

        $this->cargarUsuario();
    }

    #02 metodos getter y setter
    public function getId(){
        return $this->id;
    }

    public function SetId($id){
        $this->id = $id;
    }

    public function getRol(){
        return $this->rol;
    }

    public function SetRol($rol){
        $this->rol = $rol;
    }

    public function getPrestados(){
        return $this->prestados;
    }

    public function SetPrestados($prestados){
        $this->prestados = $prestados;
    }

    #05 metodo cargar usuarios

    private function crearInicialFileJson(){
        file_put_contents($this->filePath, json_encode([], JSON_PRETTY_PRINT));
    }
    private function cargarUsuario(){
        if (!file_exists($this->filePath)) {
            $this->crearInicialFileJson();
        }

        $json = file_get_contents($this->filePath);
        $data = json_decode($json, true);

        foreach ($data as $userData) {
            if ($userData['id'] == $this->id) {
                $this->prestados = $userData['prestados'];
                break;
            }
        }
    }


    #06 metodo agregar usuarios
    public function agregarUsuario($nombre, $rol){
        $id = count($this->cargarUsuarios()) + 1;
        $newUser = new Usuario($id, $nombre, $rol);
        
        #utlizamos el metodo de guardar usuario
        $this->guardarUsuario($newUser);
        return $newUser;
    }

    #07 metodo guardar usuario
    private function guardarUsuario(){
        $data = $this->cargarUsuarios();

        $datosUsuario = [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'rol' => $this->rol,
            'prestados' => $this->prestados
        ];

        $exists = false;
        foreach ($data as &$user) { // anteponer & al iterador $user, estás asegurando que cualquier modificación realizada a $user dentro del ciclo afecte directamente el array $data.
            if ($user['id'] == $this->id) {
                $user = $datosUsuario;
                $exists = true;
                break;
            }
        }

        if (!$exists) {
            $data[] = $datosUsuario;
        }

        file_put_contents($this->filePath, json_encode($data, JSON_PRETTY_PRINT));
    }
    #extraer y cargar los usuarios de json si existen o sino crearlos luego cargarlos
    private function cargarUsuarios(){
        if (!file_exists($this->filePath)) {
            $this->crearInicialFileJson();
        }
        $json = file_get_contents($this->filePath);
        return json_decode($json, true);
    }

    #08 metodo para libros prestados
    public function librosPrestados(Libro $book){
        if ($this->getRol() !== 'prestatario') {
            throw new Exception('Solo los prestatarios pueden pedir prestado un libro.');
        }
        if ($book->status === 'disponible') {
            $book->cambiarEstado('prestado');
            $this->prestados[] = $book->getLibro();
            $this->guardarUsuario();
            return true;
        }
        return false;
    }
}
?>