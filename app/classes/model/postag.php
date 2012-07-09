<?php

class Model_Postag extends \Orm\Model
{
	protected static $_table_name = 'postags';
	protected static $_properties = array(
		'id',
		'position_id' => array(
			'data_type'  => 'int',
			'label' 	 => 'Position ID',
			'validation' => array('required')
		),
		'tag' => array(
			'data_type'  => 'varchar',
			'label' 	 => 'Tag',
			'validation' => array('required')
		)
	);

	protected static $_belongs_to = array(
		'position' => array(
			'key_from' 	=> 'position_id',
			'key_to' 	=> 'id',
			'model_to' 	=> 'Model_Position'
		)
	);
}

?>