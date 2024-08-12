<?php

namespace App\Services;

abstract class BaseService {

    public function __construct() {
    }

    abstract public function getData($id = null, $filters = null);

    abstract public function create($data);

    abstract public function update($id, $data);

    abstract public function changeStatus($id, $data);

    abstract public function validarExistencia($data);
}