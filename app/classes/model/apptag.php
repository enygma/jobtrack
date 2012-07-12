<?php

class Model_Apptag extends \Orm\Model
{
    protected static $_table_name = 'tags';
    protected static $_properties = array(
        'id',
        'record_email'  => array(
            'data_type'  => 'varchar',
            'label'      => 'Email Address',
            'validation' => array('required')
        ),
        'tag'  => array(
            'data_type'  => 'varchar',
            'label'      => 'Tag',
            'validation' => array('required')
        ),
    );

    protected static $_belongs_to = array(
        'record' => array(
            'key_from'  => 'record_email',
            'key_to'    => 'email',
            'model_to'  => 'Model_Record'
        )
    );

    public static function remove($email,$tag=null)
    {
        $found = Model_Tag::find()->where('record_email', $email);
        if ($tag !== null) {
            $found = $found->where('tag', $tag);
        }
        $found = $found->get();
        foreach ($found as $tagRecord) {
            $tagRecord->delete();
        }
    }
}
