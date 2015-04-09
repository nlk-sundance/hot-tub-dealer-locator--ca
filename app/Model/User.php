<?php

class User extends AppModel
{
    var $validate = array(
        'username' => array(
            'required' => TRUE,
            'rule' => 'isUnique',
            'message' => 'Username is required and must be unique.'
        ),
        'password' => array(
            'required' => TRUE,
            'rule' => 'notEmpty',
            'message' => 'Password is required.'
        ),/*
        'firstname' => array(
            'required' => TRUE,
            'rule' => 'notEmpty',
            'message' => 'First Name is required.'
        ),
        'lastname' => array(
            'required' => TRUE,
            'rule' => 'notEmpty',
            'message' => 'Last Name is required.'
        ),*/
        'email' => array(
            'rule' => array('email'),
            'allowEmpty' => TRUE,
            'message' => 'Email must be correct.'
        ),
    );
    var $belongsTo = array('Group');
/*	var $hasAndBelongsToMany = array('Group' =>
                               array('className'  => 'Group',
                                     'joinTable'  => 'groups_users',
                                     'foreignKey' => 'group_id',
                                     'associationForeignKey'=> 'user_id',
                                     'conditions' => '',
                                     'order'      => '',
                                     'limit'      => '',
                                     'uniq'       => true,
                                     'finderSql'  => '',
                                     'deleteQuery'=> '',
                               )
                               );*/
}

?>