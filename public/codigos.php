<?php

final class codigos {
    private $Bd;
    private $Raiz = null;

    public function __construct(string $raiz) {
        $this->Bd = new Bd();
        $this->Raiz = $raiz;
    }

    public function get($codigo = null, $params = null) {
        if($codigo != null) {
            $d = $this->Bd->seleccionar("codigos left join ubicaciones on codigos.id_ubicacion = ubicaciones.id", "codigos.id = '$codigo'", "codigos.*, ubicaciones.ubicacion as ubicacion")->fetch();
            if ($d != null) {
                $c = Codigo::fromArray($d);
                if (Ubicacion::esHijoDe($c->id_ubicacion, $this->Raiz)) {
                    return $c;
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

        $d = $this->Bd->seleccionar("codigos left join ubicaciones on codigos.id_ubicacion = ubicaciones.id", "codigos.id_ubicacion in ($ids) $params", "codigos.*, ubicaciones.ubicacion as 'ubicacion'")->fetchAll();
        if ($d != null) {
            foreach ($d as $key => $value) {
                $t[count($t)] = Codigo::fromArray($value);
            }
        }
        return $t;
    }

    public function post(array $data): int {
        if($data !== null){
            $c = Codigo::fromArray($data);
            if (Ubicacion::esHijoDe($c->id_ubicacion, $this->Raiz)) {
                $activo = (int) $c->activo;

                if($this->Bd->insertar("codigos", "'$c->id', '$c->url_code', $activo, $c->hits, '$c->file', $c->id_ubicacion", "id, url_code, activo, hits, file, id_ubicacion")){
                    
                    return $this->Bd->seleccionar("codigos", "1", "max(id)")->fetch()['id'];
                }
            }
        }
        return 0;
    }

    public function put($codigo, array $data): bool {
        if($codigo !== null && $data !== null){
            $d = $this->get($codigo);
            if ($d != null) {
                $c = Codigo::fromArray($data);
                if (Ubicacion::esHijoDe($c->id_ubicacion, $this->Raiz)) {
                    $activo = (int) $c->activo;

                    if($this->Bd->actualizar("codigos", "url_code = '$c->url_code', activo = $activo, file = '$c->file', id_ubicacion = $c->id_ubicacion", "id = $d->id")){
                        return true;
                    }
                }
            }
        }
        return false;
    }

    public function delete($codigo): bool {
        if($codigo !== null){
            $d = $this->get($codigo);
            if ($d != null) {
                if (Ubicacion::esHijoDe($d->id_ubicacion, $this->Raiz)) {
                    if($this->Bd->eliminar("codigos", "id = '$d->codigo'")){
                        return true;
                    }
                }
                
            }
        }
        return false;
    }
}