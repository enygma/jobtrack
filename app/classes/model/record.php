<?php

class Model_Record extends \Orm\Model
{
    protected static $_properties = array(
        'id',
        'full_name' => array(
            'data_type'  => 'varchar',
            'label'      => 'Full Name',
            'validation' => array('required')
        ),
        'email' => array(
            'data_type'  => 'varchar',
            'label'      => 'Email Address',
            'validation' => array('required','valid_email','unique')
        ),
        'location' => array(
            'data_type'  => 'varchar',
            'label'      => 'Location',
            'validation' => array('required')
        ),
        'created_at',
        'updated_at'
    );
    protected static $_table_name = 'records';

    protected static $_has_many = array(
        'tags' => array(
            'key_from' => 'email',
            'model_to' => 'Model_Apptag',
            'key_to'   => 'record_email'
        )
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
            'events' => array('before_save')
        )
    );

    public static function search($query)
    {
        $result = Model_Record::find()
            ->where(
                DB::expr('lower(full_name)'), 'like', "%".strtolower($query)."%"
            )
            ->related('tags');

        $found  = array();

        foreach ($result->get() as $res) {
            $found[] = $res->to_array();
        }

        return $found;
    }

    public static function remove($userEmail)
    {
        $result = Model_Tag::find()->where('record_email', $userEmail);
        return $result;
    }

    /**
     * Checks to ensure that the email address we were given is unique
     */
    public static function _validation_unique($data)
    {
        $found = Model_Record::find()->where('email', $data)->get_one();
        return ($found == null) ? true : false;
    }

    public static function recent($days=30)
    {
        $found = Model_Record::find()
            ->where('created_at', '>', strtotime('-'.$days.' days'))
            ->order_by('created_at', 'desc')
            ->get();
        return $found;
    }
}
