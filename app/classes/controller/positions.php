<?php

class Controller_Positions extends Controller_Base
{
	public function action_index($positionId=null)
	{
		$data = array();
		if ($positionId !== null) {
			$data['position'] = Model_Position::find()
				->where('id',$positionId)
				->related('tags')->get_one();
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
		$position = Model_Position::find()->where('id',$positionId)->related('tags')->get_one();
		error_log(print_r($position,true));

		$data 	  = array('position' => $position);
		$this->template->content = View::forge('positions/view',$data);	
	}

	public function get_index($positionId=null)
	{
		error_log('get index');

		$pos     = Model_Position::find()->order_by('created_at','desc')->limit(10);
		if ($positionId !== null) {
			$pos = $pos->where('id',$positionId);
			$results = $pos->get_one();
		} else {
			$pos = $pos->get();

			$results = array();

			// not sure what it is that makes this necessary...Fuel response handling?
			foreach($pos as $p) { $results[] = $p; }
		}

		$this->response($results);
	}

	public function get_tagged($tag)
	{
		// TODO
		// find the positions tagged with the $tag
	}

	public function post_index()
	{
		error_log('POST');
		$content = self::getRequest();
		error_log(print_r($content,true));

		$position = new Model_Position((array)$content);
		try {
			$position->save();
		} catch(\Exception $e) {
			$this->response($this->_parseErrors($e),400);
		}
	}
	public function put_index()
	{
		error_log('PUT');
		$content = self::getRequest();
		error_log(print_r($content,true));

		$tagged = $content->tagged_with;
		$id 	= $content->id;
		unset($content->tagged_with,$content->id,$content->position_id);

		// find the model to update
		$position = Model_Position::find($id);
		if ($position !== null) {
			error_log('updating');

			unset($content->id);
			foreach (get_object_vars($content) as $propName => $propValue) {
				$position->$propName = $propValue;
			}
			error_log(print_r($position,true));

			//$position->tags = array('test');

			try {
				$position->save();
			} catch (\Exception $e) {
				$this->response($this->_parseErrors($e),400);
			}
		}
	}
	public function delete_index($positionId=null)
	{

	}
}

?>