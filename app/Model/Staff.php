<?php

class Staff extends AppModel
{
    public $validate = array(
        'name' => array(
            'rule' => 'notEmpty',
            'allowEmpty' => FALSE,
            'message' => 'Please enter a name'
        ),
    );
}

?>