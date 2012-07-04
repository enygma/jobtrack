<?php

class Model_Position extends \Orm\Model
{
	public static $_table_name = 'position';

	public static $_properties = array(
		'id',
		'title' => array(
			'data_type'  => 'varchar',
			'label' 	 => 'Position Title',
			'validation' => array('required')
		),
		'location' => array(
			'data_type'  => 'varchar',
			'label' 	 => 'Position Location',
			'validation' => array('required')
		),
		'summary' => array(
			'data_type'  => 'text',
			'label' 	 => 'Position Summary',
			'validation' => array('required')
		),
		'contact_name' => array(
			'data_type'  => 'varchar',
			'label' 	 => 'Position Contact Name',
			'validation' => array('required')
		),
		'contact_email' => array(
			'data_type'  => 'varchar',
			'label' 	 => 'Position Contact Email',
			'validation' => array('valid_email')
		),
		'contact_phone' => array(
			'data_type'  => 'varchar',
			'label' 	 => 'Position Contact Phone',
			'validation' => array()
		),
		'created_at',
		'updated_at'
	);

	protected static $_observers = array(
	    'Orm\\Observer_CreatedAt' => array(
	        'events' => array('before_insert'),
	        'property' => 'created_at',
	    ),
	    'Orm\\Observer_UpdatedAt' => array(
	        'events' => array('before_save'),
	        'property' => 'updated_at',
	    ),
	    'Orm\\Observer_Validation' => array(
	    	'events' => array('before_save','before_insert')
	    )
	);

	public static function recent($days=30)
	{
		$found = Model_Position::find()->where('created_at','>',strtotime('-'.$days.' days'))->get();
		return $found;
	}
}

?>