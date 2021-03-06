<?php

require '../config/Conexion.php';

class M_Vehiculo
{
    function __construct(){

    }

    //Nos mostrara los vehiculos por conductor, filtro en tipo de vehiculo y codigo conductor
    public function selectVehiculoPersona($codigo, $tipoV)
    {
        $sql = "SELECT ws_vehiculo.placa, ws_vehiculo.marca, ws_vehiculo.color from ws_vehiculo INNER JOIN t_vehiculo on t_vehiculo.placa = ws_vehiculo.placa INNER JOIN t_persona_has_t_vehiculo on t_persona_has_t_vehiculo.placa = t_vehiculo.placa WHERE t_persona_has_t_vehiculo.codigo = '$codigo' AND t_vehiculo.tipo_vehiculo = '$tipoV' AND t_persona_has_t_vehiculo.estado=1";
        return ejecutarConsulta($sql);
    }

    //Contador de vehiculos por tipo y codigo
    public function countVehiculoPersona($codigo, $tipoV)
    {
        $sql = "SELECT count(*) as cont from ws_vehiculo INNER JOIN t_vehiculo on t_vehiculo.placa = ws_vehiculo.placa INNER JOIN t_persona_has_t_vehiculo on t_persona_has_t_vehiculo.placa = t_vehiculo.placa WHERE t_persona_has_t_vehiculo.codigo = '$codigo' AND t_vehiculo.tipo_vehiculo = '$tipoV'";
        return ejecutarConsulta($sql);
    }

    //Nos mostrara los datos del vehiculo filtrado por placa y tipo de vehiculo
    public function selectDataVehiculo($placa, $tipoV)
    {
        $sql = "SELECT * FROM ws_vehiculo WHERE placa = '$placa' AND tipo_vehiculo = '$tipoV'";
        return ejecutarConsulta($sql);
    }

    //ver cuantas veces aparece vehiculo
    public function countVehiculo($placa)
    {
        $sql = "SELECT count(*) as contadorV FROM t_persona_has_t_vehiculo WHERE placa = '$placa'";
        return ejecutarConsulta($sql);
    }

    //Registrar vehiculo por primera vez

    public function registrarTVehiculo($placa, $tipoV)
    {
        $sql = "INSERT INTO t_vehiculo values('$placa',null,1,'$tipoV')";
        return ejecutarConsulta($sql);
    }

    public function registrarVehiculoPersona($placa, $codigo)
    {
        $sql = "INSERT INTO t_persona_has_t_vehiculo values('$codigo','$placa',1)";
        return ejecutarConsulta($sql);
    }

    //Registrar vehiculo por si ya existe

    //****************usar la fx registrarVehiculoPersona  */

    //Consultar si vehiculo ya se encuentra registrado con usuario
    public function consultaVehiculoExisteUsuario($placa, $codigo)
    {
        $sql = "SELECT COUNT(*) as cc from t_persona_has_t_vehiculo WHERE placa = '$placa' and codigo='$codigo'";
        return ejecutarConsulta($sql);
    }

    public function insertBicicleta($placa,$descripcion,$estado,$tipo_vehiculo)
    {
        $sql = "INSERT INTO t_vehiculo SET placa = '$placa' , descripcion='$descripcion', estado='$estado', tipo_vehiculo='$tipo_vehiculo'";
        return ejecutarConsulta($sql);
    }

    public function selectBicicletaPorPersona($codigo, $tipoV)
    {
        $sql = "SELECT t_vehiculo.placa, t_vehiculo.descripcion from t_vehiculo INNER JOIN t_persona_has_t_vehiculo on t_persona_has_t_vehiculo.placa = t_vehiculo.placa WHERE t_persona_has_t_vehiculo.codigo = '$codigo' AND t_vehiculo.tipo_vehiculo = '$tipoV' AND t_persona_has_t_vehiculo.estado=1";
        return ejecutarConsulta($sql);
    }

    //---------------------------Gestionar Permanencia--------------------------------------------
    public function getControlNow($fecha, $codigo)
    {
        $sql = "SELECT * FROM t_control inner join t_vehiculo on t_control.placa = t_vehiculo.placa WHERE (Date_format(t_control.entrada,'%m/%d/%Y') = Date_format('$fecha','%m/%d/%Y')) AND t_control.codigo = '$codigo' AND t_control.salida IS NULL AND t_vehiculo.tipo_vehiculo = 'Auto'";
        return ejecutarConsulta($sql);
    }

    public function getPermanencia($codigo)
    {
        $sql = "SELECT * FROM t_control WHERE flag_quedarse>0 AND codigo = '$codigo' ";
        return ejecutarConsulta($sql);
    }

    public function setPermanenciaConductor($salida, $fq, $motivo, $id)
    {
        $sql = "UPDATE t_control set salida = '$salida', flag_quedarse = '$fq', motivo = '$motivo' where id_control = '$id' ";
        return ejecutarConsulta($sql);
    }

    //------------estacionamiento cercano--------------------------------------

    public function getAllec(){
		$sql = "SELECT * FROM t_estacionamiento_cercano";
		return ejecutarConsulta($sql);
    }
    
    //--------------------------------------------------------------------Eliminar Vehiculo-------------------------------
    public function updateToDeleteVehicle($state ,$codigo, $placa)
    {
        $sql = "UPDATE t_persona_has_t_vehiculo set estado='$state' where codigo='$codigo' and placa='$placa'";
		return ejecutarConsulta($sql);
    }

    public function checkIfExist($codigo, $placa)
    {
        $sql = "SELECT IF( EXISTS( SELECT * FROM t_persona_has_t_vehiculo WHERE codigo = '$codigo' AND placa = '$placa' AND estado = 0), 1, 0) AS X";
		return ejecutarConsulta($sql);
    }

}

?>