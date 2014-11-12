<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends CI_Controller
{
	public function Index()
	{	
		$data['title'] = 'Kembikio';
		$this->load->view('header');
		$this->load->view('footer');
	}
}