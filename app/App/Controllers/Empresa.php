<?php

/**
 * Controlador para la entidad cliente
 */

namespace App\Controllers;

use App\Models\CategoriasModel;
use App\Models\ClientesModel;
use App\Models\CodigosPaisesModel;
use App\Models\ProductosModel;
use App\Models\TipoIdentificacionModel;
use App\Models\UbicacionesModel;
use App\Models\UnidadesMedidaModel;

class Empresa extends BaseController
{
	protected $isModulo = true;

	protected $nombre_modulo = 'empresa';

	protected $objetos = ['productos', 'clientes'];

	protected $campos_validacion = array(
		'productos' => 'codigo_venta',
		'sucursales' => null,
		'clientes' => 'identificacion'
	);

	protected $validacion_login = array(
		'productos' => true,
		'sucursales' => true,
		'clientes' => true
	);

	public function index()
	{
		if (is_login()) {
			$script = cargar('cargar_inicio_modulo("empresa");');

			$data = array(
				'script' => $script,
			);

			return $this->inicio($data);
		} //Fin de la validacion

		else {
			header('Location: ' . baseUrl('login'));
		}
	} //Fin de la funcion index

	/**Retornar la informacion de la empresa */
	public function informacion()
	{
		if (is_login()) {
			$script = cargar('cargar_listado("empresa", "informacion", "' . baseUrl("empresa/empresas") . '");');

			$data = array(
				'script' => $script
			);

			return $this->inicio($data);
		} else {
			header('Location: ' . baseUrl('login'));
		}
	} //Fin de la función index

	public function clientes()
	{
		if (is_login()) {
			if (!validar_permiso('empresa', 'clientes', 'consultar')) {
				$error = $this->object_error(500, 'No tiene permisos para consultar clientes.');

				return $this->error($error);
			}

			switch (getSegment(3)) {
				case 'listado':
					$clientesModel = new ClientesModel();

					$estado = 'all';

					if (post('id_estado') == 'inactivos') {
						$estado = 'inactivos';
						$clientes = $clientesModel->obtener('inactivos');
					} else {
						if (post('id_estado') == 'activos') {
							$estado = 'activos';
							$clientes = $clientesModel->obtener('activos');
						} else {
							$clientes = $clientesModel->obtener('all');
							$estado = 'all';
						}
					}

					$nombreTabla = 'empresa/cliente/table';

					$data_tabla = array(
						'nombreTable' => $nombreTabla,
						'nombre_tabla' => 'listado_empresa_clientes',

						'dataTable' => array(
							'clientes' => $clientes,
						),
						'id_estado' => $estado,
					);

					$ubicacionesModel = new UbicacionesModel();
					$provincias = $ubicacionesModel->provincias();

					$tiposIdentificacionMoodel = new TipoIdentificacionModel();
					$identificaciones = $tiposIdentificacionMoodel->getAll();

					$codigosPaisesModel = new CodigosPaisesModel();
					$codigos = $codigosPaisesModel->getAll();

					$dataProvincias = array(
						'provincias' => $provincias
					);

					$datos_personales = array(
						'identificaciones' => $identificaciones,
						'codigos' => $codigos
					);

					$nombreForm = 'empresa/cliente/form';

					$data_form = array(
						'dataForm' => array(
							'dataProvincias' => $dataProvincias,
							'datos_personales' => $datos_personales,
						),
						'nombreForm' => $nombreForm,
						'nombre_form' => 'frm_empresa_clientes'
					);

					$data = array(
						'data_tabla' => $data_tabla,
						'data_form' => $data_form,
					);

					return $this->listado($data);
					break;

				default:
					$data = array(
						'script' => cargar('cargar_listado("empresa", "clientes", "' . baseUrl('empresa/clientes/listado') . '");')
					);

					return $this->inicio($data);
					break;
			}
		} //Fin de la validacion

		else
			header('Location: ' . baseUrl('login'));
	} //Fin de la funcion para mostrar el listado de clientes

	public function productos() {
		if (is_login()) {
			if (validar_permiso('empresa', 'productos', 'consultar')) {
				switch (getSegment(3)) {
					case 'listado':
						$articulosModel = new ProductosModel();

						//var_dump(post('id_estado'));

						$estado = 'all';

						if (post('id_estado') == 'inactivos') {
							$articulos = $articulosModel->obtener(post('id_estado'));
							$estado = 'inactivos';
						} else {
							if (post('id_estado') == 'activos') {
								$estado = 'activos';
								$articulos = $articulosModel->obtener('activos');
							} else {
								$articulos = $articulosModel->obtener('all');
							}
						}

						$nombreTabla = 'empresa/producto/table';

						$data_tabla = array(
							'nombreTable' => $nombreTabla,
							'nombre_tabla' => 'listado_empresa_productos',

							'dataTable' => array(
								'articulos' => $articulos,
							),
							'id_estado' => $estado
						);

						$categoriasModel = new CategoriasModel();
						$categorias = $categoriasModel->getAll();

						$unidadesMedidaModel = new UnidadesMedidaModel();
						$unidades = $unidadesMedidaModel->getAll();

						$nombreForm = 'empresa/producto/form';

						$data_form = array(
							'dataForm' => array(
								'categorias' => $categorias,
								'unidades' => $unidades,
							),
							'nombreForm' => $nombreForm,
							'nombre_form' => 'frm_empresa_productos'
						);

						$data = array(
							'data_tabla' => $data_tabla,
							'data_form' => $data_form,
							'extra_views' => array(
								'empresa/producto/elementos/cabys' => null
							),
						);

						return $this->listado($data);
						break;

					default:
						$script = cargar('cargar_listado("empresa", "productos", "' . baseUrl('empresa/productos/listado') . '");');

						$data = array(
							'script' => $script
						);

						return $this->inicio($data);
						break;
				}
			} else {
				$error = $this->object_error(403, 'No tiene permiso para realizar esta acción');

				return  $this->error($error);
			}
		} //Fin de la validacion

		else
			header('Location: ' . baseUrl('login'));
	} //Fin de la funcion para mostrar el listado de productos

	public function ordenes()
	{
		if (is_login()) {
			$nombreVista = 'empresa/ordenes/listado';

			$data = array(
				'nombreVista' => $nombreVista,
			);

			if (getSegment(3) == 'listado') {
				return view($nombreVista, $data);
			} else {
				$data = array(
					'script' => cargar('cargar_listado("empresa", "ordenes", "' . baseUrl('empresa/ordenes/listado') . '");')
				);

				return $this->inicio($data);
			}
		} //Fin de la validacion

		else
			header('Location: ' . baseUrl('login'));
	} //Fin de la funcion para mostrar el listado de productos

	public function update($id, $objeto = null)
	{
		if (!is_null($objeto) && in_array($objeto, $this->objetos)) {
			if (is_login()) {
				$model = model($objeto);

				switch ($objeto) {
					case 'productos':
						$valor_unitario = post('valor_unitario');
						$impuesto = post('impuesto');

						$valor_impuesto = $valor_unitario * $impuesto / 100;
						$valor_total = $valor_unitario + $valor_impuesto;

						//Colocar con dos decimales
						$valor_unitario = number_format($valor_unitario, 2, '.', '');
						$valor_impuesto = number_format($valor_impuesto, 2, '.', '');

						$data = array(
							'descripcion' => post('descripcion'),
							'id_unidad' => post('id_unidad'),
							'unidad_empaque' => post('unidad_empaque'),
							'codigo_cabys' => post('codigo_cabys'),
							'impuesto' => post('impuesto'),
							'id_categoria' => post('id_categoria'),
							'valor_unitario' => post('valor_unitario'),
							'valor_impuesto' => $valor_impuesto,
							'valor_total' => $valor_total,
						);

						if ($model->update($data, $id))
							return json_encode(array('success' => 'Se ha actualizado el producto'));
						break;

					case 'clientes':
						$data = array(
							'nombre_comercial' => post('nombre_comercial'),
							'correo' => post('correo'),
							'id_ubicacion' => post('id_ubicacion'),
							'otras_senas' => post('otras_senas'),
							'telefono' => post('telefono'),
						);

						if ($model->update($data, $id))
							return json_encode(array('success' => 'Se ha actualizado el cliente'));
						break;
				}

				return json_encode(array(
					'error' => 'Se ha generado un error'
				));
			} //Fin de la vaalidacion de permisos

			return json_encode(array(
				'error' => 'No ha iniciado sesión'
			));
		} //Fin de la validacion de objeto

		else
			return json_encode(array(
				'error' => 'Ha ocurrido un error'
			));
	} //Fin de la funcion para actualizar un producto

	/**Guardar un cliente en la base de datos */
	public function guardar($objeto = null)
	{
		if (!is_login()) {
			return json_encode(array(
				'error' => 'No ha iniciado sesion',
			));
		}

		if (validar_permiso('empresa', $objeto, 'insertar')) {
			if (!is_null($objeto) && in_array($objeto, $this->objetos)) {
				switch ($objeto) {
					case 'productos':
						$valor_unitario = post('valor_unitario');
						$impuesto = post('impuesto');

						$valor_impuesto = $valor_unitario * $impuesto / 100;
						$valor_total = $valor_unitario + $valor_impuesto;

						//Colocar con dos decimales
						$valor_unitario = number_format($valor_unitario, 2, '.', '');
						$valor_impuesto = number_format($valor_impuesto, 2, '.', '');
						$data = array(
							'descripcion' => post('descripcion'),
							'id_unidad' => post('id_unidad'),
							'id_empresa' => getSession('id_empresa'),
							'unidad_empaque' => post('unidad_empaque'),
							'id_categoria' => post('id_categoria'),
							'codigo_venta' => post('codigo_venta'),
							'codigo_interno' => post('codigo_interno'),
							'codigo_cabys' => post('codigo_cabys'),
							'impuesto' => post('impuesto'),
							'valor_unitario' => post('valor_unitario'),
							'valor_impuesto' => $valor_impuesto,
							'valor_total' => $valor_total,
							'estado' => 1
						);

						$model = model('productos');

						$id = $model->insert($data);

						if ($id) {
							return json_encode(array(
								'success' => 'Se ha guardado el producto correctamente',
								'id' => $id
							));
						} else
							return json_encode(array(
								'error' => 'Se ha generado un error al guardar el producto'
							));
						break;

					case 'clientes':
						$identificacion = post('identificacion');

						//Eliminar los guiónes del número de identificación
						$identificacion = desformatear_cedula($identificacion);

						$data = array(
							'identificacion' => $identificacion,
							'id_tipo_identificacion' => post('id_tipo_identificacion'),
							'razon' => post('nombre'),
							'nombre_comercial' => post('nombre_comercial'),
							'correo' => post('correo'),
							'id_ubicacion' => post('id_ubicacion'),
							'otras_senas' => post('otras_senas'),
							'telefono' => post('telefono'),
							'cod_pais' => post('cod_pais'),
							'id_empresa' => getSession('id_empresa'),
							'estado' => 1
						);

						//var_dump($data);

						$model = model('clientes');

						$id = $model->insert($data);

						if ($id) {
							return json_encode(array(
								'success' => 'Se ha guardado el cliente correctamente',
								'id' => $id
							));
						} else
							return json_encode(array(
								'error' => 'Se ha generado un error al guardar el cliente'
							));
						break;
				}
			} //Fin de la validacion de objeto

			else
				return json_encode(array(
					'error' => 'Ha ocurrido un error'
				));

			return json_encode(array(
				'error' => 'No tiene permisos para realizar esta acción'
			));
		} //Fin de la vaalidacion de permisos
	} //Fin de la funcion para guardar un objeto

	public function empresas()
	{
		if (is_login()) {
			$empresa = getEmpresa();

			return view('empresa/cliente/form', $empresa);
		}
	}
}//Fin de la clase
