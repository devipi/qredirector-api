<?php

final class Codigo {
    public $id = null;
    public $url_code = null;
    public $activo = null;
    public $hits = null;
    public $file = null;
    public $id_ubicacion = 0;
    public $ubicacion = null;
    
    public function __construct(string $id = null, string $url_code = null, bool $activo = false, int $hits = 0, string $file = null, int $id_ubicacion = 0, string $ubicacion = null) {
        $this->id = $id;
        $this->url_code = $url_code;
        if($activo != null){
            $this->activo = $activo;
        }
        $this->hits = $hits;
        $this->file = $file;
        $this->id_ubicacion = $id_ubicacion;
        $this->ubicacion = $ubicacion;
    }

    public static function fromArray(array $data): Codigo {
        return new Codigo($data['id'], $data['url_code'], $data['activo'], $data['file'], $data['hits'], $data['id_ubicacion'], $data['ubicacion']);
    }
}