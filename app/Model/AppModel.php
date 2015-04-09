<?php
/**
 * Application model for CakePHP.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {
	function invalidFields ($data = array())
	{
    	if(!$this->beforeValidate())
	    {
    	    return false;
	    }
 	
    	if (!isset($this->validate) || !empty($this->validationErrors))
	    {
    	    if (!isset($this->validate))
        	{
            	return true;
	        }
    	    else
        	{
            	return $this->validationErrors;
	        }	
    	}
 
	    if (isset($this->data))
    	{
        	$data = array_merge($data, $this->data);
	    }
 	
    	$errors = array();
	    $this->set($data);
 
    	foreach ($data as $table => $field)
    	{
        	foreach ($this->validate as $field_name => $validators)
        	{
          		foreach($validators as $validator)
            	{
                	if (isset($validator[0]))
	                {
    	                if (method_exists($this, $validator[0]))
        	            {
            	            if (isset($data[$table][$field_name]) && !call_user_func(array(&$this, $validator[0])))
                	        {
                    	        if (!isset($errors[$field_name]))
                        	    {
                            	    $errors[$field_name] = isset($validator[1]) ? $validator[1] : 1;
	                            }	
    	                    }
        	            }
            	        else
                	    {
                    	    if (isset($data[$table][$field_name]) && !preg_match($validator[0], $data[$table][$field_name]))
                        	{
                            	if (!isset($errors[$field_name]))
			                    {
            	                    $errors[$field_name] = isset($validator[1]) ? $validator[1] : 1;
                	            }
                    	    }
	                    }	
    	            }
        	    }
	        }
    	}
	    $this->validationErrors = $errors;
    	return $errors;
	}	
}
