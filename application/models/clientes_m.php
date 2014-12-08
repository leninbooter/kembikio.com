<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Clientes_m extends CI_Model
{
	public function registrar( $email, $nombre, $apellido, $telefono, $direccion, $cp )
	{
		$this->load->database();
		
		$query = $this->db->query( "CALL ins_cliente(?, ?, ?, ?, ?, ?);", array($email, $nombre, $apellido, $telefono, $direccion, $cp) );		
		if( $this->db->affected_rows() > 0 )
		{
			$cliente = $query->row()->id;
			mysqli_next_result( $this->db->conn_id );
			return $cliente;
		}else
		{
			return false;
		}			
	}
}