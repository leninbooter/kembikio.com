<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tienda extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	
	
	public function agregar_carrito()
	{
		$this->load->library('cart');
		$this->load->model('tienda_m');
		
		$servicio_id = trim( $this->input->get( 'serv_id', TRUE ) );
		if( is_numeric( $servicio_id ) )
		{
			if( is_object( $detalles_servicio = $this->tienda_m->obt_detalles_prod( $servicio_id ) ) )
			{
				$data = array(
				   'id'      => $servicio_id,
				   'qty'     => 1,
				   'price'   => $detalles_servicio->precio,
				   'name'    => $detalles_servicio->descripcion,
				   'options' => array('moneda_cod_local' => $detalles_servicio->fk_moneda)
				);

				$this->cart->insert($data);
					
				$data['title'] = "Contratación de Servicio - Paso 1";
				$this->load->view('compra_1', $data);
			}
		}else
		{
			echo "Formato de datos de entrada incorrecto";
		}
	}
	
	public function telefono_valido( $valor )
	{
		if( preg_match( '/^(?:\d|\+){1}[0-9]{1,19}$/', $valor )  == 1 )
		{
			return true;
		}else
		{
			$this->form_validation->set_message('telefono_valido', 'El número de teléfono es obligatorio, debe tener solo números y puede contener el signo + adelante');
			return false;
		}
	}
	
	public function direccion_valida( $valor )
	{
		if( preg_match( '/^[A-Za-z0-9ñÑ\_\-\.\,\#\s]{5,200}$/', $valor ) == 1 )
		{
			return true;
		}else {
			$this->form_validation->set_message('direccion_valida', 'La dirección es obligatoria y solo puede contener letras, números y los signos - _ , . y #');
			return false;
		}
	}
	
	public function registrar_orden()
	{
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');			
				
		$config = array(
               array(
                     'field'   => 'nombre',
                     'label'   => 'Nombre',
                     'rules'   => 'trim|xss_clean|required|min_length[1]|max_length[50]|alpha'
                  ),
               array(
                     'field'   => 'apellido',
                     'label'   => 'Apellido',
                     'rules'   => 'trim|xss_clean|required|min_length[1]|max_length[50]|alpha'
                  ),   
               array(
                     'field'   => 'email',
                     'label'   => 'E-mail',
                     'rules'   => 'trim|required|xss_clean|valid_email|max_length[200]'
                  ),
			   array(
					'field'		=> 'email_conf',
					'label'		=> 'E-mail confirmación',
					'rules'		=> 'trim|xss_clean|max_length[200]|valid_email'
			   ),
			   array(
					'field'		=> 'cp',
					'label'		=> 'Código postal',
					'rules'		=> 'trim|xss_clean|min_length[4]|max_length[5|numeric'
			   )
            );

		$this->form_validation->set_rules($config);
		$this->form_validation->set_rules('telefono', 'Teléfono', 'telefono_valido');
		$this->form_validation->set_rules('direccion', 'Dirección', 'direccion_valida');
		
		$this->form_validation->set_message('required', 'El campo de %s es obligatorio.');
		$this->form_validation->set_message('alpha', 'El campo de %s solo puede contener letras.');
		
		if ( !$this->form_validation->run() )
		{
			echo validation_errors();
		}
		else
		{
			$nombre 		= trim( $this->input->post('nombre', 		TRUE) );
			$apellido 		= trim( $this->input->post('apellido', 		TRUE) );
			$email 			= trim( $this->input->post('email', 		TRUE) );
			$telefono 		= trim( $this->input->post('telefono', 		TRUE) );
			$direccion 		= trim( $this->input->post('direccion',		TRUE) );
			$cp 			= trim( $this->input->post('cp', 			TRUE) );
			
			if( strlen($nombre) 	<= 2 || 
				strlen($apellido) 	<= 2 || 
				strlen($email) 		<= 2 || 
				strlen($telefono) 	<= 2 || 
				strlen($direccion) 	<= 2 || 
				strlen($cp) 	<= 2 )
			{
				echo "<p>Formato del mensaje inválido.</p>";
			}else 
			{
				$this->load->model('clientes_m');
				$this->load->model('pedidos_m');
				
				if( $id_cliente = $this->clientes_m->registrar(  $email, $nombre, $apellido, $telefono, $direccion, $cp ) )
				{
					if( $this->pedidos_m->registrar( ) )
					{
						echo "<p>Enviado <img src=\"".base_url('assets/imagenes/checked_verde.png')."\"></p>";
					}
				}else {
					echo "<p>Error procesando la orden; por favor, inténtelo más tarde.</p>";
				}
			}
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */