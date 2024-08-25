<?php

namespace App\Core\Aws;

use Aws\CognitoIdentityProvider\CognitoIdentityProviderClient;
use Aws\CognitoIdentityProvider\Exception\CognitoIdentityProviderException;

/**
 * Clase que se encarga de manejar la autenticacion de los usuarios.
 * 
 * Crear nuevos usuarios.
 * Validar la existencia de un usuario mediante correo y contraseña.
 * Actualizar la contraseña de un usuario.
 * 
 * @package App\Core\Aws
 * @version 1.0
 * @since 2024-08-23
 * @author JCampos
 */
class AwsCognito
{
    /**
     * Cliente de cognito
     * 
     * @var CognitoIdentityProviderClient
     */
    private $client;

    /**
     * Constructor de la clase
     */
    public function __construct()
    {
        $this->client = new CognitoIdentityProviderClient([
            'region' => getEnt('app.aws.region'),
            'version' => 'latest'
        ]);
    } //Fin del constructor

    /**
     * Crear un nuevo usuario en cognito
     * 
     * @param array $data Datos del usuario
     * 
     * @return array
     */
    public function signUp($data, $password)
    {
        try {
            $result = $this->client->signUp([
                'ClientId' => getEnt('app.aws.client_id'),
                'Username' => $data['correo'],
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
                ]
            ]);
        } catch (CognitoIdentityProviderException $e) {
            return array(
                'error' => true,
                'message' => $e->getMessage()
            );
        }
    } //Fin de signUp

    /**
     * Validar la existencia de un usuario en cognito
     * 
     * @param string $username Nombre de usuario
     * @param string $password Contraseña del usuario
     * 
     * @return array información del usuario
     */
    public function signIn($username, $password)
    {
        try {
            $result = $this->client->adminInitiateAuth([
                'AuthFlow' => 'ADMIN_NO_SRP_AUTH',
                'ClientId' => getEnt('app.aws.client_id'),
                'UserPoolId' => getEnt('app.aws.user_pool_id'),
                'AuthParameters' => [
                    'USERNAME' => $username,
                    'PASSWORD' => $password
                ]
            ]);

            return $result->get('AuthenticationResult');
        } catch (CognitoIdentityProviderException $e) {
            return array(
                'error' => true,
                'message' => $e->getMessage()
            );
        }
    } //Fin de signIn

    /**
     * Actualizar la contraseña de un usuario en cognito
     * 
     * @param string $username Nombre de usuario
     * @param string $password Contraseña del usuario
     * @param string $newPassword Nueva contraseña del usuario
     * 
     * @return array
     */
    public function changePassword($username, $password, $newPassword)
    {
        try {
            $result = $this->client->changePassword([
                'PreviousPassword' => $password,
                'ProposedPassword' => $newPassword,
                'AccessToken' => $username
            ]);

            return $result;
        } catch (CognitoIdentityProviderException $e) {
            return array(
                'error' => true,
                'message' => $e->getMessage()
            );
        }
    } //Fin de changePassword

    /**
     * Actualizar los datos de un usuario en cognito
     * 
     * @param string $username Nombre de usuario
     * @param array $data Datos del usuario
     * 
     * @return array
     */
    public function updateUser($username, $data)
    {
        try {
            $result = $this->client->adminUpdateUserAttributes([
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
    } //Fin de updateUser

    /**
     * Obtiene la informacion de un usuario en cognito
     * 
     * @param string $username Nombre de usuario
     * 
     * @return array
     */
    public function getUser($username)
    {
        try {
            $result = $this->client->adminGetUser([
                'Username' => $username,
                'UserPoolId' => getEnt('app.aws.user_pool_id')
            ]);

            return $result;
        } catch (CognitoIdentityProviderException $e) {
            return array(
                'error' => true,
                'message' => $e->getMessage()
            );
        }
    } //Fin de getUser

    /**
     * Obtiene todos los usuarios de cognito
     * 
     * @return array Lista de usuarios
     */
    public function getUsers()
    {
        try {
            $result = $this->client->listUsers([
                'UserPoolId' => getEnt('app.aws.user_pool_id')
            ]);

            return $result;
        } catch (CognitoIdentityProviderException $e) {
            return array(
                'error' => true,
                'message' => $e->getMessage()
            );
        }
    } //Fin de getUsers
}


class Cognito {
    private $cognitoClient;
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
            'region' => $_ENV['AWS_REGION'],
            'version' => $_ENV['AWS_VERSION'],
            'credentials' => array(
                'key' => $_ENV['AWS_ACCESS_KEY_ID'],
                'secret'  => $_ENV['AWS_SECRET_ACCESS_KEY'],
            )
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
        if (array_key_exists($key,$this->authResult)) {
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
}