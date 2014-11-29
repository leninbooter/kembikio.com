<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

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
	public function index()
	{
		$data['title'] = 'Kembikio';
		$this->load->view('header', $data);
		$this->load->view('welcome');
		$this->load->view('footer');
		
		$this->load->library('session');		
			
		$this->session->set_userdata('moneda_cod_local', '1');
		$this->session->set_userdata('moneda_cod', 'EUR');
		$this->session->set_userdata('moneda_cod_bank', '978');
		$this->session->set_userdata('moneda_simbolo', '€');
		$this->session->set_userdata('moneda_descripcion_local', 'Euros');
		
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */