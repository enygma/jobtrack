<?php

class Controller_Positions extends Controller_Base
{
	public function action_index($positionId=null)
	{
		$data = array();
		if ($positionId !== null) {
			$data['position'] = Model_Position::find($positionId);
		}
		$this->template->content = View::forge('positions/index',$data);
	}

	public function action_recent()
	{
		$data = array();
		$this->template->content = View::forge('positions/recent',$data);
	}

	public function action_edit()
	{
		$data = array();
		$this->template->content = View::forge('positions/edit',$data);
	}

	public function action_view($positionId)
	{
		error_log('VIEW');
		$position = Model_Position::find($positionId);
		$data 	  = array('position' => $position);
		$this->template->content = View::forge('positions/view',$data);	
	}

	public function get_index()
	{
		$pos     = Model_Position::find()->limit(10)->order_by('created_at','desc')->get();
		$results = array();

		// not sure what it is that makes this necessary...Fuel response handling?
		foreach($pos as $p) {
			$results[] = $p;
		}

		$this->response($results);
	}

	public function put_index()
	{
		error_log('PUT');
		$content = self::getRequest();
		error_log(print_r($content,true));

		$position = new Model_Position((array)$content);
		try {
			$position->save();
		} catch(\Exception $e) {
			$this->response($this->_parseErrors($e),400);
		}
	}
	public function post_index()
	{
		error_log('POST');
		$content = self::getRequest();
		error_log(print_r($content,true));
	}
	public function delete_index($positionId=null)
	{

	}
}

?>