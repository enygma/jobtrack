<?php

class Controller_Applicants extends Controller_Base
{
	public function action_index()
	{
		$data = array();
		$this->template->content = View::forge('applicants/index',$data);
	}

	public function action_add()
	{
		$data = array();
		$this->template->content = View::forge('applicants/add',$data);
	}

}
?>