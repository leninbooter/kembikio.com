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
		$data['title'] = 'Acerca de Kembikio';
		$this->load->view('header', $data);
		$this->load->view('contactanos');
		$this->load->view('footer');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */