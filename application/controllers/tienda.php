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
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('cart');
	}
	
	public function agregar_carrito()
	{
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
				   'name'    => htmlentities ($detalles_servicio->descripcion),
				   'options' => array('moneda_cod_local' => $detalles_servicio->fk_moneda)
				);
				$this->cart->destroy();
				$this->cart->insert($data);
				$this->session->set_userdata('descripcion', $detalles_servicio->descripcion);
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
		log_message('debug', "registrar_orden");
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
			log_message('debug', "a validar");
			$nombre 		= trim( $this->input->post('nombre', 		TRUE) );
			$apellido 		= trim( $this->input->post('apellido', 		TRUE) );
			$email 			= trim( $this->input->post('email', 		TRUE) );
			$telefono 		= trim( $this->input->post('telefono', 		TRUE) );
			$direccion 		= trim( $this->input->post('direccion',		TRUE) );
			$cp 			= trim( $this->input->post('cp', 			TRUE) );
			$id_servicio 	= trim( $this->input->post('servicio_id', 	TRUE) );
			$subtotal 		= trim( $this->input->post('subtotal', 		TRUE) );
			$imp 			= trim( $this->input->post('imp', 			TRUE) );
			$total 			= trim( $this->input->post('total', 		TRUE) );
			
			if( strlen($nombre) 	<= 2 || 
				strlen($apellido) 	<= 2 || 
				strlen($email) 		<= 2 || 
				strlen($telefono) 	<= 2 || 
				strlen($direccion) 	<= 2 || 
				strlen($cp) 		<= 2 ||
				!is_numeric($id_servicio) 	||
				!is_numeric($subtotal)		||
				!is_numeric($imp) 			||
				!is_numeric($total) )
			{
				echo "<p>Formato del mensaje inválido.</p>";
			}else 
			{
				log_message('debug', "cargaré modelos");
				$this->load->model('clientes_m');
				log_message('debug', "clientes_m");
				$this->load->model('pedidos_m');												
				log_message('debug', "voy a registrar");
				if( ($id_cliente = $this->clientes_m->registrar( $email, $nombre, $apellido, $telefono, $direccion, $cp )) != false )
				{
				log_message('debug', "registre cliente");
					if( ($id_pedido = $this->pedidos_m->registrar( $id_cliente, $id_servicio, $subtotal, $imp, $total )) != false ) 
					{
					log_message('debug', "registre pedido");
						$this->session->set_userdata( 'id_orden', $id_pedido);
						$this->session->set_userdata( 'id_cliente', $id_cliente);
						$this->session->set_userdata( 'nombre', $nombre );
						$this->session->set_userdata( 'apellido', $apellido );
						$this->session->set_userdata( 'membresia', $nombre[0].$apellido[0].$id_pedido );
						
						/*TPV post fields*/
						$data['Ds_Merchant_MerchantName'] 		= $this->config->item('Ds_Merchant_MerchantName');
						$data['Ds_Merchant_MerchantCode'] 		= $this->config->item('Ds_Merchant_MerchantCode');
						$data['Ds_Merchant_Terminal'] 			= $this->config->item('Ds_Merchant_Terminal');
						$data['Ds_Merchant_Order']				= str_pad( $id_pedido, 4, "0", STR_PAD_LEFT );
						$data['Ds_Merchant_Amount']				= str_replace( '.', '', str_replace( ',', '', $this->cart->format_number( $this->cart->total()  ) ) );
						$data['Ds_Merchant_Currency'] 			= $this->config->item('Ds_Merchant_Currency');
						$data['Ds_Merchant_TransactionType'] 	= "0";
						$data['Ds_Merchant_MerchantSignature'] 	= sha1( $data['Ds_Merchant_Amount'].$data['Ds_Merchant_Order'].$data['Ds_Merchant_MerchantCode'].$data['Ds_Merchant_Currency'].$data['Ds_Merchant_TransactionType'].$this->config->item('tpv_key')  );
						
						$data['id_cliente'] 					= $id_cliente;
						$data['nombre'] 						= $nombre;
						
						$this->load->view( 'compra_2', $data );
					}
				}else
				{				
					echo "<p>Error procesando la orden; por favor, inténtelo más tarde.</p>";
				}
			}
		}
	}
	
	public function reg_notif_tpv()
	{
		$this->load->helper(array('form', 'url'));		
	}
	
	public function aut_aceptada()
	{
		$this->load->model( 'pedidos_m' );		
		
		if( $this->pedidos_m->reg_pago_aceptado( $this->session->userdata('id_orden'), $this->session->userdata('id_cliente') ) )
		{
			$data['nombre'] = $this->session->userdata('nombre')." ".$this->session->userdata('apellido');
			$data['plan'] 	= $this->session->userdata('descripcion');
			$data['codigo'] = $this->session->userdata('membresia');
			
			$this->load->view( 'compra_3', $data );
			
			$this->cart->destroy();			
		}else {
			header( "Location: ".base_url() );
		}
	}
	
	public function aut_rechazada()
	{
		$this->load->model( 'pedidos_m' );
		
		if( $this->pedidos_m->reg_pago_rechazado( $this->session->userdata('id_orden'), $this->session->userdata('id_cliente') ) )
		{
			$data['nombre'] = $this->session->userdata('nombre');
			$data['Ds_Merchant_MerchantName'] 		= $this->config->item('Ds_Merchant_MerchantName');
			$data['Ds_Merchant_MerchantCode'] 		= $this->config->item('Ds_Merchant_MerchantCode');
			$data['Ds_Merchant_Terminal'] 			= $this->config->item('Ds_Merchant_Terminal');
			$data['Ds_Merchant_Order']				= str_pad( $this->session->userdata('id_orden'), 4, "0", STR_PAD_LEFT );
			$data['Ds_Merchant_Amount']				= str_replace( '.', '', str_replace( ',', '', $this->cart->format_number( $this->cart->total()  ) ) );
			$data['Ds_Merchant_Currency'] 			= $this->config->item('Ds_Merchant_Currency');
			$data['Ds_Merchant_TransactionType'] 	= "0";
			$data['Ds_Merchant_MerchantSignature'] 	= sha1( $data['Ds_Merchant_Amount'].$data['Ds_Merchant_Order'].$data['Ds_Merchant_MerchantCode'].$data['Ds_Merchant_Currency'].$data['Ds_Merchant_TransactionType'].$this->config->item('tpv_key')  );			
			
			$this->load->view( 'compra_4', $data );
		}else {
			echo "Error";
		}
	}
	
	public function imp_carnet()
	{
		$this->load->helper(array('dompdf', 'file'));
		// page info here, db calls, etc.     
		$data['nombre'] = $this->session->userdata('nombre')." ".$this->session->userdata('apellido');
		$data['plan'] 	= $this->session->userdata('descripcion');
		$data['codigo'] = $this->session->userdata('membresia');
		$html = $this->load->view('membresia_tarjeta', $data, true);
		pdf_create($html, 'membresia');
		//$this->load->view('membresia_tarjeta', $data);
		
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */