<?php

class Model_Tag extends \Orm\Model
{
	protected static $_table_name = 'tags';
	protected static $_properties = array(
		'id',
		'record_email'  => array(
			'data_type'  => 'varchar',
			'label' 	 => 'Email Address',
			'validation' => array('required')
		),
		'tag'  => array(
			'data_type'  => 'varchar',
			'label' 	 => 'Tag',
			'validation' => array('required')
		),
	);

	protected static $_belongs_to = array(
		'record' => array(
			'key_from' 	=> 'record_email',
			'key_to' 	=> 'email',
			'model_to' 	=> 'Model_Record'
		)
	);
}

?>