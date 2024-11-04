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
        if (is_login()) {
            $search = get('search');
            $productType = get('productType');

            $data = $this->dataService->getCabysByCodeOrName($search, $productType);

            if (!isset($data->error)) {
                return json_encode($data);
            } else {
                return $this->error($data);
            }
        } else {
            return redirect(baseUrl());
        }
    }

    /**
     * Obtener informacion de un contribuyente del Ministerio de Hacienda
     * 
     * @return string Informacion del contribuyente
     */
    public function contribuyentes() {
        if (!is_login()) {
            return redirect(baseUrl());
        } else {
            $nationality = get('nationality');
            $taxpayerId = get('taxpayerId');

            $data = $this->dataService->getTaxpayerByCountryCode($nationality, $taxpayerId);

            if (!isset($data->error)) {
                return json_encode($data);
            } else {
                return $this->error($data);
            }
        }
    }
}
