<?php

/**
 * Controlador para la entidad cliente
 */

namespace App\Controllers;

use App\Services\ClientesService;
use App\Services\ProductosService;


class Empresa extends BaseController
{
	protected $isModulo = true;

	protected $nombreModulo = 'empresa';

	protected $objetos = ['productos', 'clientes'];

	protected $validationFields = array(
		'productos' => [
			'codeType',
			'description',
			'codeNumber',
		],
		#'sucursales' => null,
		'clientes' => [
			'nationality',
			'idNumber'
		]
	);

	protected $loginValidation = array(
		'productos' => true,
		'sucursales' => true,
		'clientes' => true
	);

	public function index()
	{
		if (is_login()) {
			$script = cargar('cargar_inicio_modulo("empresa", "Administracion");');

			$data = array(
				'script' => $script,
			);

			return $this->inicio($data);
		} else {
			redirect(baseUrl('login'));
		}
	} //Fin de la función index

	public function clientes()
	{
		if (is_login()) {
			if (validar_permiso('empresa', 'clientes', 'consultar')) {
				if (getSegment(3) == 'listado') {
					$clientesService = new ClientesService();

					$clientesView = $clientesService->getCustomersListView($_GET);

					if (isset($clientesView->error)) {
						$data = array(
							'error' => $clientesView->error,
							'codigo' => $clientesView->status
						);

						return $this->error($data);
					} else {
						return $clientesView;
					}
				} else {
					$data = array(
						'script' => cargar('cargar_listado("empresa", "clientes", "Administracion", "Clientes", "' . baseUrl('empresa/clientes/listado') . '");')
					);

					return $this->inicio($data);
				}
			} else {
				$error = $this->object_error(500, 'No tiene permisos para consultar clientes.');

				return $this->error($error);
			}
		} else {
			redirect(baseUrl('login'));
		}
	} //Fin de la función para mostrar el listado de clientes

	public function productos()
	{
		if (is_login()) {
			if (validar_permiso('empresa', 'productos', 'consultar')) {
				if (getSegment(3) == 'listado') {
					$productosService = new ProductosService();

					$productosView = $productosService->getProductsListView($_GET);

					if (isset($productosView->error)) {
						return $this->error($productosView);
					} else {
						return $productosView;
					}
				} else {
					$script = cargar('cargar_listado("empresa", "productos", "Administracion", "Productos y servicios" ,"' . baseUrl('empresa/productos/listado') . '");');

					$data = array(
						'script' => $script
					);

					return $this->inicio($data);
				}
			} else {
				$error = $this->object_error(403, 'No tiene permiso para realizar esta acción');

				return  $this->error($error);
			}
		} else {
			redirect(baseUrl('login'));
		}
	} //Fin de la función para mostrar el listado de productos

	public function ordenes()
	{
		if (is_login()) {
			if (getSegment(3) == 'listado') {
				$nombreVista = 'empresa/ordenes/listado';

				$data = array(
					'nombreVista' => $nombreVista,
				);

				return view($nombreVista, $data);
			} else {
				$data = array(
					'script' => cargar('cargar_listado("empresa", "ordenes", "Administración" , "Ordenes de compra" ,"' . baseUrl('empresa/ordenes/listado') . '");')
				);

				return $this->inicio($data);
			}
		} else {
			redirect(baseUrl('login'));
		}
	} //Fin de la función para mostrar el listado de productos

	public function update($id, $data)
	{
		if (is_login()) {
			$objeto = $this->modelName;

			if (in_array($objeto, $this->objetos)) {
				if (validar_permiso('empresa', $objeto, 'modificar')) {
					if ($objeto == 'productos') {
						$productosService = new ProductosService();

						$result = $productosService->update($id, $data);
						$objeto = 'producto';
					} elseif ($objeto == 'clientes') {
						$clientesService = new ClientesService();

						$result = $clientesService->update($id, $data);
						$objeto = 'cliente';
					}

					if (!isset($result->error)) {
						$result = array(
							'success' => "Se ha actualizado el $objeto correctamente",
							'data' => $result,
						);

						return json_encode($result);
					} else {
						$result = array(
							'error' => "Se ha generado un error al actualizar el $objeto",
							'codigo' => $result->status,
							'data' => $result->error,
						);

						return $this->error($result);
					}
				} else {
					$result = array(
						'error' => 'No tiene permisos para realizar esta acción',
						'codigo' => 403
					);

					return $this->error($result);
				}
			} else {
				$result = array(
					'error' => 'A ocurrido un error al actualizar el objeto',
					'codigo' => 500
				);

				return $this->error($result);
			}
		} else {
			redirect(baseUrl('login'));
		}
	} //Fin de la función para actualizar un producto

	/**Guardar un cliente en la base de datos */
	public function guardar($data = null)
	{
		if (is_login()) {
			$objeto = $this->modelName;

			if (validar_permiso('empresa', $objeto, 'insertar')) {
				if (!is_null($objeto) && in_array($objeto, $this->objetos)) {
					if ($objeto == 'productos') {
						$productosService = new ProductosService();

						$result = $productosService->create($data);
						$objeto = 'producto';
					} elseif ($objeto == 'clientes') {
						$clientesService = new ClientesService();

						$result = $clientesService->create($data);
						$objeto = 'cliente';
					}

					// Si el resultato no contiene error
					if (!isset($result->error)) {
						$result = array(
							'success' => "Se ha guardado el $objeto correctamente",
							'data' => $result,
						);

						return json_encode($result);
					} else {
						$result = array(
							'error' => "Se ha generado un error al guardar el $objeto",
							'codigo' => $result->status
						);

						return $this->error($result);
					}
				} else {
					$result = array(
						'error' => 'A ocurrido un error al guardar el objeto',
						'codigo' => 500
					);

					return $this->error($result);
				}
			} else {
				$result = array(
					'error' => 'No tiene permisos para realizar esta acción',
					'codigo' => 403
				);

				return $this->error($result);
			}
		} else {
			redirect(baseUrl('login'));
		}
	} //Fin de la función para guardar un objeto
}//Fin de la clase
