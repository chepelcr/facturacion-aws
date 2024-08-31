<?php

namespace App\Models;

use Core\Model;

class DocumentoModel extends Model
{
    protected $tableName = 'documentos';

    protected $primaryKey = 'id_documento';

    protected $tableFields = [
        'consecutivo',
        'tipo_documento',
        'clave',
        'codigo_seguridad',
        'fecha',
        'emisor_cedula',
        'emisor_nombre',
        'emisor_tipo',
        'emisor_comercial',
        'emisor_id_provincia',
        'emisor_id_canton',
        'emisor_id_distrito',
        'emisor_id_barrio',
        'emisor_otras_senas',
        'emisor_cod',
        'emisor_telefono',
        'emisor_correo',
        'receptor_nombre',
        'receptor_cedula',
        'receptor_tipo',
        'receptor_comercial',
        'receptor_id_provincia',
        'receptor_id_canton',
        'receptor_id_distrito',
        'receptor_id_barrio',
        'receptor_otras_senas',
        'receptor_cod',
        'receptor_telefono',
        'receptor_correo',
        'condicion_venta',
        'plazo_credito',
        'medio_pago',
        'moneda',
        'tipo_cambio',
        'servicios_gravados',
        'servicios_exentos',
        'servicios_exonerados',
        'mercancias_gravadas',
        'mercancias_exentas',
        'mercancias_exoneradas',
        'total_gravado',
        'total_exento',
        'total_exonerado',
        'total_venta',
        'total_descuentos',
        'total_venta_neta',
        'total_impuestos',
        'total_comprobante',
        'notas',
        'envio_atv',
        'valido_atv',
        'detalle_atv',
        'fecha_envio',
        'fecha_valido',
        'correo_enviado',
        'fecha_correo',
        'id_empresa',
        //'id_sucursal',
        //'id_caja',
        'id_usuario',
    ];

    protected $autoIncrement = true;

    protected $auditorias = true;

    protected $tipos_documentos = 'emitidos';

    public function obtener($id)
    {
        $documento = false;

        switch ($id) {
            case 'all':
                return $this->getAll();
                break;

            case 'diarios':
                return $this->diarios();

            case 'semanal':
                return $this->semanal();

            case 'semana_anterior':
                return $this->semana_anterior();
                break;

            case 'semana':
                return $this->semana();
                break;

            case 'mes':
                return $this->mes();
                break;

            case 'mes_anterior':
                return $this->mes_anterior();
                break;

            case 'proceso':
                return $this->proceso();
                break;

            case 'emitidos':
                return $this->diarios();
                break;

            case 'recibidos':
                return $this->recibidos();
                break;

            default:
                $documento = $this->getById($id);

                if ($documento) {
                    $detalles_model = model('documentoDetalles');
                    $documento->detalles = (object) $detalles_model->obtener($id);

                    $referencias_model = model('documentoReferencias');
                    $documento->referencias = (object) $referencias_model->where('id_documento', $id)->obtener('all');

                    $otros_model = model('documentoOtros');
                    $documento->otros = (object) $otros_model->where('id_documento', $id)->obtener('all');

                    return $documento;
                }

                break;
        }

        return $documento;
    } //Fin de la funcion para obtener documentos electronicos

    /**Obtener los documentos recibidos */
    public function recibidos()
    {
        return array();
    }

    /**Obtener documentos emitidos o recibidos */
    public function documentos($tipos_documentos = 'emitidos')
    {
        switch ($tipos_documentos) {
            case 'emitidos':
                $this->where('emisor_cedula', getSession('empresa_identificacion'));
                break;

            default:
                $this->where('receptor_cedula', getSession('empresa_identificacion'));
                break;
        }

        return $this;
    } //Fin de la funcion para obtener documentos electronicos

    /**Establecer la empresa para obtener los documentos */
    public function empresa($id_empresa, $id_sucursal = null, $id_caja = null)
    {
        $this->where('id_empresa', $id_empresa);

        if ($id_sucursal != null) {
            $this->where('id_sucursal', $id_sucursal);
        }

        if ($id_caja != null) {
            $this->where('id_caja', $id_caja);
        }

        return $this;
    }

    /**Obtener un documento mediante clave */
    public function clave($clave)
    {
        $this->where('clave', $clave);

        return $this->fila();
    }

    /**Indicar el tipo de documento a buscar */
    public function tipo_documento($tipo_documento)
    {
        if ($tipo_documento != 'all' && $tipo_documento) {
            $this->where('tipo_documento', $tipo_documento);
        }

        return $this;
    }

    /**Buscar un documento en un rango de fechas */
    public function busqueda($startDate, $endDate)
    {
        $documentos = $this->getAll();
    }

    /**Obtener los documentos del dia */
    private function diarios()
    {
        $this->vista('documentos_diarios');
        return $this->getAll();
    }

    /**Obtener los documentos de los ultimos 7 dias */
    private function semanal()
    {
        $this->vista('documentos_semanal');
        return $this->getAll();
    }

    /**Obtener los documentos de la semana anterior */
    private function semana_anterior()
    {
        $this->vista('documentos_semana_anterior');
        return $this->getAll();
    }

    /**Obtener los documentos que se han obtenido este mes */
    private function mes()
    {
        $this->vista('documentos_mes');
        return $this->getAll();
    }

    /**Obtener los documentos del mes anterior */
    private function mes_anterior()
    {
        $this->vista('documentos_mes_anterior');
        return $this->getAll();
    }

    /**Obtener los documentos de la semana actual */
    private function semana()
    {
        $this->vista('documentos_semana');
        return $this->getAll();
    }

    /**Obtener todos los documentos en proceso */
    private function proceso()
    {
        $this->vista('documentos_proceso');
        return $this->getAll();
    } //Fin de la funcion para obtener los documentos en proceso

}
