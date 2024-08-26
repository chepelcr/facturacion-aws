<?php

/**
 * Modelo para el acceso a la base de datos y funciones CRUD
 */

namespace Core;

use \PDO;
use \Throwable;

use Core\Auditorias\Auditorias;
use Core\Config\Conexion;

class Model {
    /** Nombre de la tabla del modelo */
    protected $nombreTabla;

    /**Nombre de la vista que usara la tabla */
    protected $vistaTabla;

    /** Nombre de la llave primaria */
    protected $pkTabla = false;

    /** Columnas que se deben ingresar al modelo */
    protected $camposTabla = [];

    /**Campos que solo se utilizan en la vista */
    protected $camposVista = [];

    /** Usar variables para almacenar la fecha de creacion y actualizacion */
    protected $useTimesnaps = false;

    /** Variable para la fecha de creacion */
    protected $CreatedAt = 'createdAt';

    /** Variable para la fecha de update */
    protected $UpdatedAt = 'updatedAt';

    /** Validar si debe ser autoincremental o no */
    protected $autoIncrement = false;

    /** Tipo de dato a retornar (Puede ser array o json) */
    protected $tipo = "array";

    /**Agrupar el resultado por nombre de campo */
    private $group = false;

    /**Ordenar el resultado de la ejecucion */
    private $order = false;

    /** Variable para los campos select */
    private $campos = array();

    /** Variable para el where de las sentencias sql */
    private $where = '';

    /** Valores que utilizara la sentencia en el where */
    private $camposWhere = array();

    /**Valores para la busqueda dinamica */
    private $camposLike = array();

    /** Campos para insertar en la tabla */
    private $camposInsert;

    /** Valores que se usaran en la sentencia de sql */
    private $valuesInsert;

    //Conexion a la base de datos
    private PDO $db;

    /**Valor para la seleccion del valor maximo de un campo */
    private $campoMax;

    /**Variable para varios valores de maximo */
    private $camposMax = array();

    /**Campos a actualizar en la base de datos */
    private $camposUpdate = array();

    /**Utilizar auditorias */
    protected $auditorias = false;

    /**Nombre del grupo que usará el modelo para conectarse a la base de datos */
    protected $dbGroup = '';

    /**Error generado en el modelo */
    protected $error = array();

    //constructor de la clase
    function __construct($model_name = null) {
        //Intentar conexion a la base de datos
        try {
            $this->db = Conexion::getConnect();
        } catch (Throwable $th) {
            echo $th->getMessage();
        }
    } //Fin del constructor

    /**Establecer el nombre de una vista en el modelo */
    public function vista($nombreVista) {
        $this->vistaTabla = $nombreVista;
        return $this;
    } //Fin de la funcion

    /**Setear los campos del update */
    private function setCamposUpdate($data) {
        $this->camposUpdate = $data;
        return $this;
    } //Fin del metodo para los campos del update

    /**Insertar un registro en la tabla de auditorias */
    public function insertAuditoria($data) {
        $auditorias = new Auditorias();
        $auditorias->insertAuditoria($data);
    } //Fin de la funcion

    /**Insertar un registro en la tabla de errores */
    public function insertError($ex) {
        $id_usuario = getSession('id_usuario');

        if (!$id_usuario)
            $id_usuario = 0;

        $code = $ex->getCode();
        $message = $ex->getMessage();
        $file = $ex->getFile();
        $line = $ex->getLine();

        $messagecomplet = "Error generado en el archivo $file, linea $line: [Codigo de error $code] $message";

        $data = array(
            'sentencia' => $messagecomplet,
            'controlador' => $this->nombreTabla,
            'id_usuario' => $id_usuario
        );

        $this->error = $data;

        insertError($data);
    } //Fin de la funcion

    /** Obtener el error generado en el modelo */
    public function getError() {
        return json_decode(json_encode($this->error));
    }

    /** Actualizar un registro en la base de datos */
    public function update($data, $id = null) {
        try {
            $db = $this->query();

            $this->setCamposUpdate($data);

            if (isset($id))
                $this->where($this->pkTabla, $id);

            $sql = $this->crearQuery('UPDATE');

            $update = $db->prepare($sql);

            foreach ($data as $campo => $valor) {
                $update->bindValue($campo, $valor);
            }

            if (isset($id)) {
                $update->bindValue($this->pkTabla, $id);
            }

            $update->execute();

            /**Insertar auditoria */
            if ($this->auditorias) {

                $id_usuario = 0;

                if (getSession('id_usuario')) {
                    $id_usuario = getSession('id_usuario');
                }
                if (isset($id)) {
                    $id_fila = $id;
                } else {
                    $id_fila = 1;
                }

                $data = array(
                    'id_fila' => $id_fila,
                    'tabla' => $this->nombreTabla,
                    'accion' => 'UPDATE',
                    'id_usuario' => $id_usuario
                );

                $this->insertAuditoria($data);
            }

            if (isset($id)) {
                $data[$this->pkTabla] = $id;
            }

            return (object) $data;
        } //Fin del try

        catch (\Exception $ex) {
            var_dump($ex);

            if ($this->auditorias) {
                $this->insertError($ex);
            } //Fin de validacion
        } //Fin del catch

        return false;
    } //Fin del método

    /** Actualizar un registro en la base de datos
     * 
     * @param array $data Datos a actualizar en la base de datos
     * @param int $id ID del registro a actualizar
     * 
     * @return mixed Datos del registro actualizado o false si no se pudo actualizar
     */
    public function updateComplexData($data, $id = null) {
        try {
            $db = $this->query();

            $this->setCamposUpdate($data);

            if (isset($id))
                $this->where($this->pkTabla, $id);

            $sql = $this->crearQuery('UPDATE');

            $update = $db->prepare($sql);

            foreach ($data as $campo => $valor) {
                if (isset($valor['type']) && $valor['type'] == 'blob') {
                    $update->bindParam($campo, $valor['data'], PDO::PARAM_LOB);
                } else {
                    $update->bindValue($campo, $valor);
                }
            }

            if (isset($id)) {
                $update->bindValue($this->pkTabla, $id);
            }

            $update->execute();

            /**Insertar auditoria */
            if ($this->auditorias) {
                $id_usuario = 0;

                if (getSession('id_usuario')) {
                    $id_usuario = getSession('id_usuario');
                }

                if (isset($id)) {
                    $id_fila = $id;
                } else {
                    $id_fila = 1;
                }

                $data = array(
                    'id_fila' => $id_fila,
                    'tabla' => $this->nombreTabla,
                    'accion' => 'UPDATE',
                    'id_usuario' => $id_usuario
                );

                $this->insertAuditoria($data);
            }

            if (isset($id)) {
                $data[$this->pkTabla] = $id;
            }

            return $data;
        } //Fin del try

        catch (\Exception $ex) {
            var_dump($ex);

            if ($this->auditorias) {
                $this->insertError($ex);
            } //Fin de validacion
        } //Fin del catch

        return false;
    } //Fin del método

    /**Seleccionar una columna especifica de la tabla */
    public function select($nombreCampo) {
        $campos = $this->campos;

        $campos[] = $nombreCampo;

        $this->campos = $campos;

        return $this;
    } //Fin del select

    /**Crear la sentencia para seleccionar columnas especificas */
    private function sentenciaSelect() {
        $campos = $this->campos;

        if (empty($campos)) {
            $campos = $this->generarCampos();
        } //Fin de la validacion

        $select = "`";

        $select .= implode("`, `", $campos);

        $select .= "`";

        if (!empty($this->camposMax)) {
            foreach ($this->camposMax as $campoMax) {
                $select .= ", MAX(`$campoMax`) AS `$campoMax`";
            }
        }

        return $select;
    } //Fin de la funcion

    private function sentenciaLike() {
        $camposLike = $this->camposLike;

        $sentencia = '`';

        if (empty($camposLike))
            return false;

        $i = 0;

        foreach ($camposLike as $columna => $valor) {
            if ($i == 0) {
                $sentencia .= $columna . '` LIKE :' . $columna;
                $i = $i + 1;
            } else {
                $sentencia .= ' AND `' . $columna . '` LIKE :' . $columna;
            }
        } //Fin del ciclo
        return $sentencia;
    } //Fin del metodo

    /** Funcion para crear la sentencia where */
    private function sentenciaWhere() {
        $camposWhere = $this->camposWhere;

        $sentencia = 'WHERE `';
        $i = 0;

        if (empty($camposWhere))
            return false;

        foreach ($camposWhere as $campo => $valor) {
            if ($i == 0) {
                $sentencia = $sentencia . $campo . "`=:" . $campo;
                $i = $i + 1;
            } else {
                $sentencia = $sentencia . " AND `" . $campo . "`=:" . $campo;
            } //Fin del else
        } //Fin del ciclo

        return $sentencia;
    } //Fin de la funcion

    /**Filtrar una cunsulta en la base de datos */
    public function where(string $nombreCampo, string $valor) {
        $camposWhere = $this->camposWhere;

        $camposWhere[$nombreCampo] = $valor;

        $this->setCamposWhere($camposWhere);

        return $this;
    } //Fin del where

    /**Obtener las filas que contenga un valor en la columna especifica */
    public function like(string $columna, string $valor) {
        $camposLike = $this->camposLike;

        $camposLike[$columna] = '%' . $valor . '%';

        $this->camposLike = $camposLike;

        return $this;
    } //Fin de la funcion

    /**Asignar los campos para hacer el filtro de la consulta*/
    private function setCamposWhere(array $camposWhere) {
        $this->camposWhere = $camposWhere;
        return $this;
    } //Fin de setCamposWhere

    /**Generar los campos de la tabla del modelo */
    private function generarCampos() {
        $campos = $this->campos;

        //var_dump($campos);

        if (empty($campos)) {
            $espacio = 0;

            $data = array();

            $pkTabla = $this->pkTabla;
            $camposTabla = $this->camposTabla;
            $camposVista = $this->camposVista;

            if ($pkTabla) {
                $data[$espacio] = $pkTabla;
                $espacio = $espacio + 1;
            }

            foreach ($camposTabla as $campo) {
                $data[$espacio] = $campo;
                $espacio = $espacio + 1;
            } //Fin del ciclo para llenar los campos

            if (isset($this->vistaTabla)) {
                foreach ($camposVista as $campo) {
                    $espacio = $espacio + 1;

                    $data[$espacio] = $campo;
                } //Fin del ciclo para llenar los campos de la vista
            }

            if ($this->useTimesnaps) {
                $CreatedAt = $this->CreatedAt;
                $UpdatedAt = $this->UpdatedAt;

                $data[$espacio + 1] = $CreatedAt;
                $data[$espacio + 2] = $UpdatedAt;
            } //Fin del if

            return $data;
        } //Fin de campos vacios

        return $campos;
    } //Fin de generarCampos

    /**Agrupar los resultados de la bae de datos */
    public function groupBy($nombreCampo) {
        $this->group = $nombreCampo;

        return $this;
    } //Fin de la funcion

    /**Agrupar los resultados de la bae de datos */
    public function OrderBy($nombreCampo) {
        $this->order = $nombreCampo;
    } //Fin de la funcion

    /**Crear la sentencia de sql a utilizar en la ejecucion */
    private function crearQuery(string $tipo = "SELECT") {
        $tabla = $this->nombreTabla;
        $where = $this->sentenciaWhere();
        $like = $this->sentenciaLike();
        $group = $this->group;
        $order = $this->order;

        //Generar la sentencia de acuerdo al tipo solicitado
        switch ($tipo) {
            case 'SELECT':
                $select = $this->sentenciaSelect();

                if ($where) {
                    $sql = $tipo . " " . $select . " FROM " . $tabla . " " . $where;

                    if ($like) {
                        $sql .= ' AND ' . $like;
                    }
                } else {
                    $sql = $tipo . " " . $select . " FROM " . $tabla;

                    if ($like) {
                        $sql .= ' WHERE ' . $like;
                    }
                }

                if ($group) {
                    $sql .= " GROUP BY :group";
                }

                if ($order) {
                    $sql .= " ORDER BY :order";
                }

                //var_dump($sql);

                break;

            case 'INSERT':
                $campos = $this->camposInsert;
                $values = $this->valuesInsert;

                $sql = $tipo . " INTO " . $tabla . $campos . " VALUES " . $values;
                break;

            case 'UPDATE':
                $sql = 'UPDATE ' . $this->nombreTabla . ' SET `';

                $data = $this->camposUpdate;

                $indice = 0;

                foreach ($data as $campo => $valor) {
                    if ($indice == 0) {
                        $sql .= $campo . '` = :' . $campo;
                        $indice = $indice + 1;
                    } //Fin del if

                    else {
                        $sql .= ', `' . $campo . '` = :' . $campo;
                    } //Fin del else
                } //Fin del ciclo

                if ($where)
                    $sql .= " " . $where;

                break;

            case 'DELETE':
                if ($where)
                    $sql = $tipo . " FROM " . $tabla . " " . $where;

                else
                    $sql = $tipo . " FROM " . $tabla;
                break;

            case 'MAX':
                $sql = 'SELECT ';

                $camposMax = $this->camposMax;

                $indice = 0;

                foreach ($camposMax as $campo) {
                    if ($indice == 0) {
                        $sql .= 'MAX(`' . $campo . '`) AS `' . $campo . '`';
                        $indice = $indice + 1;
                    } //Fin del if

                    else {
                        $sql .= ', MAX(`' . $campo . '`) AS `' . $campo . '`';
                    } //Fin del else
                } //Fin del ciclo

                $sql .= " FROM " . $tabla;

                if ($where) {
                    $sql .= " " . $where;

                    if ($like) {
                        $sql .= ' AND ' . $like;
                    }
                }

                break;
        } //Fin del switch

        //Retornar la sentencia sql generada
        return $sql;
    } //Fin de crear query

    /** Validar si la llave primaria debe ser autoincremental o no */
    private function insertPk(array $data) {
        if ($this->autoIncrement = true) {
            $db = $this->query();

            try {
                $this->setMax($this->pkTabla);

                $sql = $this->crearQuery('MAX');

                $max = $db->prepare($sql);

                $max->execute();

                $result = $max->fetch();

                $data[$this->pkTabla] = $result[0] + 1;
            } catch (\Exception $ex) {
                if ($this->auditorias) {
                    $this->insertError($ex);
                } //Fin de validacion
            } //Fin del catch

        } //Fin del if

        return $data;
    } //Fin de insertPk

    /**Obtener la primera fila de la tabla */
    public function fila() {
        $db = $this->query();

        try {
            //Si la conexion a la base de datos no es nula
            if ($db != null) {
                if (isset($this->vistaTabla)) {
                    $this->table($this->vistaTabla);
                }

                //Crear la sentencia de ejecucion
                $sql = $this->crearQuery();

                //Preparar la conexion
                $select = $db->prepare($sql);

                $camposWhere = $this->camposWhere;

                foreach ($camposWhere as $campo => $valor) {
                    $select->bindValue($campo, $valor);
                }

                $select->execute();

                $result = $select->fetch();

                //var_dump($result);

                if (!$result) {
                    return false;
                } //Fin del if

                $data = array();

                $camposTabla = $this->generarCampos();

                foreach ($camposTabla as $campoTabla) {
                    if (isset($result[$campoTabla]))
                        $data[$campoTabla] = $result[$campoTabla];
                } //Fin del ciclo

                return (object) $data;
            } //Fin del if
        } catch (\Exception $ex) {
            if ($this->auditorias) {
                $this->insertError($ex);
            } //Fin de validacion

            return false;
        } //Fin del catch

        return false;
    } //Fin de fila

    /** Determinar el tipo de objeto a retornar (array o json) */
    public function setType(string $tipo) {
        $this->tipo = $tipo;
        return $this;
    } //Fin del metodo

    /**Obtener el valor maximo de un campo */
    public function max($nombreCampo) {
        $this->setMax($nombreCampo);

        return $this;
    } //Fin de la funcion para seleccionar el valor maximo de una columna

    /**Agregar el campo para la seleccion del max */
    private function setMax($campoMax) {
        /**Añadir el valor al un campo del array camposMax */
        $this->camposMax[] = $campoMax;
        return $this;
    } //Fin de la funcion

    /** Contar la cantidad de filas de todo el modelo*/
    public function count() {
        $db = $this->query();

        //Si la conexion a la base de datos no es nula
        if ($db != null) {
            $objetos = $this->getAll();

            $dato = count($objetos);

            return $dato;
        } //Fin del if
    } //Fin de count

    private function camposInsert(array $data) {
        $pk = $this->pkTabla;

        if ($this->autoIncrement = true) {
            //Campos para la tabla
            $campos = "(" . $pk;
            $camposTabla = $this->camposTabla;

            $values = "(:" . $pk;

            $data = $this->insertPk($data);

            //Ciclo para crear la sentencia con los campos y valores que seran agregados a la tabla
            foreach ($data as $clave => $valor) {
                //Ciclo para validar si el campo se encuentra en la tabla
                foreach ($camposTabla as $campo) {
                    if ($clave == $campo) {
                        $campos = $campos . ", " . $clave;
                        $values = $values . ", :" . $clave;
                    }
                } //Fin del ciclo de validacion
            } //Fin del ciclo
        } //Fin del if

        else {
            //Campos para la tabla
            $campos = "(";
            $camposTabla = $this->camposTabla;

            $values = "(";

            $data = $this->insertPk($data);

            $espacio = 1;

            //Ciclo para crear la sentencia con los campos y valores que seran agregados a la tabla
            foreach ($data as $clave => $valor) {
                //Ciclo para validar si el campo se encuentra en la tabla
                foreach ($camposTabla as $campo) {
                    if ($clave == $campo) {
                        switch ($espacio) {
                            case '1':
                                $campos = $campos . $clave;
                                $values = $values . ":" . $clave;

                                $espacio++;
                                break;

                            default:
                                $campos = $campos . ", " . $clave;
                                $values = $values . ", :" . $clave;
                                break;
                        } //Fin del switch
                    } //Fin del if
                } //Fin del ciclo de validacion
            } //Fin del ciclo
        }



        if ($this->useTimesnaps) {
            $CreatedAt = $this->CreatedAt;
            $UpdatedAt = $this->UpdatedAt;

            $campos = $campos . ", " . $CreatedAt . ", " . $UpdatedAt;
            $values = $values . ", :" . $CreatedAt . ", :" . $UpdatedAt;

            $data[$CreatedAt] = date("Y-m-d h:i:s");
            $data[$UpdatedAt] = date("Y-m-d h:i:s");
        } //Fin del if

        $campos = $campos . ")";
        $values = $values . ")";

        $this->camposInsert = $campos;
        $this->valuesInsert = $values;

        return $data;
    } //Fin de camposInsert

    /**
     * Insertar un registro en la base de datos
     * 
     * @param array $data Datos a insertar en la base de datos
     * @return mixed Data insertada en la base de datos o false si no se inserto
     */
    public function insert(array $data) {
        $db = $this->query();

        try {
            //Si la conexion a la base de datos no es nula
            if ($db != null) {
                $data = $this->camposInsert($data);

                //Crear la sentencia de ejecucion
                $sql = $this->crearQuery("INSERT");

                //Preparar la conexion
                $insert = $db->prepare($sql);

                //Ciclo para terminar la preparacion de la ejecucion
                foreach ($data as $campo => $valor) {
                    $insert->bindValue($campo, $valor);
                } //Fin del ciclo

                if ($insert->execute()) {
                    /**Insertar auditoria */
                    if ($this->auditorias) {
                        if (getSession('id_usuario')) {
                            $id_usuario = 0;
                        } else {
                            $id_usuario = getSession('id_usuario');
                        }

                        if ($this->pkTabla) {
                            $id_fila = $data[$this->pkTabla];
                        } else {
                            $id_fila = 1;
                        }

                        $audit = array(
                            'id_fila' => $id_fila,
                            'tabla' => $this->nombreTabla,
                            'accion' => 'INSERT',
                            'id_usuario' => $id_usuario
                        );

                        $this->insertAuditoria($audit);
                    } //Fin de la insercion de auditoria

                    //Retorna la data insertada
                    return (object) $data;
                } //Fin de la ejecucion

                else {
                    return false;
                }
            } //Fin del if
        } catch (\Exception $ex) {
            if ($this->auditorias) {
                $this->insertError($ex);
            } //Fin de validacion

            return false;
        } //Fin del catch
    } //Fin de la funcion

    /**
     * Insertar un registro en la base de datos con campos complejos como binarios
     * 
     * @param array $data Datos a insertar en la base de datos
     * 
     * Ejemplo de uso:
     *  $data = array(
     *      'file' => array(
     *          'data' => 'file',
     *          'type' => 'blob'
     *      ),
     *      'nombre' => array(
     *          'data' => 'nombre',
     *          'type' => 'string'
     *      )
     * );
     * 
     * @return mixed Data insertada en la base de datos o false si no se inserto
     */
    public function insertCompexData($data) {
        $db = $this->query();

        try {
            //Si la conexion a la base de datos no es nula
            if ($db != null) {
                $data = $this->camposInsert($data);

                //Crear la sentencia de ejecucion
                $sql = $this->crearQuery("INSERT");

                //Preparar la conexion
                $insert = $db->prepare($sql);

                //Ciclo para terminar la preparacion de la ejecucion
                foreach ($data as $campo => $valor) {
                    if (isset($valor['type']) && $valor['type'] == 'blob') {
                        $insert->bindParam($campo, $valor['data'], PDO::PARAM_LOB);
                    } else {
                        $insert->bindValue($campo, $valor);
                    }
                } //Fin del ciclo

                if ($insert->execute()) {
                    /**Insertar auditoria */
                    if ($this->auditorias) {

                        if (getSession('id_usuario')) {
                            $id_usuario = 0;
                        } else {
                            $id_usuario = getSession('id_usuario');
                        }

                        if ($this->pkTabla) {
                            $id_fila = $data[$this->pkTabla];
                        } else {
                            $id_fila = 1;
                        }

                        $audit = array(
                            'id_fila' => $id_fila,
                            'tabla' => $this->nombreTabla,
                            'accion' => 'INSERT',
                            'id_usuario' => $id_usuario
                        );

                        $this->insertAuditoria($audit);
                    } //Fin de la insercion de auditoria

                    return $data;
                } //Fin de la ejecucion

                else {
                    return false;
                }
            } //Fin del if
        } catch (\Exception $ex) {
            if ($this->auditorias) {
                $this->insertError($ex);
            } //Fin de validacion

            return false;
        } //Fin del catch
    }

    /** Obtener todos los elementos de una tabla */
    public function getAll() {
        $db = $this->query();

        //Realizar intento
        try {
            //Si la conexion a la base de datos no es nula
            if ($db != null) {
                if (isset($this->vistaTabla))
                    $this->table($this->vistaTabla);

                //var_dump($this->nombreTabla);

                //Crear la sentencia de ejecucion
                $sql = $this->crearQuery();

                //Preparar la conexion
                $select = $db->prepare($sql);

                $camposWhere = $this->camposWhere;
                $camposLike = $this->camposLike;

                foreach ($camposWhere as $campo => $valor) {
                    $select->bindValue($campo, $valor);
                }

                foreach ($camposLike as $columna => $valor) {
                    $select->bindValue($columna, $valor);
                }

                $group = $this->group;

                if ($group) {
                    $select->bindValue('group', $group);
                }

                $order = $this->order;

                if ($group) {
                    $select->bindValue('order', $order);
                }

                $select->execute();

                $result = $select->fetchAll();

                //var_dump($result);

                //Limpiar las variables del sql
                //$this->clean();

                $camposTabla = $this->generarCampos();
                $objetos = [];

                foreach ($result as $objeto) {
                    $data = [];

                    foreach ($camposTabla as $campoTabla) {
                        if (isset($objeto[$campoTabla]))
                            $data[$campoTabla] = $objeto[$campoTabla];
                    }

                    $objetos[] = (object)  $data;
                }

                return (object) $objetos;
            } //Fin de la base de datos no nula
        } //Fin del intento

        catch (\Exception $ex) {
            //var_dump($ex);

            if ($this->auditorias) {
                $this->insertError($ex);
            } //Fin de validacion
        } //Fin del catch

        return false;
    } //Fin de buscar

    /**Utilizar una tabla personalizada */
    public function table($nombreTabla) {
        $this->nombreTabla = $nombreTabla;

        return $this;
    } //Fin de la funcion

    //la función para obtener un objeto por el id
    public function getById($id) {
        $db = $this->query();

        try {
            //Si la conexion a la base de datos no es nula
            if ($db != null) {
                $this->where($this->pkTabla, $id);

                $result = $this->fila();

                if (!$result)
                    return false;

                return $result;
            } //Fin del if
        } //Fin del intento

        catch (\Exception $ex) {
            if ($this->auditorias) {
                $this->insertError($ex);
            } //Fin de validacion
        } //Fin del catch
    } //Fin de getByID

    /**Obtener uno o varios objetos de la base de datos */
    public function obtener($id) {
        if ($id == 'all') {
            return $this->getAll();
        } else {
            return $this->getById($id);
        }
    } //Fin de la funcion obtener

    /**Eliminar un registro de la base de datos */
    public function delete($id) {
        $db = $this->query();

        try {
            //Si la base de datos no es nula
            if ($db != null) {
                $this->where($this->pkTabla, $id);

                $sql = $this->crearQuery('DELETE');

                $delete = $db->prepare($sql);

                $camposWhere = $this->camposWhere;

                //Llenar el array de los campos a borrar
                foreach ($camposWhere as $campo => $valor) {
                    $delete->bindValue($campo, $valor);
                }

                if ($delete->execute()) {
                    /**Insertar auditoria */
                    if ($this->auditorias) {
                        $id_usuario = getSession('id_usuario');

                        if (!$id_usuario)
                            $id_usuario = 0;

                        $data = array(
                            'id_fila' => $id,
                            'tabla' => $this->nombreTabla,
                            'accion' => 'DELETE',
                            'id_usuario' => $id_usuario
                        );

                        $this->insertAuditoria($data);
                    }

                    return $id;
                } //Fin del if

                return false;
            } //Fin del if
        } catch (\Exception $ex) {
            if ($this->auditorias) {
                $this->insertError($ex);
            } //Fin de validacion
        } //Fin del catch
    } //Fin de la funcion delete

    public function query() {
        return $this->db;
    } //Fin de la funcion
} //Fin
