<?php

class Controller_Index extends Controller_Base
{
	public function get_recent()
	{
		// get the recent jobs and applicants added
		$this->response(array(
			'positions'  => Model_Position::recent(),
			'applicants' => Model_Record::recent()
		));
	}

	public function action_index()
	{
		$data = array();
		$this->template->content = View::forge('index/index',$data);
	}
}

?>
