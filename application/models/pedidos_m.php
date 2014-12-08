<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pedidos_m extends CI_Model
{
	public function registrar( $id_cliente, $id_servicio, $subtotal, $imp_porcentaje, $total )
	{	
		log_message('debug', 'registrar'."CALL ins_pedido(".$id_cliente.", ".$id_servicio.", ".$subtotal.", ".$imp_porcentaje.", ".$total.")");
		$this->load->database();
		
		$query = $this->db->query( "CALL ins_pedido(?, ?, ?, ?, ?);", array($id_cliente, $id_servicio, $subtotal, $imp_porcentaje, $total) );		
		$result = $query->result();
		if( !empty( $result ) )
		{
			log_message('debug', 'affected rows: '. $this->db->affected_rows());
			mysqli_next_result( $this->db->conn_id );
			$id_orden = $query->row()->id;
			return $id_orden;
		}else
		{
			log_message('debug', 'affected rows < 0');
			return false;
		}			
	}

	public function reg_pago_aceptado( $id_pedido, $id_cliente )
	{
	log_message('debug', 'reg_pago_aceptado');
		$this->load->database();
		
		$query = $this->db->query( "CALL reg_pago_autorizado(?, ?);", array( $id_pedido, $id_cliente ) );		
		
		$result = $query->result();
		if( !empty( $result ) )
		{
			if( (bool) $query->row()->result )
			{
				mysqli_next_result( $this->db->conn_id );
				return true;
			}
		}
		return false;
	}
	
	public function reg_pago_rechazado( $id_pedido, $id_cliente )
	{
		log_message('debug', 'reg pago rechazado '."CALL reg_pago_rechazado(".$id_pedido.", ".$id_cliente.");");
		$this->load->database();
		
		$query = $this->db->query( "CALL reg_pago_rechazado(?, ?);", array( $id_pedido, $id_cliente ) );
		
		$result = $query->result();
		if( !empty( $result ) )
		{
			if( (bool) $query->row()->result )
			{
				mysqli_next_result( $this->db->conn_id );
				log_message('debug', 'reg pago rechazado registrado');
				return true;
			}
		}
		log_message('debug', 'reg pago rechazado fallo');
		return false;
	}
}