<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contactos extends CI_Model {

	public function enviar_comentarios( $email, $asunto, $nombre, $apellido, $telefono, $empresa, $cargo, $comentarios )
	{
		$para = "leninbooter@gmail.com";
		$titulo = "Formulario de contacto - ".$asunto;
		$mensaje = "
		<html>
			<head>
				<title>".$asunto."</title>
			</head>
			
			<body>
				<table>
					<tr>
						<td>Asunto: </td><td>".$asunto."</td>
					</tr>
					<tr>
						<td>Remitente: </td><td>".$nombre." ".$apellido."</td>
					</tr>
					<tr>
						<td>Telefono: </td><td>".$telefono."</td>
					</tr>
					<tr>
						<td>E-mail: </td><td>".$email."</td>
					</tr>
					<tr>
						<td>Empresa / Cargo: </td><td>".$empresa." - ".$cargo."</td>
					</tr>
					<tr>
						<td>Comentarios: </td><td>".$comentarios."</td>
					</tr>
				</table>
			</body>			
		</html>
		";
		
		$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
		$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$cabeceras .= 'From: kembikio.com <info@kembikio.com>';
		return mail( $para, $titulo, $mensaje, $cabeceras );
	}
}