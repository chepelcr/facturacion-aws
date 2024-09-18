<?php

namespace App\Controllers;

use App\Services\DataService;

class Data extends BaseController {
    private $dataService;

    public function __construct() {
        parent::__construct();

        $this->dataService = new DataService();
    }

    /**
     * Obtener los códigos CABYS por nombre o código
     */
    public function codigos_cabys() {
        $search = get('search');

        $data = $this->dataService->getCabysByCodeOrName($search);

        if (!isset($data->error)) {
            return json_encode($data);
        } else {
            return $this->error($data);
        }
    }
}
