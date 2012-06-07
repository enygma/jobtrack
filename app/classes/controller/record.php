<?php

class Controller_Record extends Controller_Rest
{
	private static $_request = null;

	public function router($resource,array $arguments)
	{
		// because Fuel reads from the php://input stream...
		self::$_request = $this->_parseRequest();

		parent::router($resource,$arguments);
	}

	private function _parseRequest()
	{
		$content 	 = file_get_contents('php://input');
		$contentType = \Input::server('CONTENT_TYPE');

		// try to interpret the content
		switch($contentType) {
			case 'application/json':
				$content = @json_decode($content);
				break;
		}

		return $content;
	}

	private static function getRequest()
	{
		return self::$_request;
	}

	public function get_index()
	{
		$query = Model_Record::find()->limit(10)->order_by('updated_at','desc')->related('tags')->get();

		$records = array();
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

		$this->response($records);
	}

	public function post_index()
	{
		$content = self::getRequest();

		// error_log(print_r($content,true));
		// error_log(print_r(get_object_vars($content),true));

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

		error_log('DATA: '.print_r($data,true));

		$record = new Model_Record($data);
		try {
			$r = $record->save();
			error_log(print_r($record,true));

			// if we have tags, add them too
			if (count($tags) > 0) {
				foreach ($tags as $t) {
					$data = array('record_email'=>$record->email,'tag'=>$t);
					$tag = new Model_Tag($data);
					$tag->save();
				}
			}

		} catch (Orm\ValidationFailed $e) {
			error_log('validation failed');
			error_log($e->getMessage());

			$errorFields = array_keys($e->get_fieldset()->error());

			$errors   = array();
			$messages = explode('||',$e->getMessage());

			foreach($errorFields as $index => $fieldName) {
				$errors[$fieldName] = $messages[$index];
			}
			error_log('ERRORS: '.print_r($errors,true));

			$this->response(array('errors' => $errors),400);
		}
	}

	public function put_index($recordId)
	{
		// we want to use the ID from the PUT data, not the $recordId
		$content = self::getRequest();

		// update the record
		$record = Model_Record::find($content->id);
		unset($content->id);

		foreach (get_object_vars($content) as $index => $value) {
			$record->$index = $value;
		}
		$record->save();
	}

	public function get_search()
	{
		$query   = \Input::get('query');
		$results = Model_Record::search($query);

		$this->response($results);
	}

}

?>