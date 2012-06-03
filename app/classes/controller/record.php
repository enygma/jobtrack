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
		$query = Model_Record::find()->limit(10)->order_by('updated_at','desc')->get();

		$records = array();
		foreach ($query as $r) {
			$records[] = array(
				'full_name' => $r->full_name,
				'id' => $r->id
			);
		}

		$this->response($records);
	}

	public function post_index()
	{
		$content = self::getRequest();

		error_log(print_r($content,true));
		error_log(print_r(get_object_vars($content),true));

		$properties = array_keys(get_object_vars($content));

		foreach($properties as $prop) {
			$data[$prop] = $content->$prop;
		}

		//$fullName = $content->full_name;
		error_log('posting! '.$fullName);

		// $data = array(
		// 	"full_name" => $content->full_name
		// );

		$record = new Model_Record($data);
		$record->save();
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