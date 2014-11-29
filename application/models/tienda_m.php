<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tienda_m extends CI_Model
{
	public function obt_detalles_prod( $id )
	{
		$this->load->database();
		
		$query = $this->db->query( "SELECT descripcion, precio, fk_moneda FROM productos WHERE pk_id = ?", array($id) );
		if( $query->num_rows() > 0 )
		{
			return $query->row();
		}
	}

}