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

	public function action_edit($editId)
	{
		$app = Model_Record::find()->where('id',$editId)->related('tags')->get_one();
		error_log(print_r($app,true));

		$data = array('applicant' => $app);
		
		$this->template->content = View::forge('applicants/add',$data);
	}
}
?>