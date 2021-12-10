<?php

/**
 * 
 */
class _MonitoringUsers extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('MLogin', 'DbLogin');
    $this->load->model('MMahasiswa', 'MMahasiswa');
		$this->load->model('MUserspot', 'MUserspot');
		$this->load->model('MProfile', 'MProfile');

  }

  public function index()
  {
    $data = $this->DbLogin->show();
    if ($this->mikapi->Connect($data['ip'], $data['username'], $data['password']) != "Connected") {
      redirect(site_url('Login'));
    }
    $this->indexOri();

  }


  public function indexOri()
  {
		$d['UsersActive'] =  	$this->ambilUserActiveDetails();
    $template = array(
      'menu' => $this->load->view('MENU/menu', '', TRUE),
      'judul' => 'Monitoring & Control Users',
      'konten' => $this->load->view('D_Monitor/index', $d, TRUE),
    );
    $this->parser->parse('template/template2', $template);
	
  }
	public function ambilUserActiveDetails()
	{

		$datalogin = $this->DbLogin->show();
		$Code['command'] = "/ip/hotspot/active/print"; //perntah
		$data= $this->mikapi->Read($Code, $datalogin);
		$jsonData= json_decode($data, true);

		// for($i=0;$i< count($jsonData);$i++){
		// 	// echo count($jsonData[$i]);
		// 	var_dump($jsonData[$i]);
		// 	// echo $jsonData[$i]["server"];
		// }
	return $jsonData;
	}
	

}