<?php

namespace App\Controllers;

use App\Models\EmpresasModel;
use App\Models\UsuariosModel;
use App\Services\UsuariosService;

/** 
 * Clase para manejar el modulo de inicio de sesion
 * @package App\Controllers
 * @subpackage Login
 * @version 1.0
 * @autor jcampos
*/
class Login extends BaseController
{
    /** Funcion para mostrar el login */
    public function index()
    {
        if (!is_login()) {
            return view('login');
        } else {
            //Cargar la pagina principal
            return redirect(baseUrl());
        }
    } //Fin de la funcion

    /** Funcion para consultar si el usuario existe en la base de datos */
    public function consultar()
    {
        //Validar si el usuario ha iniciado sesion
        if (!is_login()) {
            $respuesta = array(
                'estado' => 0,
                'error' => 'Usuario o contraseña incorrectos.'
            );

            $user = post('usuario');
            $pswd = post('contrasenia');

            $usuariosModel = new UsuariosModel();
            $usuariosModel->where('correo', $user);

            $usuario = $usuariosModel->fila();

            /*$data = array(
                    'id_usuario'=>$usuario->id_usuario,
                    'nombre_usuario'=>$usuario->nombre_usuario,
                    'id_rol'=>$usuario->id_rol,
                    'correo'=>$usuario->correo,
                    'identificacion'=>$usuario->identificacion,
                    'nombre'=>$usuario->nombre,
                );

                $empresa = (object) getEmpresa();

                $data['id_empresa'] = $empresa->taxpayerId;
                $data['empresa'] = json_encode($empresa);
                $data['nombre_pagina'] = getEnt('app.name');
                
                setDataSession($data);

                $respuesta = array(
                    'estado' => '1',);*/

            if ($usuario && $usuario->estado != 0) {
                //Obtener el estado de la contraseña del usuario
                $estado_contrasenia = validar_contrasenia($usuario->id_usuario, $pswd);

                //Validar si la contrasenia es correcta
                switch ($estado_contrasenia) {
                    case '1':
                        $data = array(
                            'id_usuario' => $usuario->id_usuario,
                            'nombre_usuario' => $usuario->nombre_usuario,
                            'id_rol' => $usuario->id_rol,
                            'correo' => $usuario->correo,
                            'identificacion' => $usuario->identificacion,
                            'nombre' => $usuario->nombre,
                        );

                        $empresa = (object) getEmpresa();

                        $data['id_empresa'] = $empresa->taxpayerId;
                        $data['empresa'] = json_encode($empresa);
                        $data['nombre_pagina'] = getEnt('app.name');

                        setDataSession($data);

                        $respuesta = array(
                            'estado' => '1',
                        );
                        break;

                    case '2':
                        $data = array(
                            'id_usuario' => $usuario->id_usuario,
                            'nombre_usuario' => $usuario->nombre_usuario,
                            'id_rol' => $usuario->id_rol,
                            'correo' => $usuario->correo,
                            'identificacion' => $usuario->identificacion,
                            'nombre' => $usuario->nombre,
                            'contrasenia_expiro' => true,
                        );

                        $empresa = (object) getEmpresa();

                        $data['id_empresa'] = $empresa->taxpayerId;
                        $data['nombre_pagina'] = getEnt('app.name');

                        setDataSession($data);

                        $respuesta = array(
                            'estado' => '2',
                            'error' => 'La contraseña ha expirado, debe cambiarla para continuar.'
                        );
                        break;

                    case '3':
                        $respuesta = array(
                            'estado' => '3',
                            'error' => 'Debe esperar un momento para volver a intentar.'
                        );
                        break;
                } //Fin del switch
            } //Fin del if

            return json_encode($respuesta);
        } //Fin de la validacion

        else
            return json_encode(array(
                'estado' => '1',
            ));
    } //Fin de la funcion para consultar un usuario

    /**Salir de la aplicacion */
    public function salir()
    {
        destroy();

        return json_encode(array(
            'estado' => '1',
        ));
    } //Fin de la funcion para salir de la aplicacion

    public function olvido()
    {
        if (!is_login())
            return view('seguridad/login/olvido');

        else
            //Cargar la pagina principal
            return redirect(baseUrl());
    } //Fin de la funcion

    /**Recuperar la contrasenia de un usuario */
    public function recuperar()
    {
        if (!is_login()) {
            if (post('correo')) {
                $correo = post('correo');

                $usuarioService = new UsuariosService();
                $data = $usuarioService->enviarContraseniaTemporalPorCorreo($correo);
            } else {
                $data = (
                    array(
                        'error' => 'No se ha ingresado el correo.',
                        'status' => '400'
                    )
                );
            }
        } else {
            $data = array(
                'error' => 'Ya ha iniciado sesión.',
                'status' => '400'
            );
        }

        if (isset($data['error'])) {
            return $this->error($data);
        } else {
            return json_encode($data);
        }
    } //Fin del metodo para recuperar la contrasenia
} //Fin del controlador de login
