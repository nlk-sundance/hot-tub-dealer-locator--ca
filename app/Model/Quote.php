<?php

class Quote extends AppModel
{
    public $validate = array(
        'quote' => array(
            'rule' => array('maxLength', 330),
            'message' => 'The quotes must be no more than 330 characters',
            'allowEmpty' => TRUE
        ),
    );
}

?>