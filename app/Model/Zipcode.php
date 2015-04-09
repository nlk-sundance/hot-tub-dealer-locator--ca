<?php

class Zipcode extends AppModel
{
    #check to see if zipcode exists in zipcodes table
    function getZipCode ($zip, $isCA=false) 
    {
        $data = null;
        $zip = trim(preg_replace('/\s+/', '', $zip));#remove spaces in zipcode
        if($isCA){
            if(strlen($zip) < 3)
                return null;
            $data = $this->find('all', array('conditions' => array('zipcode LIKE' => $zip.'%')));
        }else{
            $data = $this->find('first', array('conditions' => array("zipcode" => $zip)));
        }
        return $data;
    }
}

?>