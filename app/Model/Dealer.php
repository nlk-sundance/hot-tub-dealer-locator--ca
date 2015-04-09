<?php

class Dealer extends AppModel
{
    var $uses = array("Country");
    var $displayField = 'name';
    var $useTable = 'dealers';
    public $actsAs = array('Containable');
    
    var $validate = array(
        'name' => array(
            //'required' => TRUE,
            'rule' => 'notEmpty',
            'message' => 'Name is required.'
        ),
        'slug' => array(
            array(
                'rule' => array('uniqueSlug'),
                'message' => 'A unique slug per state is required.'
            ),
            array(
                'rule' => array('custom', '/^[\S]*$/'),
                'message' => 'Please enter a slug with no spaces.'
            )
        ),
        'address1' => array(
            //'required' => TRUE,
            'rule' => 'notEmpty',
            'message' => 'Address is required.'
        ),
        'city' => array(
            //'required' => TRUE,
            'rule' => array('custom', '/^[A-z0-9 ]+$/'),
            'allowEmpty' => FALSE,
            'message' => 'Please enter a city consisting of only letters, numbers and spaces. (No punctuations EX: " . , \' - ;)'
        ),
        'zip' => array(
            'rule' => array('checkZip'),
            'message' => 'A valid zip code is required (letters, numbers).'
        ),
        'state_id' => array(
            //'required' => TRUE,
            'rule' => array('custom', '/^[0-9]*$/'),
            'allowEmpty' => FALSE,
            'message' => 'State is required.'
        ),
        'country_id'=> array(
            'rule' => array('notEmpty'),
            //'required' => TRUE,
            'message' => 'Country is required.'
        ),
        'email' => array(
            'rule' => array('email'),
            'allowEmpty' => TRUE,
            'message' => 'Email must be correct.'
        ),
        'phone' => array(
            'rule' => array('custom', '/^[A-z0-9 -]+$/'),
            'allowEmpty' => TRUE,
            'message' => 'A valid Phone number is required (letters, numbers, -).'
        ),
        'published' => array(
            'rule' => array('notEmpty'),
            //'required' => TRUE
        ),
        'approved' => array('rule' => array('notEmpty')),
        'dealer_number' => array(
            'allowEmpty' => FALSE,
            'message' => 'Dealer number is required and must be unique.',
            //'allowEmpty' => TRUE,
            'rule' => array('isDealerNumberUnique')
        ),
        'region_num' => array(
            //'rule' => array('checkRegionNum'),
            'rule' => array('maxLength', 6),
            //array('rule' => array('minLength', 6), 'allowEmpty' => TRUE, 'message' => 'test2'),
            'message' => 'Region Number must be 6 alphanumeric characters long.',
            'allowEmpty' => TRUE,
            'required' => FALSE
        ),
        /*
        'latitude' => array(
            'rule' => array('notEmpty'),
        ),
        'longitude' => array(
            'rule' => array('notEmpty'),
        )
        */
    );
    
    var $belongsTo = array(
        'State' => array(
            'className'  => 'State',
            'conditions' => '',
            'order'      => '',
            'foreignKey' => 'state_id'
        ),
        "Country" => array(
            'className'  => 'Country',
            'conditions' => '',
            'order'      => '',
            'foreignKey' => 'country_id'
        )                               
    );
    
    var $hasOne = array('User' => array('className' => 'User'));
    
    var $hasMany = array(
        'Quote' => array(
            'className' => 'Quote',
        ),
        'Image' => array(
            'className' => 'Image'
        ),
        'Staff' => array(
            'className' => 'Staff'
        )
    );
                     
    var $hasAndBelongsToMany = array(
        'Zipcode' => array(
            'className'  => 'Zipcode',
            'joinTable'  => 'dealers_zipcodes',
            'foreignKey' => 'dealer_id',
            'associationForeignKey'=> 'zipcode_id',
            'conditions' => '',
            'order'      => '',
            'limit'      => '',
            'uniq'       => true,
            'finderSql'  => '',
            'deleteQuery'=> ''
        ),
        'Service' => array()
    );
    
    function uniqueSlug(){
        $check = null;
        if(!empty($this->data['Dealer']['id'])){
            $conditions = array(
                "Dealer.slug" => $this->data['Dealer']['slug'],
                'Dealer.state_id' => $this->data['Dealer']['state_id'],
                'not' => array('Dealer.id' => array($this->data['Dealer']['id'])),
                'or' => array('Dealer.dealer_id <>' => $this->data['Dealer']['id'], 'Dealer.dealer_id IS NULL')
            );
            if(isset($this->data['Dealer']['dealer_id']) && !empty($this->data['Dealer']['dealer_id'])){
                $conditions['not']['Dealer.id'][] = $this->data['Dealer']['dealer_id'];
            }else{
                $dealer_id = $this->field('dealer_id', array('Dealer.id' => $this->data['Dealer']['id']));
                if(!empty($dealer_id)){
                    $conditions['not']['Dealer.id'][] = $dealer_id;
                }
            }
            $check = $this->find('count', array('recursive' => -1, 'conditions' => $conditions));
        }else{
            $check = $this->find('count', array('recursive' => -1, 'conditions' => array("Dealer.slug" => $this->data['Dealer']['slug'], 'Dealer.state_id' => $this->data['Dealer']['state_id'])));
        }
        if (!empty($check)){
            return false;
        }
        return true;
    }
    //check zip for only US or CA; Any other country, no
    function checkZip(){
        if($this->data['Dealer']['country_id'] == 1 && (!is_numeric($this->data['Dealer']['zip']) || strlen($this->data['Dealer']['zip']) != 5)){
            return false;
        }elseif($this->data['Dealer']['country_id'] == 3 && strlen($this->data['Dealer']['zip']) != 6){ 
            return false;
        }
        return true;
    }
    
    function addZip ($id, $zip){
        if ($id && $zip){
            $this->query("DELETE FROM dealers_zipcodes WHERE dealer_id = $id AND zipcode_id = '$zip'");
            $this->query("INSERT INTO dealers_zipcodes (dealer_id, zipcode_id, zipcode) VALUES ($id, '$zip', '$zip')");
            return true;
        }
        return false;
    }
    
    function isDealerNumberUnique(){
        $check = null;
        if(!empty($this->data['Dealer']['id'])){
            $conditions = array(
                "Dealer.dealer_number" => $this->data['Dealer']['dealer_number'],
                'not' => array('Dealer.id' => array($this->data['Dealer']['id'])),
                'or' => array('Dealer.dealer_id <>' => $this->data['Dealer']['id'], 'Dealer.dealer_id IS NULL')
            );
            if(isset($this->data['Dealer']['dealer_id']) && !empty($this->data['Dealer']['dealer_id'])){
                $conditions['not']['Dealer.id'][] = $this->data['Dealer']['dealer_id'];
            }else{
                $dealer_id = $this->field('dealer_id', array('Dealer.id' => $this->data['Dealer']['id']));
                if(!empty($dealer_id)){
                    $conditions['not']['Dealer.id'][] = $dealer_id;
                }
            }
            $check = $this->find('first', array('recursive' => -1, 'conditions' => $conditions));
        }else{
            $check = $this->find('first', array('recursive' => -1, 'conditions' => array("Dealer.dealer_number" => $this->data['Dealer']['dealer_number'])));
        }
        if (!empty($check)){
            return false;
        }
        return true;
    }
    /*
    function checkRegionNum(){
        $length = strlen($this->data['Dealer']['region_num']);
        if($length > 6){
            return false;
        }
        return true;
    }
*/
}
?>
