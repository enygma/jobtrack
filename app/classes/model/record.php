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

	public static function search($query)
	{
		$result = Model_Record::find()->where(DB::expr('lower(full_name)'),'like',"%".strtolower($query)."%");
		$found  = array();

		foreach ($result->get() as $res) {
			$found[] = $res->to_array();
		}

		return $found;
	}
}

?>