<?php

class Controller_Index extends Controller_Template
{
	public function action_index()
	{
		$data = array();

		$data['records'] = array();
		$data['records'][] = array(
			'id' 		=> 1,
			'full_name' => 'Chris Cornutt',
			'added' 	=> time(),
			'location' 	=> 'Dallas, Tx'
		);

		$this->template->content = View::forge('index/index',$data);
	}
}

?>
