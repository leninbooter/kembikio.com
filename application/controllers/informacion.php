<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Informacion extends CI_Controller {

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
	public function servicios()
	{
		$data['title'] = 'Kembikio';
		$this->load->view('header', $data);
		$this->load->view('servicios');
		$this->load->view('footer');
		//$this->load->view('welcome_message');
	}
	
	public function planes()
	{
		$data['title'] = 'Planes de Servicio';
		$this->load->view('header', $data);
		$this->load->view('planes');
		$this->load->view('footer');
	}
	
	public function acercade()
	{
		$data['title'] = 'Acerca de Kembikio';
		$this->load->view('header', $data);
		$this->load->view('acerca-de');
		$this->load->view('footer');
	}
	public function contactanos()
	{
		$data['title'] = 'Contáctanos';
		$this->load->view('header', $data);
		$this->load->view('contactanos');
		$this->load->view('footer');
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
	
	public function comentarios_valido( $valor )
	{
		if( preg_match( '/^[A-Za-z0-9_.,\s]{5,2000}$/', $valor ) == 1 )
		{
			return true;
		}else {
			$this->form_validation->set_message('comentarios_valido', 'Debe introducir algun comentario y este, solo puede contener letras números y los signos _ , y .');
			return false;
		}
	}
	
	public function enviar_coments()
	{
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		
		$config = array(
               array(
                     'field'   => 'asunto',
                     'label'   => 'Asunto',
                     'rules'   => 'trim|xss_clean|required'
                  ),
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
                     'rules'   => 'trim|required|valid_email|max_length[200]'
                  ),
			   array(
					'field'		=> 'empresa',
					'label'		=> 'Empresa',
					'rules'		=> 'trim|xss_clean|max_length[150]|alpha'
			   ),
			   array(
					'field'		=> 'cargo',
					'label'		=> 'Cargo',
					'rules'		=> 'trim|xss_clean|max_length[150]|alpha'
			   )
            );

		$this->form_validation->set_rules($config);
		$this->form_validation->set_rules('telefono', 'Teléfono', 'telefono_valido');
		$this->form_validation->set_rules('comentarios', 'Comentarios', 'comentarios_valido');
		
		$this->form_validation->set_message('required', 'El campo de %s es obligatorio.');
		$this->form_validation->set_message('alpha', 'El campo de %s solo puede contener letras.');
		
		if ( !$this->form_validation->run() )
		{
			echo validation_errors();
		}
		else
		{
			$asunto 		= trim( $this->input->post('asunto', 		TRUE) );
			$nombre 		= trim( $this->input->post('nombre', 		TRUE) );
			$apellido 		= trim( $this->input->post('apellido', 		TRUE) );
			$email 			= trim( $this->input->post('email', 		TRUE) );
			$telefono 		= trim( $this->input->post('telefono', 		TRUE) );
			$empresa 		= trim( $this->input->post('empresa',		TRUE) );
			$cargo 			= trim( $this->input->post('cargo', 		TRUE) );
			$comentarios 	= trim( $this->input->post('comentarios', 	TRUE) );
			
			if( strlen($asunto) 	<= 2 || 
				strlen($nombre) 	<= 2 || 
				strlen($apellido) 	<= 2 || 
				strlen($email) 		<= 2 || 
				strlen($telefono) 	<= 2 || 
				( strlen($empresa) 	<= 2 && strlen($empresa) > 0 ) || 
				( strlen($cargo) 	<= 2 && strlen($cargo) > 0	 ) || 
				strlen($comentarios) <= 2 )
			{
				echo "<p>El mensaje no puede ser enviado. El formato de los datos es inválido.</p>";	
			}else
			{
				$this->load->model('contactos');
				if( $this->contactos->enviar_comentarios(  $email, $asunto, $nombre, $apellido, $telefono, $empresa, $cargo, $comentarios) )
				{
					echo "<p>Enviado <img src=\"".base_url('assets/imagenes/checked_verde.png')."\"></p>";
				}else {
					echo "<p>El mensaje no pudo ser enviado; por favor, inténtelo de nuevo.</p>";
				}
			}			
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */