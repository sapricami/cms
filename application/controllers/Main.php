<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
		$this->load->helper('bootstrap');
		$this->data['site_name']=$this->config->item('site_name');
		$this->data['navbar_array']=$this->common->navbar_array();
		$this->data['cms_options']=$this->common->cms_options();		
	}

	public function index()
	{	
		$this->data['page_data']=array(
			'meta_title' => 'Sapricami CMS',
			'meta_description' => '',
			'meta_keywords' => '',
		);
		$this->data['current_slug']='home';
		$this->data['slider'] = $this->common->partial('slider',$this->data);
		$this->common->layout('home',$this->data);		
	}
	public function pages($page_slug)
	{
		$this->data['current_slug']=$page_slug;
		$sql_page = $this->db->get_where('cms_pages',array('page_slug'=>$page_slug));
		$this->data['page_data']=$sql_page->row_array();
		
		if(isset($this->data['page_data'])&&($this->data['page_data']['page_active']=='1')){
			$this->common->layout('page',$this->data);	
		}else{
			$this->error_page();
		}
	}
	public function error_page()
	{
		$this->data['page_data']=array(
			'meta_title' => 'Error 404 - Page Not Found',
			'meta_description' => '',
			'meta_keywords' => '',
		);
		$this->common->layout('404',$this->data);		
	}

}

/* End of file Main.php */
/* Location: ./application/controllers/Main.php */