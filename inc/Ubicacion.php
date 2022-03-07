<?php

final class Ubicacion {
    public $id = null;
    public $ubicacion = null;
    public $id_padre = 0;
    private static $r = null;
    
    public function __construct(int $id = null, string $ubicacion = null, $id_padre = null) {
        $this->id = $id;
        $this->ubicacion = $ubicacion;
        $this->id_padre = (int) $id_padre;
    }

    public static function fromArray(array $data): Ubicacion {
        return new Ubicacion($data['id'], $data['ubicacion'], $data['id_padre']);
    }

    public static function esHijoDe($ubicacion, $padre): bool {
        $bd = new Bd();
        $consulta = "with recursive arbol as (select * from ubicaciones where id = $ubicacion union all select child.* from ubicaciones as child join arbol as parent on parent.id_padre = child.id) select count(id) as r from arbol where id = $padre";
        $r = $bd->ejecutar($consulta)->fetch()['r'];
        return $r;
    }

    public static function obtTodos($raiz, $params = null) {
        if(empty($params)){
            $params = 1;
        }
        $bd = new Bd();
        $consulta = "with recursive arbol as (select * from ubicaciones where id = $raiz union all select child.* from ubicaciones as child join arbol as parent on parent.id = child.id_padre) select * from arbol where $params";
        $r = $bd->ejecutar($consulta)->fetchAll();
        $t = null;
        foreach ($r as $v) {
            $t[count($t)] = Ubicacion::fromArray($v);
        }
        return $t;
    }
    
}