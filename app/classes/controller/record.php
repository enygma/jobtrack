<?php

class Controller_Record extends Controller_Base
{
	public function get_index($recordId=null)
	{
		$records = array();
		$query   = Model_Record::find()->limit(10)->order_by('updated_at','desc')->related('tags');

		// if we're given an ID, find it
		if ($recordId !== null) {
			$query = $query->where('id',$recordId);
		}
		$query = $query->get();

		foreach ($query as $r) {

			$tagList = array();
			foreach($r->tags as $tag) {
				$tagList[] = $tag;
			}

			$records[] = array(
				'full_name' => $r->full_name,
				'id' 		=> $r->id,
				'email' 	=> $r->email,
				'location'  => $r->location,
				'tags'		=> $tagList
			);
		}

		if (count($records) == 1) {
			$records = $records[0];
		}

		$this->response($records);
	}

	public function put_index()
	{
		$tags 	 = array();
		$content = self::getRequest();
		error_log(print_r($content,true));

		if (isset($content->tags)) {
			foreach(explode(',',$content->tags) as $tag){
				$tags[] = trim($tag);
			}
		}

		// create the record
		$record = new Model_Record((array)$content);
		try {
			$record->save();
		} catch (\Exception $e) {
			$this->response($this->_parseErrors($e),400);
		}

		if (count($tags) > 0) {
			foreach ($tags as $tag) {
				$t = new Model_Apptag(array(
					'record_email' => $content->email,
					'tag' 		   => $tag
				));
				try {
					$t->save();
				} catch (\Exception $e) {
					$this->response($this->_parseErrors($e),400);
				}
			}
		}
	}

	public function post_index($recordId)
	{
		$content = self::getRequest();

		$properties = array_keys(get_object_vars($content));
		$tags 		= array();

		foreach($properties as $prop) {
			if ($prop == 'tags') {
				$t = explode(',',trim($content->$prop));
				foreach ($t as $tag) {
					$tags[] = trim($tag);
				}
			} elseif ($prop !== 'record_id') {
				$data[$prop] = $content->$prop;
			}
		}

		try {
			// delete a user's current tags so we can start fresh
			Model_Apptag::remove($data['email']);

			// find the record to update
			$record = Model_Record::find($data['id']);

			if ($record == null) {
				throw new \Exception('Record not found');
			}

			unset($data['id']);
			foreach($data as $column => $value) {
				$record->$column = $value;
			}
			$record->save();

			// if we have tags, add them too
			if (count($tags) > 0) {
				foreach ($tags as $t) {
					$data = array('record_email'=>$record->email,'tag'=>$t);
					$tag = new Model_Apptag($data);
					$tag->save();
				}
			}

		} catch (\Exception $e) {
			$this->response($this->_parseErrors($e),400);
		}
	}

	public function get_search()
	{
		$query   = \Input::get('query');
		$results = Model_Record::search($query);

		$this->response($results);
	}

	/**
	 * Get users (applicants) tagged with a value
	 * 
	 * @param string $tag Tag to search on
	 * 
	 * @return void
	 */
	public function get_tagged($tags)
	{
		$tags = explode('+',$tags);
		
		$app = Model_Record::find()->related('tags')
			->where('tags.tag','in',$tags)->get();

		$appList = array();
		foreach($app as $a) {
			$appList[] = $a;
		}
		error_log(print_r($appList,true));

		$this->response($appList);
	}

}

?>