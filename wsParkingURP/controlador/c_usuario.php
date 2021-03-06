<?php

function prueba(){
	$bienvenida = $_REQUEST['bienvenida'];

	echo "holi" . $bienvenida;
}

function login()
{
	require_once '../modelo/M_Usuario.php';
	$m_usuario = new M_Usuario();

	$codigo = $_REQUEST['codigo'];
	$password = $_REQUEST['password'];

	$rspta = $m_usuario->login($codigo, $password);

	$datos = Array();

	foreach ($rspta as $row) {
		$datos[] = $row;
	}
	echo json_encode($datos);
}

function insertarUsuario()
{
	require_once '../modelo/M_Usuario.php';
	$m_usuario = new M_Usuario();

	$codigo = $_REQUEST['codigo'];
	$password = $_REQUEST['password'];

	$rspta = $m_usuario->insertarUsuario($codigo, $password);
	echo json_encode("Registro exitoso.");

}

function updatePassUser()
{
	require_once '../modelo/M_Usuario.php';
	$m_usuario = new M_Usuario();

	$password = $_REQUEST['password'];
	$codigo = $_REQUEST['codigo'];
	
	$rspta = $m_usuario->updatePassword($password,$codigo);
	echo json_encode("Actualizacion exitoso.");

}

function getAll(){

	require_once '../modelo/M_Usuario.php';
	$m_usuario = new M_Usuario();

	$rspta = $m_usuario->getAll();

	$datos = Array();

	foreach ($rspta as $row) {
		$datos[] = $row;
	}
		echo json_encode($datos);
}


function getPerfilxCodigo()
{
	require_once '../modelo/M_Usuario.php';
	$m_usuario = new M_Usuario();

	$codigo = $_REQUEST['codigo'];

	$rspta = $m_usuario->getPerfil($codigo);

	$datos = Array();

	foreach ($rspta as $row) {
		$datos[] = $row;
	}
	echo json_encode($datos);
}

function getPasswordByMail()
{
	require_once '../modelo/M_Usuario.php';
	$m_usuario = new M_Usuario();

	$correo = $_REQUEST['correo'];

	$rspta = $m_usuario->getPasswordUserByMail($correo);

	$datos = Array();

	foreach ($rspta as $row) {
		$datos[] = $row;
	}
	echo json_encode($datos);
}

function getPasswordByCodigo()
{
	require_once '../modelo/M_Usuario.php';
	$m_usuario = new M_Usuario();

	
	$pass = $_REQUEST['password'];
	$code = $_REQUEST['codigo'];

	$rspta = $m_usuario->getPasswordUserByCodigo($pass, $code);

	$datos = Array();

	foreach ($rspta as $row) {
		$datos[] = $row;
	}
	echo json_encode($datos);
}

function sendEmail()
{
	//if "email" variable is filled out, send email
	//Email information
	$admin_email = "abeljosetr15@gmail.com";
	$email = $_REQUEST['email'];
	$subject = $_REQUEST['subject'];
	$comment = $_REQUEST['comment'];

	//send email
	mail($email, "$subject", $comment, "From:" .$email );

	//Email response
	echo "Thank you for contacting us!";

		
}

/*-------------------------------------------------------------------------
- Apartir de aqui van los metodos a ejecutar.

- Luego agregar en el metodo ejecutar dentro del switch case.

- Como ejecutar el metodo?

	http://localhost:82/wsParkingURP/controlador/(controlador.php)?metodo=(metodo_a_ejecutar)&(parametros) 

	Ejemplo ejecutar el metodo prueba:

	http://localhost:82/wsParkingURP/controlador/c_usuario.php?metodo=prueba&bienvenida=saludos 
*/

$metodo = $_REQUEST['metodo'];
$funcion = ejecutar($metodo);

function ejecutar($metodo){
	switch ($metodo) {
		case 'login':
			login();
			break;

		case 'insertarUsuario':
			insertarUsuario();
			break;

		case 'getAll':
			getAll();
			break;

		case 'getPerfilxCodigo':
			getPerfilxCodigo();
			break;

		case 'getPasswordByMail':
			getPasswordByMail();
			break;

		case 'sendEmail':
			sendEmail();
			break;

		case 'getPasswordByCodigo':
			getPasswordByCodigo();
			break;

		case 'updatePassUser':
			updatePassUser();
			break;
			
		default:
			echo "No existe el metodo";
			break;
	}
}

?>