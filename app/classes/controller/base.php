<?php

class Controller_Base extends Controller_Hybrid
{
	protected static $_request = null;
	protected static $_headers = null;

	public function router($resource,array $arguments)
	{
		// because Fuel reads from the php://input stream...
		self::$_request = $this->_parseRequest();

		parent::router($resource,$arguments);
	}

	public function _parseRequest()
	{
		$content 	    = file_get_contents('php://input');
		$contentType    = \Input::server('CONTENT_TYPE');
		self::$_headers = apache_request_headers();

		// try to interpret the content
		switch($contentType) {
			case 'application/json':
				$content = @json_decode($content);
				break;
		}

		return $content;
	}

	public function _parseErrors($ex)
	{
		error_log('validation failed');
		error_log($ex->getMessage());

		$errorFields = array_keys($ex->get_fieldset()->error());
		$errors      = array();
		$messages    = explode('||',$ex->getMessage());

		foreach($errorFields as $index => $fieldName) {
			$errors[$fieldName] = $messages[$index];
		}
		//error_log('ERRORS: '.print_r($errors,true));
		return array('errors' => $errors);
	}

	public static function getRequest()
	{
		return self::$_request;
	}

	public static function getHeaders($headerName=null)
	{
		return ($headerName !== null && isset(self::$_headers[$headerName]))
			? self::$_headers[$headerName] : self::$_headers;
	}
}

?>