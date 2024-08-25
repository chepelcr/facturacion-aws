<?php

namespace App\Core\Aws;

use Aws\CognitoIdentityProvider\CognitoIdentityProviderClient;
use Aws\CognitoIdentityProvider\Exception\CognitoIdentityProviderException;

/**
 * Clase que se encarga de manejar la autenticacion de los usuarios.
 * Crear nuevos usuarios.
 * Validar la existencia de un usuario mediante correo y contraseña.
 * Actualizar la contraseña de un usuario.
 * @package App\Core\Aws
 * @version 1.0
 * @since 2024-08-23
 * @author JCampos
 */
class AwsCognito {

    /**
     * Cliente de cognito
     * 
     * @var CognitoIdentityProviderClient
     */
    private $cognitoClient;

    /**
     * Resultado de autenticacion
     */
    private $authResult;

    /**
     * Class constructor
     */
    public function __construct() {
        $this->initialize();
    }

    /**
     * Class destructor (do cleanup)
     */
    public function __destruct() {
        unset($this->cognitoClient);
        unset($this->authResult);
    }

    /**
     * Initialize the Cognito Identity Provider Client
     */
    private function initialize() {
        $this->cognitoClient = new CognitoIdentityProviderClient([
            'region' => getEnt('app.aws.region'),
            'version' => 'latest',
        ]);
    }

    /**
     * Calls the authenticate() method to set the $authResult array.  Will return the AccessToken value if found
     * otherwise false.
     *
     * @param $username
     * @param $password
     * @return false|mixed
     */
    public function login($username, $password) {
        $this->authenticate($username, $password);
        if (is_array($this->authResult)) {
            return $this->authResult['AccessToken'];
        }
        return false;
    }

    /**
     * Allows you to access any value from the authResult array, if set.  Returns false if the value is not found.
     *
     * Valid keys: AccessToken, ExpiresIn, TokenType, RefreshToken, IdToken
     *
     * @param $key
     * @return false|mixed
     */
    public function getResultKey($key) {
        if (array_key_exists($key, $this->authResult)) {
            return $this->authResult[$key];
        }
        return false;
    }

    /**
     * Function that makes the authentication call to the Cognito User Pool and gets back the result.  It then sets it
     * as a private class variable.
     *
     * @param $username
     * @param $password
     */
    private function authenticate($username, $password) {
        if (isset($this->cognitoClient)) {
            $auth_result = $this->cognitoClient->adminInitiateAuth([
                'AuthFlow' => 'ADMIN_USER_PASSWORD_AUTH',
                'ClientId' => $_ENV['COGNITO_APP_CLIENT_ID'],
                'UserPoolId' => $_ENV['COGNITO_USER_POOL_ID'],
                'AuthParameters' => [
                    'USERNAME' => $username,
                    'PASSWORD' => $password,
                ]
            ]);

            if ($auth_result->get('AuthenticationResult')) {
                $this->authResult = $auth_result->get('AuthenticationResult');
            }
        }
    }

    /**
     * Function that allows you to change the password of a user in the Cognito User Pool.
     * @param $username
     * @param $password
     * @param $newPassword
     * @return bool
     * @throws \Aws\CognitoIdentityProvider\Exception\CognitoIdentityProviderException
     * @throws \Aws\Exception\AwsException
     * @throws \Exception
     */
    public function changePassword($username, $password, $newPassword) {
        if (isset($this->cognitoClient)) {
            return $this->cognitoClient->changePassword([
                'PreviousPassword' => $password,
                'ProposedPassword' => $newPassword,
                'AccessToken' => $username
            ]);
        }
        return false;
    }

    /**
     * Confirmar la creacion de una cuenta de usuario con un codigo de confirmacion.
     * @param string $username Nombre de usuario
     * @param string $code Codigo de confirmacion
     * @return array 
     */
    public function confirmSignUp($username, $code) {
        try {
            return $this->cognitoClient->confirmSignUp([
                'ClientId' => getEnt('app.aws.client_id'),
                'Username' => $username,
                'ConfirmationCode' => $code
            ]);
        } catch (CognitoIdentityProviderException $e) {
            return array(
                'error' => true,
                'message' => $e->getMessage()
            );
        }
        return array(
            'error' => true,
            'message' => 'Error desconocido'
        );
        // return 'Error desconocido';
    } //Fin de confirmSignUp

    /**
     * Crea una cuenta de usuario en cognito
     *
     * @param string $username Nombre de usuario
     * @param string $password Contraseña del usuario
     * @param array $data Datos del usuario
     *
     * @return array
     */
    public function signUp($username, $password, $data) {
        try {
            return $this->cognitoClient->signUp([
                'ClientId' => getEnt('app.aws.client_id'),
                'Username' => $username,
                'Password' => $password,
                'UserAttributes' => [
                    [
                        'Name' => 'email',
                        'Value' => $data['correo']
                    ],
                    [
                        'Name' => 'phone_number',
                        'Value' => $data['telefono']
                    ],
                    [
                        'Name' => 'custom:identificacion',
                        'Value' => $data['identificacion']
                    ],
                    [
                        'Name' => 'custom:id_tipo_identificacion',
                        'Value' => $data['id_tipo_identificacion']
                    ],
                    [
                        'Name' => 'custom:nombre',
                        'Value' => $data['nombre']
                    ],
                    [
                        'Name' => 'custom:cod_pais',
                        'Value' => $data['cod_pais']
                    ],
                    [
                        'Name' => 'custom:nombre_usuario',
                        'Value' => $data['nombre_usuario']
                    ],
                    [
                        'Name' => 'custom:id_rol',
                        'Value' => $data['id_rol']
                    ],
                    [
                        'Name' => 'custom:id_empresa',
                        'Value' => $data['id_empresa']
                    ],
                    [
                        'Name' => 'custom:id_sucursal',
                        'Value' => $data['id_sucursal']
                    ],
                    [
                        'Name' => 'custom:id_termimal',
                        'Value' => $data['id_termimal']
                    ],
                    [
                        'Name' => 'custom:status',
                        'Value' => 1
                    ]
                ],
                'ValidationData' => [['Name' => 'email', 'Value' => $data['correo']]]
            ]);
        } catch (CognitoIdentityProviderException $e) {
            return array(
                'error' => true,
                'message' => $e->getMessage()
            );
        }
        return array(
            'error' => true,
            'message' => 'Error desconocido'
        );
    }

    /**
     * Obtener toda la lista de usuarios del Pool de usuarios
     * @return array
     */
    public function getUsers() {
        try {
            return $this->cognitoClient->listUsers([
                'UserPoolId' => getEnt('app.aws.user_pool_id')
            ]);
        } catch (CognitoIdentityProviderException $e) {
            return array(
                'error' => true,
                'message' => $e->getMessage()
            );
        }
    } //Fin de getUsers

    /**
     * Obtener la informacion de un usuario en cognito
     * @param string $username Nombre de usuario
     * @return array
     */
    public function getUser($username) {
        try {
            return $this->cognitoClient->adminGetUser([
                'Username' => $username,
                'UserPoolId' => getEnt('app.aws.user_pool_id')
            ]);
        } catch (CognitoIdentityProviderException $e) {
            return array(
                'error' => true,
                'message' => $e->getMessage()
            );
        }
    } //Fin de getUser

    /**
     * Actualizar la informacion de un usuario en cognito
     * @param $data Información del usuario
     * @param $username Nombre de usuario
     * @return array
     */
    public function updateUser($data, $username) {
        try {
            return $this->cognitoClient->adminUpdateUserAttributes([
                'UserAttributes' => [
                    [
                        'Name' => 'email',
                        'Value' => $data['correo']
                    ],
                    [
                        'Name' => 'phone_number',
                        'Value' => $data['telefono']
                    ],
                    [
                        'Name' => 'custom:identificacion',
                        'Value' => $data['identificacion']
                    ],
                    [
                        'Name' => 'custom:id_tipo_identificacion',
                        'Value' => $data['id_tipo_identificacion']
                    ],
                    [
                        'Name' => 'custom:nombre',
                        'Value' => $data['nombre']
                    ],
                    [
                        'Name' => 'custom:cod_pais',
                        'Value' => $data['cod_pais']
                    ],
                    [
                        'Name' => 'custom:nombre_usuario',
                        'Value' => $data['nombre_usuario']
                    ],
                    [
                        'Name' => 'custom:id_rol',
                        'Value' => $data['id_rol']
                    ],
                    [
                        'Name' => 'custom:id_empresa',
                        'Value' => $data['id_empresa']
                    ],
                    [
                        'Name' => 'custom:id_sucursal',
                        'Value' => $data['id_sucursal']
                    ],
                    [
                        'Name' => 'custom:id_termimal',
                        'Value' => $data['id_termimal']
                    ]
                    // ,
                    // [
                    //     'Name' => 'custom:status',
                    //     'Value' => 1
                    // ]
                ],
                'Username' => $username,
                'UserPoolId' => getEnt('app.aws.user_pool_id')
            ]);
        } catch (CognitoIdentityProviderException $e) {
            return array(
                'error' => true,
                'message' => $e->getMessage()
            );
        }
        return array(
            'error' => true,
            'message' => 'Error desconocido'
        );
        // return 'Error desconocido';
    } //Fin de updateUser

    /**
     * Eliminar un usuario en cognito
     * @param string $username Nombre de usuario
     * @return array
     */
    public function deleteUser($username) {
        try {
            return $this->cognitoClient->adminDeleteUser([
                'Username' => $username,
                'UserPoolId' => getEnt('app.aws.user_pool_id')
            ]);
        } catch (CognitoIdentityProviderException $e) {
            return array(
                'error' => true,
                'message' => $e->getMessage()
            );
        }
        return array(
            'error' => true,
            'message' => 'Error desconocido'
        );
    } //Fin de deleteUser

    /**
     * Actualizar el status de un usuario en cognito
     * @param string $username Nombre de usuario
     * @param array $data Datos del usuario
     * @return array
     */
    public function updatestatus($username, $data) {
        try {
            $status = $data['status'];

            return $this->cognitoClient->adminUpdateUserAttributes([
                'UserAttributes' => [
                    [
                        'Name' => 'custom:status',
                        'Value' => $status
                    ]
                ],
                'Username' => $username,
                'UserPoolId' => getEnt('app.aws.user_pool_id')
            ]);
        } catch (CognitoIdentityProviderException $e) {
            return array(
                'error' => true,
                'message' => $e->getMessage()
            );
        }
        return array(
            'error' => true,
            'message' => 'Error desconocido'
        );
    } //Fin de updatestatus
}