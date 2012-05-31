<?php

class Model_Record extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'full_name' => array(
			'data_type'  => 'varchar',
			'label' 	 => 'Full Name',
			'validation' => array('required')
		)
	);
	protected static $_table_name = 'records';
}

?>