<?php

final class usuarios {
    private $Bd;
    private $Raiz = null;
    private $u_actual = null;

    public function __construct(string $raiz) {
        $this->Bd = new Bd();
        $this->Raiz = $raiz;
        $this->u_actual = Usuario::getIdActual();
    }

    public function get($usuario = null, $params = null) {
        if($usuario != null) {
            if(is_numeric($usuario)){
                $d = $this->Bd->seleccionar("usuarios left join ubicaciones on usuarios.id_ubicacion = ubicaciones.id", "usuarios.id = $usuario", "usuarios.*, ubicaciones.ubicacion")->fetch();

            } else {

                $d = $this->Bd->seleccionar("usuarios left join ubicaciones on usuarios.id_ubicacion = ubicaciones.id", "usuarios.usuario = '$usuario'", "usuarios.*, ubicaciones.ubicacion as ubicacion")->fetch();
            }
            if ($d != null) {
                $u = Usuario::fromArray($d);
                if (Ubicacion::esHijoDe($u->id_ubicacion, $this->Raiz)) {
                    return $u;
                }
            }
            return null;
        }

        $t = null;
        $l = Ubicacion::obtTodos($this->Raiz);
        if(!empty($params)){
            $params = "&&".$params;
        }
        $ids = null;
        for ($i=0; $i < count($l); $i++) { 
            $ids = $ids.$l[$i]->id;
            if($i < count($l)-1){
                $ids = $ids.", ";
            }
        }

        $d = $this->Bd->seleccionar("usuarios left join ubicaciones on usuarios.id_ubicacion = ubicaciones.id", "usuarios.id_ubicacion in ($ids) $params", "usuarios.*, ubicaciones.ubicacion as 'ubicacion'")->fetchAll();
        if ($d != null) {
            foreach ($d as $key => $value) {
                $t[count($t)] = Usuario::fromArray($value);
            }
        }
        return $t;
    }

    public function post(array $data): int {
        if($data !== null){
            $u = Usuario::fromArray($data);
            if (Ubicacion::esHijoDe($u->id_ubicacion, $this->Raiz)) {
                $admin = (int) $u->admin;
                $clave = sha1($u->clave);

                if($this->Bd->insertar("usuarios", "'$u->usuario', '$u->nombre', '$clave', $admin, $u->id_ubicacion", "usuario, nombre, clave, admin, id_ubicacion")){
                    
                    $this->Bd->insertar("logs", "'usuarios', '0', $this->u_actual, '$u->usuario'", "tabla, tipo_cambio, id_usuario, objeto");
                    return $this->Bd->seleccionar("usuarios", "1 ORDER BY id DESC LIMIT 1", "id")->fetch()['id'];
                }
            }
        }
        return 0;
    }

    public function put($usuario, array $data): bool {
        if($usuario !== null && $data !== null){
            $d = $this->get($usuario);
            if ($d != null) {
                $u = Usuario::fromArray($data);
                if (Ubicacion::esHijoDe($u->id_ubicacion, $this->Raiz)) {
                    $admin = (int) $u->admin;
                    $usuario_u = $u->usuario;
                    $id_ubicacion = $u->id_ubicacion;

                    if ($this->u_actual == $d->id || !Usuario::isAdmin($_SERVER['PHP_AUTH_USER'])) {
                        $admin = (int) $d->admin;
                        $usuario_u = $d->usuario;
                        $id_ubicacion = $d->id_ubicacion;
                    }
                    if($this->Bd->actualizar("usuarios", "usuario = '$usuario_u', nombre = '$u->nombre', admin = $admin, id_ubicacion = $id_ubicacion", "id = $d->id")){
                        $this->Bd->insertar("logs", "'usuarios', '2', $this->u_actual, '$u->usuario'", "tabla, tipo_cambio, id_usuario, objeto");
                        return true;
                    }
                }
            }
        }
        return false;
    }

    public function delete($usuario): bool {
        if($usuario !== null){
            $d = $this->get($usuario);
            if ($d != null) {
                if($d->usuario == $_SERVER['PHP_AUTH_USER']){
                    throw new ForbiddenException("No se puede eliminar el usuario actual.", 1);
                }
                if (Ubicacion::esHijoDe($d->id_ubicacion, $this->Raiz)) {
                    if($this->Bd->eliminar("usuarios", "usuario = '$d->usuario'")){
                        $this->Bd->insertar("logs", "'usuarios', '3', $this->u_actual, '$d->usuario'", "tabla, tipo_cambio, id_usuario, objeto");
                        return true;
                    }
                }
                
            }
        }
        return false;
    }
}