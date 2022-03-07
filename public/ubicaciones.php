<?php

final class ubicaciones {
    private $Bd;
    private $Raiz = null;
    private $u_actual = null;

    public function __construct(string $raiz) {
        $this->Bd = new Bd();
        $this->Raiz = $raiz;
        $this->u_actual = Usuario::getIdActual();
    }

    public function get($id = null, string $params = null) {
        if($id != null) {
            $d = $this->Bd->seleccionar("ubicaciones", "id = $id")->fetch();
            if ($d != null) {
                $l = Ubicacion::fromArray($d);
                if (Ubicacion::esHijoDe($l->id, $this->Raiz)) {
                    return $l;
                }
            }
            return null;
        }
        
        return Ubicacion::obtTodos($this->Raiz, $params);
    }

    public function post(array $data): int {
        if($data !== null){
            $l = Ubicacion::fromArray($data);
            if (Ubicacion::esHijoDe($l->id_padre, $this->Raiz)) {
                if($this->Bd->insertar("ubicaciones", "'$l->ubicacion', $l->id_padre", "ubicacion, id_padre")){
                    $this->Bd->insertar("logs", "'ubicaciones', '0', $this->u_actual, '$l->ubicacion'", "tabla, tipo_cambio, id_usuario, objeto");
                    return $this->Bd->seleccionar("ubicaciones", "1", "max(id)")->fetch()['id'];
                }
            }
        }
        return 0;
    }

    public function put($ubicacion, array $data): bool {
        if($ubicacion !== null && $data !== null){
            $d = $this->get($ubicacion);
            if ($d != null) {
                $l = Ubicacion::fromArray($data);
                if (Ubicacion::esHijoDe($l->id_padre, $this->Raiz)) {
                    $id_padre = $d->id_padre;

                    if (Usuario::isAdmin($_SERVER['PHP_AUTH_USER'])) {
                        $id_padre = $l->id_padre;
                    }
                    if($this->Bd->actualizar("ubicaciones", "ubicacion = '$l->ubicacion', id_padre = $id_padre", "id = $d->id")){
                        $this->Bd->insertar("logs", "'ubicaciones', '2', $this->u_actual, '$l->ubicacion'", "tabla, tipo_cambio, id_usuario, objeto");
                        return true;
                    }
                }
            }
        }
        return false;
    }

    public function delete($ubicacion): bool {
        if($ubicacion !== null){
            $d = $this->get($ubicacion);
            if ($d != null) {
                if($d->id == $this->Raiz){
                    throw new ForbiddenException("No se puede eliminar el ubicacion actual.", 1);
                }
                if (Ubicacion::esHijoDe($d->id, $this->Raiz)) {
                    if($this->Bd->eliminar("ubicaciones", "id = $d->id")){
                        $this->Bd->insertar("logs", "'ubicaciones', '3', $this->u_actual, '$d->ubicacion'", "tabla, tipo_cambio, id_usuario, objeto");
                        return true;
                    }
                }
            }
        }
        return false;
    }
}