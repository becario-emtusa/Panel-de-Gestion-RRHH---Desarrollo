<?php

///////////////////////////////////////////////////////////
//                 CREACIÓN DEL OBJETO                   //
///////////////////////////////////////////////////////////

/*
    Cambios:
        Marzo v0.0:
            - getListaDepartamentosAdmin()
            - getListaLicenciasAdmin()
            - getNumDiasMod()
            - getSolicitudes()
            - setAnulacion()
            - comprobarLogin()
            - getCalendarioCitas()
            - getResumenAdmin()

        Abril v0.1:
            - getDatosSolicitud()
            - getDatosCita()
        
        Mayo v0.1.1:
            - insertarCita()
            - getMotivosPeticion(): Modificado, recibe parámetro de administración.

*/

class conexionBBDD
{
    private $conn;
    private $statement;

    /* Constructor */
    function __construct()
    {
        include("configBBDD.php");
        $this->conectar($servidor, $nombreBBDD, $usuario, $password);
    }

    /* Evitamos el clonado del objeto */
    private function _clone()
    {
    }

    /* Función que realiza la conexion a la BBDD */
    private function conectar($servidor, $nombreBBDD, $usuario, $password)
    {
        try {
            $this->conn = new PDO("sqlsrv:Server=$servidor;Database=$nombreBBDD", $usuario, $password);
        } catch (PDOException $e) {
            echo ($e->getMessage());
        }
    }

    /* Función que ejecuta una consulta pasada por parámetro */
    public function ejecutarConsulta($consulta, $tipoObjeto = PDO::FETCH_OBJ)
    {
        try {
            /* Preparamos la consulta */
            $this->statement = $this->conn->prepare($consulta);

            /* Seleccionamos que nos devuelva un objeto */
            $this->statement->setFetchMode($tipoObjeto);

            /* Ejecutamos la consulta */
            $this->statement->execute();

            /* Devolvemos los valores */
            return $this->statement;
        } catch (PDOException $e) {

            /* Si falla algo, devolveremos Null y mostraremos el fallo */
            echo $e->getMessage();
            return null;
        }
    }

    /* Función que devuelve el calendario de un usuario dado su DNI y el tipo de licencia solicitada */
    public function getCalendarioUsuario($DNI, $tipoLicencia, $administracion = 0)
    {
        /* Consulta */
        $consulta = "exec PrgCalendarioLaboral '" . $DNI . "','" . $tipoLicencia . "', '" . $administracion . "'";
        $this->statement = $this->ejecutarConsulta($consulta);

        return $this->statement;
    }

    public function getTablaResumen()
    {
        $consulta = "exec PrgVerSolicitudesTrafico";
        $this->statement = $this->ejecutarConsulta($consulta);

        return $this->statement;
    }

    /* MARZO 2021 */
    public function getListaDepartamentosAdmin()
    {
        $consulta = "exec LstDepartamentos";
        $this->statement = $this->ejecutarConsulta($consulta);

        return $this->statement;
    }

    /* MARZO 2021 */
    public function getListaLicenciasAdmin()
    {
        $consulta = "exec LstLicencias";
        $this->statement = $this->ejecutarConsulta($consulta);

        return $this->statement;
    }

    /* MARZO 2021 */
    public function getNumDiasMod($IdDepartamento, $IdLicencia, $Fecha, $numDias = -1, $Concesion = 0)
    {
        $consulta = "set nocount on; exec PrgManLicenciasExcepciones '" . $IdDepartamento . "', " . $IdLicencia . " , '" . $Fecha . "', '" . $numDias . "','" . $Concesion . "'";
        $this->statement = $this->ejecutarConsulta($consulta);

        return $this->statement;
    }

    /* MARZO 2021 */
    public function getSolicitudes($NIF)
    {
        $consulta = "set nocount on; exec PrgSolicitudesEstado '" . $NIF . "'";
        $this->statement = $this->ejecutarConsulta($consulta);

        return $this->statement;
    }

    /* MARZO 2021 */
    public function setAnulacion($num_solicitud, $bit_administracion = 0)
    {
        $consulta = "set nocount on; exec PrgSolicitudesAnulacion '" . $num_solicitud . "', '" . $bit_administracion . "'";
        $this->statement = $this->ejecutarConsulta($consulta);

        return $this->statement;
    }

    /* MARZO 2021 */
    public function comprobarLogin($usuario, $password)
    {
        $consulta = "exec PrgPHPLogin '" . $usuario . "','" . $password . "'";
        $this->statement = $this->ejecutarConsulta($consulta);

        return $this->statement;
    }

    /* MARZO 2021 */
    public function getCalendarioCitas($tipo_licencia)
    {
        $consulta = "exec PrgCalendarioCitas " . $tipo_licencia;
        $this->statement = $this->ejecutarConsulta($consulta);

        return $this->statement;
    }

    /* MARZO 2021 */
    public function getResumenAdmin($departamento, $fechaMaxima = 'NULL', $orden = 'fechaSolicitada')
    {
        if ($fechaMaxima != 'NULL') {
            $consulta = "exec PrgResumenAdministradores '" . $departamento . "', '" . $fechaMaxima . "', '" . $orden . "'";
        } else {
            $consulta = "exec PrgResumenAdministradores '" . $departamento . "', " . $fechaMaxima . ", 'NULL'";
        }
        $this->statement = $this->ejecutarConsulta($consulta);

        return $this->statement;
    }

    /* ABRIL 2021 */
    public function getDatosSolicitud($num_solicitud)
    {
        $consulta = "exec PrgDatosSolicitud " . $num_solicitud;
        $this->statement = $this->ejecutarConsulta($consulta);

        return $this->statement;
    }

    /* ABRIL 2021 */
    public function getDatosCita($fecha)
    {
        $consulta = "exec PrgDatosCitas '" . $fecha . "'";
        $this->statement = $this->ejecutarConsulta($consulta);

        return $this->statement;
    }

    /* MAYO 2021 */
    public function insertarCita($tipo_licencia, $fecha, $numero_citas)
    {
        $consulta = "exec PrgLicenciasCreaCita " . $tipo_licencia . ",'" . $fecha . "'," . $numero_citas;
        $this->statement = $this->ejecutarConsulta($consulta);

        return $this->statement;
    }

    /* Función que devuelve los Motivos de una Petición desde la BBDD */
    /* MAYO 2021 */
    public function getMotivosPeticion($administracion = 0)
    {
        if ($administracion === 0) {
            $consulta = "exec PrgTipoLicencia";
        } else {
            $consulta = "exec PrgTipoLicencia 1";
        }
        $this->statement = $this->ejecutarConsulta($consulta);

        return $this->statement;
    }

    public function insertarPeticion($DNI, $tipoLicencia, $fechaIni, $fechaFin, $admin = 0, $tipoObjeto = PDO::FETCH_OBJ)
    {
        /* Consulta */
        if ($admin == 0) {
            $consulta = "set nocount on; exec PrgSolicitud '" . $DNI . "', " . $tipoLicencia . " , '" . $fechaIni . "', '" . $fechaFin . "'";
        } else {
            $consulta = "set nocount on; exec PrgSolicitud '" . $DNI . "', " . $tipoLicencia . " , '" . $fechaIni . "', '" . $fechaFin . "', " . "1";
        }
        $this->statement = $this->ejecutarConsulta($consulta, $tipoObjeto);

        return $this->statement;
    }

    /* Devuelve el Nombre y Apellidos de una personada dado su DNI */
    public function getDatosPersonal($DNI)
    {
        /* Consulta */
        $consulta = "exec PrgDatosPersonal '" . $DNI . "'";
        $this->statement = $this->ejecutarConsulta($consulta);

        return $this->statement;
    }

    /* Función que devuelve los Días disponibles de un usuario dado su DNI */
    public function getDiasDisponibles($DNI, $TipoLicencia)
    {
        /* Consulta */
        $consulta = "exec PrgPersonalLicencias '" . $DNI . "', " . $TipoLicencia;
        $this->statement = $this->ejecutarConsulta($consulta);

        return $this->statement;
    }

    /* Función que cierra la conexión  */
    public function desconectar()
    {
        $this->conn = null;
    }
}
