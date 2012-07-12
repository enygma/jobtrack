<?php

class Controller_Applicants extends Controller_Base
{
	/**
	 * Action to display the main listing of applicants
	 * 
	 * @return void
	 */
	public function action_index()
	{
		$data = array();
		$this->template->content = View::forge('applicants/index',$data);
	}

	/**
	 * Action to display the "Add User" view (does not handle the adding)
	 *     Puts value into $this->template->content
	 * 
	 * @return void
	 */
	public function action_add()
	{
		$data = array();
		$this->template->content = View::forge('applicants/add',$data);
	}

	/**
	 * Action for editing a user (applicant)
	 *     Puts value into $this->template->content
	 * 
	 * @param int $editId ID of the user to edit
	 * 
	 * @return void
	 */
	public function action_edit($editId)
	{
		$app = Model_Record::find()->where('id',$editId)
			->related('tags')->get_one();

		$data = array('applicant' => $app);
		
		$this->template->content = View::forge('applicants/add',$data);
	}

	/**
	 * Get users (applicants) tagged with a value
	 * 
	 * @param string $tag Tag to search on
	 * 
	 * @return void
	 */
	public function get_tagged($tag)
	{
		$app = Model_Record::find()->related('tags')
			->where('tags.tag',$tag)->get();

		$appList = array();
		foreach($app as $a) {
			$appList[] = $a;
		}

		$this->response(array('applicants'=>$appList));
	}
}
?>