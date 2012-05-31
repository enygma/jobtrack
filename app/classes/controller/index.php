<?php

class Controller_Index extends Controller_Template
{
	public function action_index()
	{
		$data = array();
		$this->template->content = View::forge('index/index',$data);
	}
}

?>
