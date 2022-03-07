<?php

final class Usuario {
    public $id = null;
    public $usuario = null;
    public $nombre = null;
    public $admin = false;
    public $clave = null;
    public $id_ubicacion = 0;
    public $ubicacion = null;
    
    public function __construct(int $id = null, string $usuario = null, string $nombre = null, string $clave = null, bool $admin = false, int $id_ubicacion = 0, string $ubicacion = null) {
        $this->id = $id;
        $this->usuario = $usuario;
        $this->nombre = $nombre;
        $this->clave = $clave;
        if($admin != null){
            $this->admin = $admin;
        }
        $this->id_ubicacion = $id_ubicacion;
        $this->ubicacion = $ubicacion;
    }

    public static function fromArray(array $data): Usuario {
        return new Usuario($data['id'], $data['usuario'], $data['nombre'], $data['clave'], $data['admin'], $data['id_ubicacion'], $data['ubicacion']);
    }

    public static function getId(string $usuario): int {
        $bd = new Bd();
        return $bd->seleccionar("usuarios", "usuario = '$usuario'", "id")->fetch()['id'];
    }

    public static function getUbicacion(string $usuario): int {
        if($usuario == null){
            return -1;
        }
        $bd = new Bd();
        return $bd->seleccionar("usuarios", "usuario = '$usuario'", "id_ubicacion")->fetch()['id_ubicacion'];
    }

    public static function getIdActual(): int {
        return Usuario::getId($_SERVER['PHP_AUTH_USER']);
    }

    public static function authenticate($usuario, $clave): bool {
        $bd = new Bd();
        $clave = sha1($clave);
        return $bd->contarRegistros("usuarios", "usuario = '$usuario' and clave = '$clave'");
    }

    public static function isAdmin($usuario): bool {
        $bd = new Bd();
        return $bd->seleccionar("usuarios", "usuario = '$usuario'", "admin")->fetch()["admin"];
    }

    public static function passwd($usuario, $clave, $clave_nueva): bool {
        if(Usuario::authenticate($usuario, $clave)) {
            $bd = new Bd();
            $clave_nueva = sha1($clave_nueva);
            return $bd->actualizar("usuarios", "clave = '$clave_nueva'", "$usuario = '$usuario'");
        }
        return false;
    }
}