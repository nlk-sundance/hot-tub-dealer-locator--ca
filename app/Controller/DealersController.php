<?php
class DealersController extends AppController
{
    //var $scaffold;
    public $uses = array("Dealer", "State", "Country", "Zipcode", "User", "Group", 'Service');
    var $required_permissions = array(1);
    var $layout = 'admin';
    //public $helpers = array( 'Html', 'Javascript', 'Ajax', 'Time', 'Pagination', 'Form');    
    //public $components = array ('Pagination');
    public $helpers = array( 'Html', 'Time', 'Paginator', 'Form', 'Image.Image', 'Wysiwyg.Wysiwyg');
    public $components = array ('Paginator', 'Session');
    public $us_id = null;
    public $can_id = null;
    public $paginate = array(
        'recursive' => 0,
        'joins' => array(
            array(
                'alias' => 'DealersPending',
                'table' => 'dealers',
                'type' => 'LEFT',
                'conditions' => '`Dealer`.`id` = `DealersPending`.`dealer_id`'
            )
        )
    );

    public function beforeFilter(){
        parent::beforeFilter();
        $this->set('tabOn', 'dealers');
        $this->us_id = $this->Country->field('Country.id', array('Country.name' => 'United States'));
        $this->can_id = $this->Country->field('Country.id', array('Country.name' => 'Canada'));
        $this->set('pending_num', $this->Dealer->find('count', array('conditions' => array('Dealer.dealer_id IS NOT NULL'))));
    }
    
    public function index(){
        $this->checkLogin();
        $this->layout = "admin";
        $query = $this->getQuery(); #calls getQuery() to get $_POST data from index.thtml
        $order = null;
        $direction = null;
        #update the saved query if they submitted the sidebar form
        $saved_query = $this->Session->read('saveQuery');
        if (($saved_query != $query) || (isset($_POST['updateQuery']) && !empty($_POST['updateQuery']) &&  $_POST['updateQuery'] == 1)) #if doing a "Filter By"
        {
            $this->Session->write('saveQuery', $query);
            //$_SESSION['saveQuery'] = $query;
        }
        else #otherwise use the query saved in the session
        {
            //if(empty($_SESSION['saveQuery'])){
            $query = $this->Session->read('saveQuery');
            if(empty($query)){
                $this->Session->write('saveQuery', "Dealer.country_id = ".$this->us_id);
                //$_SESSION['saveQuery'] = "Dealer.country_id = ".$this->us_id;
            }
            $query = $this->Session->read('saveQuery');
            //$query = $_SESSION['saveQuery'];
        }
        if (!empty($query)){
            $this->paginate['conditions'] = $query;
        }
        $this->Paginator->settings = $this->paginate;
        $data = $this->Paginator->paginate('Dealer');
        
        $this->set('data', $data);
        $this->set('countryList', $this->Country->getCountryList()); #generate list of countries
        $this->set('stateList', $this->State->find('list', array('sort' => 'position ASC'))); #generate list of states
    }   
    
    private function getQuery()
    {
        $query = "1 = 1 AND Dealer.dealer_id IS NULL";
        $filter = array();
        $sticky = array('name'=> array('type'=>'string', 'default'=>''), 
                        'email'=>array('type'=>'string', 'default'=>''), 
                        'phone'=>array('type'=>'string', 'default'=>''),    
                        'city'=>array('type'=>'string', 'default'=>''), 
                        'zip'=>array('type'=>'string', 'default'=>''),
                        'state_id'=>array('type'=>'integer', 'default'=>'0'),
                        'published'=>array('type'=>'string', 'default'=>'Y'),
                        'country_id'=>array('type'=>'integer', 'default'=>$this->us_id),
                        'dealer_number'=>array('type'=>'string', 'default'=>''),
                        'pending' => array('type'=>'pending', 'default'=>'')
                        );
        foreach($sticky as $name => $attribs)
        {
            if(isset($this->data['Filter'][$name])) #gets $_POST data of name being searched
            {
                if (!empty($this->data['Filter'][$name]))
                {
                    switch ($attribs['type'])
                    {
                        case 'string':                            
                            $query .= " AND Dealer.$name LIKE '%".addslashes($this->data['Filter'][$name])."%' ";
                            break;
                        case 'integer':
                            $query .= " AND Dealer.$name = ". $this->data['Filter'][$name]. " ";
                            break;
                        case 'pending':
                            if($this->data['Filter'][$name] == 'N'){
                                $query .= " AND DealersPending.id IS NULL";
                            }elseif($this->data['Filter'][$name] == 'Y'){
                                $query .= " AND DealersPending.id IS NOT NULL";
                            }
                            break;
                    }
                }
                $this->Session->write($name, $this->data['Filter'][$name]);
                $filter[$name] = $this->data['Filter'][$name];
            }
            elseif ($this->Session->check($name))
            {
                $val = $this->Session->read($name);
                if(!empty($val)){
                    switch ($attribs['type'])
                    {       
                        case 'string':
                            $query .= " AND Dealer.$name LIKE '%$val%' ";
                            break;
                        case 'integer':
                            $query .= " AND Dealer.$name = $val ";
                            break;
                        case 'pending':
                            if($val == 'N'){
                                $query .= " AND DealersPending.id IS NULL";
                            }elseif($val == 'Y'){
                                $query .= " AND DealersPending.id IS NOT NULL";
                            }
                            break;
                    }         
                }
                $filter[$name] = $val;
            }
            else
            {
                $filter[$name] = $attribs['default'];
            }
        }
        $this->set('filter', $filter);
        
        return $query;
    }
    
    function escape_data ($data){
         if (ini_get('magic_quotes_gpc')){
             $data = stripslashes($data);
         }
         return ($data);
    }
    
    function show($id=null){
        $group_id = $this->checkLogin($id);
        $this->layout = "admin";
        $this->getQuery();
        $showZip = false;
        
        // special case to add new countries
        if (!empty($_POST['addNewCountry'])){
            $cName = addslashes($_POST['countryName']);
            $cAbbr = addslashes($_POST['countryAbbreviation']);
            $position = $this->Country->field('max(`position`)', array()) + 1;
            $country = array('Country'=>array('name'=>$cName, 'abbreviation'=>$cAbbr, 'position'=>$position));
            $this->Country->save($country);
            $data = $this->data;
            $data['Dealer']['country_id'] = $this->Country->getLastInsertID();
            $this->set('data', $data);
        }elseif (empty($this->data)){
            if(empty($id)){
                $data = array(
                    'Dealer'=>array(
                        'id'=>'', 
                        'dealer_number'=>'',
                        'name'=>'', 
                        'address1'=>'', 
                        'address2'=>'', 
                        'city'=>'', 
                        'zip'=>'',
                        'state_id'=>'0', 
                        'country_id'=>$this->us_id, 
                        'email'=>'', 
                        'email_verification'=>'',
                        'phone'=>'',
                        'phone2' => '',
                        'fax'=>'',
                        'website'=>'',
                        'region_num'=>'',
                        'published'=>'',
                        'approved'=>'',
                        'directions'=>'',
                        //'custom_seo_text'=>'',
                        'additional_html'=>'',
                        'additional_html_start'=>'',
                        'additional_html_start_sale'=>'',
                        'additional_html_end'=>'',
                        'url_redirect'=>'',
                        'default_promo'=>0,
                        'about_title' => '',
                        'about_body' => '',
                        'seo_text' => '',
                        'services_text' => '',
                        'staff_text' => '',
                        'hours' => '',
                        'promo_image' => '',
                        'latitude' => '',
                        'longitude' => '',
                        'slug' => ''
                    )
                );
            }else{
                $data = $this->Dealer->find('first', array('recursive' => 0, 'conditions' => array("Dealer.id" => $id)));
                if(empty($data)){
                    if($group_id == 1){
                        $this->redirect('/dealers');
                    }else{
                        $login = $this->Session->read("login");
                        $this->redirect('/dealers/show/'.$login['dealer_id']);
                    }
                }
                //pr($data);
                ///die();
                if(!empty($data['Dealer']['dealer_id'])){
                    $this->copy_cropped_image($data['Dealer']['dealer_id'], $id, 'promo');
                }else{
                    $child_id = $this->Dealer->field('id', array('Dealer.dealer_id' => $id));
                    if(!empty($child_id)){
                        $this->copy_cropped_image($id, $child_id, 'promo');
                    }
                }
                if (empty($data['Dealer']['dealer_id']) &&  $data['Dealer']['country_id'] && ($data['Dealer']['country_id'] == $this->us_id || $data['Dealer']['country_id'] == $this->can_id)){
                    $showZip = true;
                }
                if(!empty($data['Dealer']['additional_html_end'])){
                    $data['Date']['additional_html_end'] = date('M j, Y', $data['Dealer']['additional_html_end']);
                }
                if(!empty($data['Dealer']['additional_html_start'])){
                    $data['Date']['additional_html_start'] = date('M j, Y', $data['Dealer']['additional_html_start']);
                }
                if(!empty($data['Dealer']['additional_html_start_sale'])){
                    $data['Date']['additional_html_start_sale'] = date('M j, Y', $data['Dealer']['additional_html_start_sale']);
                }
            }
            $this->set('data', $data);
        }else{
            $data = $this->data;
            if(!isset($data['Dealer']['dealer_id'])){
                if(isset($data['Dealer']['id']) && !empty($data['Dealer']['id'])){
                    $data['Dealer']['dealer_id'] = $this->Dealer->field('dealer_id', array('Dealer.id' => $data['Dealer']['id']));
                }else $data['Dealer']['id'] = null;
            }
            if(!isset($data['Dealer']['promo_image'])){
                $data['Dealer']['promo_image'] = $this->Dealer->field('promo_image', array('Dealer.id' => $data['Dealer']['id']));
            }
            if($group_id == 1 && empty($data['Dealer']['dealer_id'])){
                $inCAUS = $this->verifyCAUS();

                if (!empty($inCAUS)) #remove spaces in zipcodes for US and CA
                {
                    if(isset($data['Dealer']['zip'])){
                        $data['Dealer']['zip'] = trim(preg_replace('/\s+/', '', $data['Dealer']['zip']));
                    }
                }
                foreach(array('dealer_number', 'name', 'zip', 'address1', 'address2', 'region_num', 'additional_html', 'url_redirect') as $trim_field){
                    if(isset($data['Dealer'][$trim_field])){
                        $data['Dealer'][$trim_field] = trim($this->escape_data($data['Dealer'][$trim_field]));
                    }
                }
/*                if(isset($data['Dealer']['dealer_number'])){
                    $data['Dealer']['dealer_number'] = trim($data['Dealer']['dealer_number']);
                }
                $data['Dealer']['name'] = trim($this->escape_data($data['Dealer']['name']));
                $data['Dealer']['zip'] = trim($this->escape_data($data['Dealer']['zip']));
                $data['Dealer']['address1'] = trim($this->escape_data($data['Dealer']['address1']));
                $data['Dealer']['address2'] = trim($this->escape_data($data['Dealer']['address2']));
                if(isset($data['Dealer']['region_num'])){
                    $data['Dealer']['region_num'] = trim($this->escape_data($data['Dealer']['region_num']));
                }
                //$data['Dealer']['custom_seo_text'] = trim($this->escape_data($data['Dealer']['custom_seo_text']));
                $data['Dealer']['additional_html'] = trim($this->escape_data($data['Dealer']['additional_html']));
 */
                
                $data['Dealer']['additional_html_start'] = '';
                $data['Dealer']['additional_html_start_sale'] = '';
                $data['Dealer']['additional_html_end'] = '';
                //$data['Dealer']['url_redirect'] = trim($data['Dealer']['url_redirect']);
                if(!empty($data['Date']['additional_html_start'])){
                    $data['Dealer']['additional_html_start'] = strtotime($data['Date']['additional_html_start']);
                    if(empty($data['Date']['additional_html_end'])){
                        $this->Dealer->invalidate('additional_html_end_empty');
                    }
                }else{
                    $data['Dealer']['additional_html_start'] = '';
                }
                if(!empty($data['Date']['additional_html_start_sale'])){
                    $data['Dealer']['additional_html_start_sale'] = strtotime($data['Date']['additional_html_start_sale']);
                    if(empty($data['Date']['additional_html_end'])){
                        $this->Dealer->invalidate('additional_html_end_empty');
                    }
                }else{
                    $data['Dealer']['additional_html_start_sale'] = '';
                }
                if(!empty($data['Date']['additional_html_end'])){
                    $data['Dealer']['additional_html_end'] = strtotime($data['Date']['additional_html_end'].' 23:59:59');
                    if(empty($data['Date']['additional_html_start'])){
                        $this->Dealer->invalidate('additional_html_start_empty');
                    }elseif($data['Dealer']['additional_html_start'] >= $data['Dealer']['additional_html_end']){
                        $this->Dealer->invalidate('additional_html_end_early');
                    }
                    if(!empty($data['Dealer']['additional_html_start_sale']) && $data['Dealer']['additional_html_start_sale'] >= $data['Dealer']['additional_html_end']){
                        $this->Dealer->invalidate('additional_html_end_early');
                    }
                }else{
                    $data['Dealer']['additional_html_end'] = '';
                }
            }
            $data['Dealer']['email'] = trim($this->escape_data($data['Dealer']['email']));
            $save_data = array('Dealer' => $data['Dealer']);
            if(isset($data['User'])){
                $save_data['User'] = $data['User'];
            }
            if(is_array($save_data['Dealer']['promo_image'])){
                $save_data['Dealer']['promo_image'] = '';
            }
            $presave_data = $this->Dealer->find('first', array('conditions' => array('id' => $id), 'recursive' => -1));
            if ($this->Dealer->saveAll($save_data)){
                if(!empty($id) && $group_id == 1 && $save_data['Dealer']['dealer_id'] == ''){
                    $dealer_data = $this->Dealer->find('first', array('conditions' => array('dealer_id' => $id), 'recursive' => -1));
                    if(!empty($dealer_data)){
                        foreach($save_data['Dealer'] as $field_name => $val){
                            if(!in_array($field_name, array('published', 'id', 'dealer_id', 'approval_ready', 'updated'))){
                                if($presave_data['Dealer'][$field_name] == $dealer_data['Dealer'][$field_name] && $presave_data['Dealer'][$field_name] != $val){
                                    $this->Dealer->create();
                                    $this->Dealer->id = $dealer_data['Dealer']['id'];
                                    $this->Dealer->saveField($field_name, $val);
                                }
                            }
                        }
                    }
                }
                if(isset($save_data['Dealer']['approval_ready']) && $save_data['Dealer']['approval_ready'] == 1){
                    $this->email_notify_approval_ready($id);
                }
                $resize_images = array();
                if(!empty($data['Dealer']['promo_image']) && is_array($data['Dealer']['promo_image']) && empty($data['Dealer']['promo_image']['error'])){
                    if(empty($id)){
                        $image_id = $this->Dealer->getLastInsertID();
                    }else{
                        $image_id = $id;
                    }
                    $fileName = $this->upload_file($image_id, $data['Dealer']['promo_image'], 'promo');
                    $this->Dealer->create();
                    $this->Dealer->id = $image_id;
                    $this->Dealer->saveField('promo_image', $fileName);
                    $child_dealer_image_id = $this->Dealer->field('id', array('Dealer.dealer_id' => $image_id, 'or' => array('promo_image' => '', 'promo_image IS NULL')));
                    if(!empty($child_dealer_image_id)){
                        if(!file_exists(WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$child_dealer_image_id.DS.'promo')){
                            mkdir(WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$child_dealer_image_id.DS.'promo', 0777);
                        }
                        copy(WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$image_id.DS.'promo'.DS.$fileName, WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$child_dealer_image_id.DS.'promo'.DS.$fileName);
                        chmod(WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$child_dealer_image_id.DS.'promo'.DS.$fileName, 0777);
                        $this->Dealer->create();
                        $this->Dealer->id = $child_dealer_image_id;
                        $this->Dealer->saveField('promo_image', $fileName);
                    }
                    $resize_images[] = '/files/dealer_imgs/'.$image_id.'/promo/'.$fileName;
                }
                
                $this->set('resize_images', $resize_images);
                $this->set('resized_height', 100);
                $this->set('resized_width', 640);
                
                if($data['Save']['action'] == "approve"){
                    $new_id = $this->approve_dealer($id);
                    //$new_id = $this->Dealer->getLastInsertID();
                    //$this->email_notify_marketing($new_id, true);
                    //Flash a message and redirect.
                    $this->flash('&nbsp;The dealer\'s changes have been approved.',
                                 '/dealers/show/'.$new_id, 2);
                }//Save
                
                if($data['Save']['action'] == "save"){
                    if(!empty($id)){
                        //Flash a message and redirect.
                        $this->flash('Your information has been saved.',
                                    '/dealers/show/'.$data['Dealer']['id'], 2);
                    }else{
                        $new_id = $this->Dealer->getLastInsertID();
                        $this->email_notify_marketing($new_id, true);
                        //Flash a message and redirect.
                        $this->flash('&nbsp;Your information has been saved.',
                                     '/dealers/show/'.$new_id, 2);
                    }
                }//Save
                if($data['Save']['action'] == "saveClose"){
                    if( empty($id) ) {
                        $new_id = $this->Dealer->getLastInsertID();
                        $this->email_notify_marketing($new_id, true);
                    }
                    //Flash a message and redirect.
                    $this->flash('Your information has been saved. <br/>You  will be redirected to the list of dealers.', '/dealers/index/', 2);
                }//Save & Close
                if($data['Save']['action'] == "saveNew"){
                    if( empty($id) ) {
                        $new_id = $this->Dealer->getLastInsertID();
                        $this->email_notify_marketing($new_id, true);
                    }
                    //Flash a message and redirect.
                    $this->flash('Your information has been saved. <br/>You will be redirected to a new dealer entry page.', '/dealers/show/', 2);
                }//Save & New
            }else{
                $this->set('presave_data', $presave_data);
                if(!empty($data['Dealer']['promo_image'])){
                    $data['Dealer']['promo_image'] = '';
                }
                foreach($presave_data['Dealer'] as $presave_field => $presave_val){
                    if(!isset($data['Dealer'][$presave_field])){
                        $data['Dealer'][$presave_field] = $presave_val;
                    }
                }
            }
            if(!isset($data['Dealer']['name'])){
                $data['Dealer']['name'] = $this->Dealer->field('name', array('id' => $id));
            }
            $this->set('data', $data);
        }
        $this->set('showZip', $showZip);
        $this->set('countryList', $this->Country->getCountryList());
        $this->set('stateList', $this->State->find('list', array('sort' => 'position ASC')));
        $this->set('id', $id);
        if(!empty($id)){
            $dealer_approval = $this->Dealer->find('first', array('conditions' => array('Dealer.dealer_id' => $id), 'recursive' => -1));
            if(!empty($dealer_approval)){
                if($dealer_approval['Dealer']['approval_ready'] == 1){
                    $this->set('dealer_approval_id', $dealer_approval['Dealer']['id']);
                }
                $this->set('orig_dealer_data', $dealer_approval);
                $this->set('disable_changed_fields', TRUE);
                
                if(!empty($dealer_approval['Dealer']['promo_image']) || !empty($data['Dealer']['promo_image'])){
                    if($dealer_approval['Dealer']['promo_image'] == $data['Dealer']['promo_image']){
                        $md5_compare = file_exists(WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$id.DS.'promo'.DS.'resized'.DS.$data['Dealer']['promo_image']) ? md5_file(WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$id.DS.'promo'.DS.'resized'.DS.$data['Dealer']['promo_image']) : $data['Dealer']['promo_image'];
                        $md5_orig = file_exists(WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$dealer_approval['Dealer']['id'].DS.'promo'.DS.'resized'.DS.$dealer_approval['Dealer']['promo_image']) ? md5_file(WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$dealer_approval['Dealer']['id'].DS.'promo'.DS.'resized'.DS.$dealer_approval['Dealer']['promo_image']) : $dealer_approval['Dealer']['promo_image'];
                        if($md5_compare != $md5_orig){
                            $this->set('promo_image_changed', 1);
                        }
                    }else{
                        $this->set('promo_image_changed', 1);
                    }
                }
            }
        }
        if($group_id == 1 && !empty($data['Dealer']['dealer_id'])){
            $orig_dealer_data = $this->Dealer->find('first', array('conditions' => array('Dealer.id' => $data['Dealer']['dealer_id']), 'recursive' => -1));
            $this->set('orig_dealer_data', $orig_dealer_data);
            if(!empty($orig_dealer_data['Dealer']['promo_image']) || !empty($data['Dealer']['promo_image'])){
                if($orig_dealer_data['Dealer']['promo_image'] == $data['Dealer']['promo_image']){
                    $md5_compare = file_exists(WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$id.DS.'promo'.DS.'resized'.DS.$data['Dealer']['promo_image']) ? md5_file(WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$id.DS.'promo'.DS.'resized'.DS.$data['Dealer']['promo_image']) : $data['Dealer']['promo_image'];
                    $md5_orig = file_exists(WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$orig_dealer_data['Dealer']['id'].DS.'promo'.DS.'resized'.DS.$orig_dealer_data['Dealer']['promo_image']) ? md5_file(WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$orig_dealer_data['Dealer']['id'].DS.'promo'.DS.'resized'.DS.$orig_dealer_data['Dealer']['promo_image']) : $orig_dealer_data['Dealer']['promo_image'];
                    if($md5_compare != $md5_orig){
                        $this->set('promo_image_changed', 1);
                    }
                }else{
                    $this->set('promo_image_changed', 1);
                }
            }
        }
    }
    
    private function rrmdir($dir) { 
        if (is_dir($dir)) { 
            $objects = scandir($dir); 
            foreach ($objects as $object) { 
                if ($object != "." && $object != "..") { 
                    if (filetype($dir."/".$object) == "dir") $this->rrmdir($dir."/".$object); else unlink($dir."/".$object); 
                }
            }
            reset($objects); 
            rmdir($dir); 
        }
    }
    
    function set_default_slugs(){
        $this->checkLogin();
        $checkSlugCol = $this->Dealer->query("SHOW COLUMNS FROM `dealers` LIKE 'slug'");
        if(empty($checkSlugCol)){
            $this->Dealer->query('ALTER TABLE `dealers` ADD COLUMN `slug` VARCHAR(255) NULL DEFAULT NULL;');
        }
        $dealers = $this->Dealer->find('all', array('conditions' => array('or' => array('slug IS NULL', 'slug' => ''), 'dealer_id IS NULL'), 'recursive' => -1, 'fields' => array('Dealer.id', 'Dealer.city', 'Dealer.state_id', 'Dealer.slug')));
        $slugs = $this->Dealer->find('list', array('conditions' => array('slug IS NOT NULL', 'slug <>' => '', 'dealer_id IS NULL'), 'fields' => array('slug'), 'order' => array('slug')));
        pr($slugs);
        foreach($dealers as $d){
            $cityName = ucwords(strtolower($d['Dealer']['city']));
            $d['Dealer']['slug'] = 'hot-tubs-'.str_replace(array('\'', ' ', ','), '-', strtolower($cityName));
            $slug = $d['Dealer']['slug'];
            $i = 2;
            while(in_array($slug, $slugs)){
                $slug = $d['Dealer']['slug'].'-'.$i++;
            }
            pr($slug);
            $d['Dealer']['slug'] = $slug;
            $this->Dealer->create();
            $this->Dealer->set($d['Dealer']);
            if($this->Dealer->save($d['Dealer'], FALSE)){
                $copy = $this->Dealer->find('first', array('conditions' => array('dealer_id' => $d['Dealer']['id']), 'recursive' => -1));
                if(!empty($copy)){
                    $copy['Dealer']['slug'] = $slug;
                    $this->Dealer->create();
                    $this->Dealer->set($copy['Dealer']);
                    $this->Dealer->save($copy['Dealer'], FALSE);
                }
                $slugs[$d['Dealer']['id']] = $slug;
            }
        }
        pr($dealers);
        die();
    }
    
    private function approve_dealer($id){
        $dealer = $this->Dealer->find('first', array('conditions' => array('Dealer.id' => $id), 'fields' => array('Dealer.dealer_id'), 'recursive' => -1));
        $dealer['Dealer']['dealer_id'] = (int) $dealer['Dealer']['dealer_id'];
        $dealer_published = $this->Dealer->field('published', array('Dealer.id' => $dealer['Dealer']['dealer_id']));
        if(!empty($dealer['Dealer']['dealer_id'])){
            $this->Dealer->query('DELETE FROM dealers WHERE dealers.id='.$dealer['Dealer']['dealer_id'].';');
            $this->Dealer->DealersService->deleteAll(array('DealersService.dealer_id' => $dealer['Dealer']['dealer_id']), FALSE);
            $this->Dealer->Quote->deleteAll(array('Quote.dealer_id' => $dealer['Dealer']['dealer_id']), FALSE);
            $this->Dealer->Staff->deleteAll(array('Staff.dealer_id' => $dealer['Dealer']['dealer_id']), FALSE);
            $this->Dealer->Image->deleteAll(array('Image.dealer_id' => $dealer['Dealer']['dealer_id']), FALSE);
            $this->rrmdir(WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$dealer['Dealer']['dealer_id']);
            rename(WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$id, WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$dealer['Dealer']['dealer_id']);
            $this->Dealer->DealersService->updateAll(array('dealer_id' => $dealer['Dealer']['dealer_id']), array('dealer_id' => $id));
            $this->Dealer->Staff->updateAll(array('dealer_id' => $dealer['Dealer']['dealer_id']), array('dealer_id' => $id));
            $this->Dealer->Image->updateAll(array('dealer_id' => $dealer['Dealer']['dealer_id']), array('dealer_id' => $id));
            $this->Dealer->Quote->updateAll(array('dealer_id' => $dealer['Dealer']['dealer_id']), array('dealer_id' => $id));
        }
        $save_data = array();
        $save_data['id'] = $dealer['Dealer']['dealer_id'];
        $save_data['dealer_id'] = null;
        $save_data['approval_ready'] = 0;
        $this->Dealer->updateAll($save_data, array('Dealer.id' => $id));
        
        $this->Dealer->create();
        $this->Dealer->id = $dealer['Dealer']['dealer_id'];
        $this->Dealer->saveField('published', $dealer_published, false);
        
        return $dealer['Dealer']['dealer_id'];
            //die();
            /*
            $new_id = $this->Dealer->getInsertID();
            mkdir(WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$new_id);
            if(!empty($dealer['Dealer']['promo_image'])){
                mkdir(WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$new_id.DS.'promo');
                copy(WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$id.DS.'promo'.DS.$dealer['Dealer']['promo_image'], WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$new_id.DS.'promo'.DS.$dealer['Dealer']['promo_image']);
            }
            if(isset($dealer['Quote']) && !empty($dealer['Quote'])){
                foreach($dealer['Quote'] as $k => $v){
                    unset($dealer['Quote'][$k]['id']);
                    $dealer['Quote'][$k]['dealer_id'] = $new_id;
                }
            }
            if(isset($dealer['Service']) && !empty($dealer['Service'])){
                foreach($dealer['Service'] as $k => $v){
                    unset($dealer['Service'][$k]['id']);
                    $dealer['Service'][$k]['dealer_id'] = $new_id;
                }
            }
            if(isset($dealer['Staff']) && !empty($dealer['Staff'])){
                mkdir(WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$new_id.DS.'staff');
                foreach($dealer['Staff'] as $k => $v){
                    unset($dealer['Staff'][$k]['id']);
                    $dealer['Staff'][$k]['dealer_id'] = $new_id;
                    if(!empty($v['photo'])){
                        copy(WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$id.DS.'staff'.DS.$v['photo'], WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$new_id.DS.'staff'.DS.$v['photo']);
                    }
                }
                $this->Dealer->Staff->saveAll($dealer['Staff']);
            }
            if(isset($dealer['Image']) && !empty($dealer['Image'])){
                mkdir(WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$new_id.DS.'store');
                foreach($dealer['Image'] as $k => $v){
                    unset($dealer['Image'][$k]['id']);
                    $dealer['Image'][$k]['dealer_id'] = $new_id;
                    if(!empty($v['path'])){
                        copy(WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$id.DS.'store'.DS.$v['path'], WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$new_id.DS.'store'.DS.$v['path']);
                    }
                }
                $this->Dealer->Image->saveAll($dealer['Image']);
            }*/
        //}
        //return $new_id;
    }
    
    function reject_dealer_changes($id){
        $group_id = $this->checkLogin($id);
        $dealer = $this->Dealer->find('first', array('conditions' => array('Dealer.id' => $id, 'Dealer.dealer_id IS NOT NULL')));
        if(!empty($dealer)){
            $this->Dealer->Staff->deleteAll(array('Staff.dealer_id' => $id));
            $this->Dealer->Image->deleteAll(array('Image.dealer_id' => $id));
            $this->Dealer->DealersService->deleteAll(array('DealersService.dealer_id' => $id));
            $this->Dealer->Quote->deleteAll(array('Quote.dealer_id' => $id));
            $this->Dealer->deleteAll(array('Dealer.id' => $id));
            $this->rrmdir(WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$id);
            $this->flash('This dealer\'s changes have been rejected and deleted.',
                                    '/dealers/show/'.$dealer['Dealer']['dealer_id'], 2);
        }else{
            $this->flash('There was an issue rejecting this dealer.',
                                    '/dealers/show/'.$id, 2);
        }
    }
    
    function copy_dealer($id){
        $dealer = $this->Dealer->find('first', array('conditions' => array('Dealer.id' => $id), 'contain' => array('Quote', 'Image', 'Staff', 'Service')));
        $dealer['Dealer']['dealer_id'] = $id;
        unset($dealer['Dealer']['id']);
        $this->Dealer->create();
        $dealer['Dealer']['published'] = 'N';
        if($this->Dealer->save($dealer['Dealer'], array('validate' => FALSE))){
            $new_id = $this->Dealer->getInsertID();
            if(!file_exists(WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$new_id)){
                mkdir(WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$new_id, 0777);
            }
            if(!empty($dealer['Dealer']['promo_image'])){
                if(!file_exists(WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$new_id.DS.'promo')){
                    mkdir(WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$new_id.DS.'promo', 0777);
                }
                copy(WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$id.DS.'promo'.DS.$dealer['Dealer']['promo_image'], WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$new_id.DS.'promo'.DS.$dealer['Dealer']['promo_image']);
                chmod(WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$new_id.DS.'promo'.DS.$dealer['Dealer']['promo_image'], 0777);
                if(is_dir(WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$id.DS.'promo'.DS.'resized') && is_file(WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$id.DS.'promo'.DS.'resized'.DS.$dealer['Dealer']['promo_image'])){
                    mkdir(WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$new_id.DS.'promo'.DS.'resized', 0777);
                    copy(WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$id.DS.'promo'.DS.'resized'.DS.$dealer['Dealer']['promo_image'], WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$new_id.DS.'promo'.DS.'resized'.DS.$dealer['Dealer']['promo_image']);
                    chmod(WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$new_id.DS.'promo'.DS.'resized'.DS.$dealer['Dealer']['promo_image'], 0777);
                }
            }
            if(isset($dealer['Quote']) && !empty($dealer['Quote'])){
                foreach($dealer['Quote'] as $k => $v){
                    unset($dealer['Quote'][$k]['id']);
                    $dealer['Quote'][$k]['dealer_id'] = $new_id;
                }
                $this->Dealer->Quote->saveAll($dealer['Quote']);
            }
            if(isset($dealer['Service']) && !empty($dealer['Service'])){
                $services = array();
                foreach($dealer['Service'] as $k => $v){
                    unset($dealer['Service'][$k]['DealersService']['id']);
                    $dealer['Service'][$k]['DealersService']['dealer_id'] = $new_id;
                    $services[] = $dealer['Service'][$k]['DealersService'];
                }
                $this->Dealer->DealersService->saveAll($services);
            }
            if(isset($dealer['Staff']) && !empty($dealer['Staff'])){
                if(!file_exists(WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$new_id.DS.'staff')){
                    mkdir(WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$new_id.DS.'staff', 0777);
                    mkdir(WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$new_id.DS.'staff'.DS.'resized', 0777);
                }
                foreach($dealer['Staff'] as $k => $v){
                    unset($dealer['Staff'][$k]['id']);
                    $dealer['Staff'][$k]['dealer_id'] = $new_id;
                    if(!empty($v['photo'])){
                        copy(WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$id.DS.'staff'.DS.$v['photo'], WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$new_id.DS.'staff'.DS.$v['photo']);
                        chmod(WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$new_id.DS.'staff'.DS.$v['photo'], 0777);
                        if(is_dir(WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$id.DS.'staff'.DS.'resized') && is_file(WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$id.DS.'staff'.DS.'resized'.DS.$v['photo'])){
                            copy(WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$id.DS.'staff'.DS.'resized'.DS.$v['photo'], WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$new_id.DS.'staff'.DS.'resized'.DS.$v['photo']);
                            chmod(WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$new_id.DS.'staff'.DS.'resized'.DS.$v['photo'], 0777);
                        }
                    }
                }
                $this->Dealer->Staff->saveAll($dealer['Staff']);
            }
            if(isset($dealer['Image']) && !empty($dealer['Image'])){
                if(!file_exists(WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$new_id.DS.'store')){
                    mkdir(WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$new_id.DS.'store', 0777);
                    mkdir(WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$new_id.DS.'store'.DS.'resized', 0777);
                }
                foreach($dealer['Image'] as $k => $v){
                    unset($dealer['Image'][$k]['id']);
                    $dealer['Image'][$k]['dealer_id'] = $new_id;
                    if(!empty($v['path'])){
                        copy(WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$id.DS.'store'.DS.$v['path'], WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$new_id.DS.'store'.DS.$v['path']);
                        chmod(WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$new_id.DS.'store'.DS.$v['path'], 0777);
                        if(is_dir(WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$id.DS.'store'.DS.'resized') && is_file(WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$id.DS.'store'.DS.'resized'.DS.$v['path'])){
                            copy(WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$id.DS.'store'.DS.'resized'.DS.$v['path'], WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$new_id.DS.'store'.DS.'resized'.DS.$v['path']);
                            chmod(WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$new_id.DS.'store'.DS.'resized'.DS.$v['path'], 0777);
                        }
                    }
                }
                $this->Dealer->Image->saveAll($dealer['Image']);
            }
        }
        return $new_id;
    }
    
    function quotes($id, $requestApproval = 0){
        $group_id = $this->checkLogin($id);
        $this->set('group_id', $group_id);
        $this->getQuery();
        $this->layout = "admin";
        $dealer = $this->Dealer->find('first', array('recursive' => -1, 'conditions' => array("Dealer.id" => $id)));
        
        $copy_id = $this->Dealer->field('id', array('dealer_id' => $id));
        if(!empty($copy_id)){
            $this->set('copy_id', $copy_id);
            $copy_data = $this->Dealer->Quote->find('all', array('conditions' => array('dealer_id' => $copy_id), 'fields' => array('quote', 'name'),  'order' => 'Quote.id'));
        }
        
        if (empty($dealer['Dealer']['dealer_id']) &&  $dealer['Dealer']['country_id'] && ($dealer['Dealer']['country_id'] == $this->us_id || $dealer['Dealer']['country_id'] == $this->can_id)){
            $showZip = TRUE;
        }else $showZip = FALSE;
        $deletes = array();
        if(!empty($this->request->data)){
            $data = $this->request->data;
            if(isset($copy_data)){
                $old_data = $this->Dealer->Quote->find('all', array('conditions' => array('dealer_id' => $id), 'fields' => array('quote', 'name'),  'order' => 'Quote.id'));
                if($old_data == $copy_data){
                    $replace = TRUE;
                }
            }
            foreach($data['Quote'] as $k => $q){
                if(!empty($q['quote'])){
                    $data['Quote'][$k]['dealer_id'] = $id;
                }else{
                    if(isset($q['id'])){
                        $deletes[] = $q['id'];
                    //}else{
                    }
                    unset($data['Quote'][$k]);
                }
            }
            $this->Dealer->Quote->create();
            if (empty($data['Quote']) || $this->Dealer->Quote->saveAll($data['Quote'])) {
                if(isset($replace)){
                    $replace_data = array();
                    foreach($data['Quote'] as $q){
                        $replace_data['Quote'][] = array('quote' => $q['quote'], 'name' => $q['name'], 'dealer_id' => $copy_id);
                    }
                    $this->Dealer->Quote->deleteAll(array('dealer_id' => $copy_id), FALSE);
                    $this->Dealer->Quote->create();
                    $this->Dealer->Quote->saveAll($replace_data['Quote']);
                }
                foreach($deletes as $d){
                    $this->Dealer->Quote->delete($d);
                }
                if($requestApproval == 1){
                    $this->Dealer->id = $id;
                    $this->Dealer->saveField('approval_ready', 1);
                    $this->email_notify_approval_ready($id);
                }
                $this->flash('Your information has been saved.',
                                    '/dealers/quotes/'.$id, 2);
            }else{
                $this->set('msg', 'There was an error saving your data');
            }
        }
        $quotes = $this->Dealer->Quote->find('all', array('conditions' => array('dealer_id' => $id)));
        $quotes_compare = $this->Dealer->Quote->find('all', array('conditions' => array('dealer_id' => $id), 'fields' => array('quote', 'name'), 'order' => 'Quote.id'));
        if(!empty($dealer['Dealer']['dealer_id'])){
            $orig_data = $this->Dealer->Quote->find('all', array('conditions' => array('dealer_id' => $dealer['Dealer']['dealer_id']), 'fields' => array('quote', 'name'), 'order' => 'Quote.id'));
            $this->set('orig_id', $dealer['Dealer']['dealer_id']);
        }elseif(isset($copy_data)){
            $orig_data = $copy_data;
        }
        if(isset($orig_data) && $orig_data != $quotes_compare){
            $this->set('orig_data', $orig_data);
            $this->set('changed', 1);
        }
        $this->set('data', $quotes);
        $this->set('id', $id);
        $this->set('showZip', $showZip);
        $this->set('countryList', $this->Country->getCountryList()); #generate list of countries
        $this->set('stateList', $this->State->find('list', array('sort' => 'position ASC'))); #generate list of states
    }
    
    function delete_staff($staff_id){
        $staff = $this->Dealer->Staff->findById($staff_id);
        if(!empty($staff)){
            $dealer_id = $staff['Staff']['dealer_id'];
            $photo = $staff['Staff']['photo'];
            $this->checkLogin($dealer_id);
            if($this->Dealer->Staff->delete($staff_id)){
                unlink(WWW_ROOT . 'files/dealer_imgs/'.$dealer_id.'/staff/'.$staff['Staff']['photo']);
            }
            $this->redirect('/dealers/staff/'.$dealer_id);
        }
    }
    
    function services($id, $requestApproval = 0){
        $group_id = $this->checkLogin($id);
        $this->set('group_id', $group_id);
        $fail = FALSE;
        //find the dealer's version of this if it exists
        $copy_id = $this->Dealer->field('id', array('dealer_id' => $id));
        if(!empty($copy_id)){
            $this->set('copy_id', $copy_id);
            $copy_data = $this->Dealer->DealersService->find('list', array('fields' => array('service_id', 'service_id'), 'conditions' => array('dealer_id' => $copy_id)));
        }
        
        if(!empty($this->request->data)){
            if(isset($copy_data)){
                $old_data = $this->Dealer->DealersService->find('list', array('fields' => array('service_id', 'service_id'), 'conditions' => array('dealer_id' => $id)));
                if(!array_diff($old_data, $copy_data) && !array_diff($copy_data, $old_data)){
                    $this->Dealer->DealersService->deleteAll(array('dealer_id' => $copy_id), FALSE);
                    foreach($this->request->data['DealersService']['service_id'] as $s){
                        $this->Dealer->DealersService->create();
                        if(!$this->Dealer->DealersService->save(array('dealer_id' => $copy_id, 'service_id' => $s))){
                            $fail = TRUE;
                        }
                    }
                }
            }
            $this->Dealer->DealersService->deleteAll(array('dealer_id' => $id), FALSE);
            foreach($this->request->data['DealersService']['service_id'] as $s){
                $this->Dealer->DealersService->create();
                if(!$this->Dealer->DealersService->save(array('dealer_id' => $id, 'service_id' => $s))){
                    $fail = TRUE;
                }
            }
            if(!$fail){
                if($requestApproval == 1){
                    $this->Dealer->id = $id;
                    $this->Dealer->saveField('approval_ready', 1);
                    $this->email_notify_approval_ready($id);
                }
                $this->flash('Your information has been saved.',
                                    '/dealers/services/'.$id, 2);
            }
        }
        $this->getQuery();
        $this->layout = "admin";
        $dealer = $this->Dealer->find('first', array('recursive' => -1, 'conditions' => array("Dealer.id" => $id)));
        if(!empty($dealer['Dealer']['dealer_id'])){
            $orig_data = $this->Dealer->DealersService->find('list', array('fields' => array('service_id', 'service_id'), 'conditions' => array('dealer_id' => $dealer['Dealer']['dealer_id'])));
            $this->set('orig_id', $dealer['Dealer']['dealer_id']);
        }elseif(isset($copy_data)){
            $orig_data = $copy_data;
        }
        if (empty($dealer['Dealer']['dealer_id']) &&  $dealer['Dealer']['country_id'] && ($dealer['Dealer']['country_id'] == $this->us_id || $dealer['Dealer']['country_id'] == $this->can_id)){
            $showZip = TRUE;
        }else $showZip = FALSE;

        $services = $this->Service->find('list');
        $data = $this->Dealer->DealersService->find('list', array('fields' => array('service_id', 'service_id'), 'conditions' => array('dealer_id' => $id)));
        if(isset($orig_data) && (array_diff($data, $orig_data) || array_diff($orig_data, $data))){
            $this->set('orig_data', $orig_data);
            $this->set('changed', 1);
        }
        $this->set('services', $services);
        $this->set('data', $data);
        $this->set('id', $id);
        $this->set('showZip', $showZip);
        $this->set('countryList', $this->Country->getCountryList()); #generate list of countries
        $this->set('stateList', $this->State->find('list', array('sort' => 'position ASC'))); #generate list of states
    }
    
    private function copy_cropped_image($parent_id, $child_id, $image_type){
        $images = array();
        switch($image_type){
            case 'staff':
                $data = $this->Dealer->Staff->find('all', array('conditions' =>array('Staff.dealer_id' => $parent_id)));
                foreach($data as $d){
                    if(!empty($d['Staff']['photo'])){
                        $images[] = $d['Staff']['photo'];
                    }
                }
                break;
            case 'store':
                $data = $this->Dealer->Image->find('all', array('conditions' =>array('Image.dealer_id' => $parent_id)));
                foreach($data as $d){
                    $images[] = $d['Image']['path'];
                }
                break;
            case 'promo':
                $data = $this->Dealer->field('promo_image', array('Dealer.id' => $parent_id));
                if(!empty($data)){
                    $images[] = $data;
                }
                break;
        }
        if(!empty($images)){
            foreach($images as $i){
                $parent_resize_image = WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$parent_id.DS.$image_type.DS.'resized'.DS.$i;
                $child_base_image = WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$child_id.DS.$image_type.DS.$i;
                $child_resize_image = WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$child_id.DS.$image_type.DS.'resized'.DS.$i;
                if(file_exists($parent_resize_image) && file_exists($child_base_image) && !file_exists($child_resize_image)){
                    if(!file_exists(WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$child_id.DS.$image_type.DS.'resized')){
                        mkdir(WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$child_id.DS.$image_type.DS.'resized', 0777);
                    }
                    copy($parent_resize_image, $child_resize_image);
                    chmod($child_resize_image, 0777);
                }
            }
        }
    }
    
    function images($id, $requestApproval = 0){
        $group_id = $this->checkLogin($id);
        $this->set('group_id', $group_id);
        $fail = FALSE;
        $copy_id = $this->Dealer->field('id', array('dealer_id' => $id));
        if(!empty($copy_id)){
            $this->copy_cropped_image($id, $copy_id, 'store');
            $this->set('copy_id', $copy_id);
            $copy_data = $this->Dealer->Image->find('all', array('conditions' => array('dealer_id' => $copy_id), 'fields' => array('path'), 'order' => 'Image.id'));
        }
        $replace = FALSE;
        if(!empty($this->request->data) && isset($this->request->data['Image'])){
            if(isset($copy_data)){
                $old_data = $this->Dealer->Image->find('all', array('fields' => array('path'), 'conditions' => array('dealer_id' => $id), 'order' => 'Image.id'));
                if($old_data == $copy_data){
                    $replace = TRUE;
                }
            }
            $replace_data = array();
            $resize_images = array();
            foreach($this->request->data['Image'] as $i){
                if(!empty($i['path']) && isset($i['path']['error']) && empty($i['path']['error'])){
                    $fileName = $this->upload_file($id, $i['path'], 'store');
                    $this->Dealer->Image->create();
                    if(!$this->Dealer->Image->save(array('Image' => array('dealer_id' => $id, 'path' => $fileName)))){
                        $fail = TRUE;
                    }else{
                        $resize_images[] = '/files/dealer_imgs/'.$id.'/store/'.$fileName;
                    }
                    $replace_data[] = array('path' => $fileName, 'dealer_id' => $copy_id);
                }elseif(!empty($i['path']) && !is_array($i['path'])){
                    $replace_data[] = array('path' => $i['path'], 'dealer_id' => $copy_id);
                }
            }
            if(!$fail){
                if($replace){
                    $this->Dealer->Image->deleteAll(array('dealer_id' => $copy_id), FALSE);
                    $files = glob(WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$copy_id.DS.'store'.DS.'*'); // get all file names
                    foreach($files as $file){ // iterate files
                        if(is_file($file)){
                            unlink($file); // delete file
                        }
                    }
                    $this->Dealer->Image->saveAll($replace_data);
                    foreach($replace_data as $r){
                        if(!file_exists(WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$copy_id.DS.'store')){
                            mkdir(WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$copy_id.DS.'store', 0777);
                        }
                        copy(WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$id.DS.'store'.DS.$r['path'], WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$copy_id.DS.'store'.DS.$r['path']);
                        chmod(WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$copy_id.DS.'store'.DS.$r['path'], 0777);
                    }
                }
                if($requestApproval == 1){
                    $this->Dealer->id = $id;
                    $this->Dealer->saveField('approval_ready', 1);
                    $this->email_notify_approval_ready($id);
                }
                $this->set('resize_images', $resize_images);
                $this->set('resized_height', 304);
                $this->set('resized_width', 317);
                $this->flash('Your information has been saved.',
                                    '/dealers/images/'.$id, 2);
            }
        }
        $this->getQuery();
        $this->layout = "admin";
        $dealer = $this->Dealer->find('first', array('recursive' => -1, 'conditions' => array("Dealer.id" => $id)));
        if(!empty($dealer['Dealer']['dealer_id'])){
            $this->copy_cropped_image($dealer['Dealer']['dealer_id'], $id, 'store');
            $orig_data = $this->Dealer->Image->find('all', array('conditions' => array('dealer_id' => $dealer['Dealer']['dealer_id']), 'fields' => array('path'),  'order' => 'Image.id'));
            $this->set('orig_id', $dealer['Dealer']['dealer_id']);
            $orig_id = $dealer['Dealer']['dealer_id'];
        }elseif(isset($copy_data)){
            $orig_data = $copy_data;
            $orig_id = $copy_id;
        }
        if ( isset($dealer) && empty($dealer['Dealer']['dealer_id']) && $dealer['Dealer']['country_id'] && ($dealer['Dealer']['country_id'] == $this->us_id || $dealer['Dealer']['country_id'] == $this->can_id)){
            $showZip = TRUE;
        }else $showZip = FALSE;
        $data = $this->Dealer->Image->find('all', array('conditions' => array('dealer_id' => $id)));
        $compare_data = $this->Dealer->Image->find('all', array('conditions' => array('dealer_id' => $id), 'fields' => array('path'),  'order' => 'Image.id'));
        if(isset($orig_data)){
            if($orig_data != $compare_data){
                $this->set('orig_data', $orig_data);
                $this->set('changed', 1);
            }else{
                foreach($compare_data as $ok => $ov){
                    $md5_compare = file_exists(WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$id.DS.'store'.DS.'resized'.DS.$compare_data[$ok]['Image']['path']) ? md5_file(WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$id.DS.'store'.DS.'resized'.DS.$compare_data[$ok]['Image']['path']) : $compare_data[$ok]['Image']['path'];
                    $md5_orig = file_exists(WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$orig_id.DS.'store'.DS.'resized'.DS.$orig_data[$ok]['Image']['path']) ? md5_file(WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$orig_id.DS.'store'.DS.'resized'.DS.$orig_data[$ok]['Image']['path']) : $orig_data[$ok]['Image']['path'];
                    if($md5_compare != $md5_orig){
                        $this->set('orig_data', $orig_data);
                        $this->set('changed', 1);
                        break;
                    }
                }
            }
        }
        $this->set('data', $data);
        $this->set('id', $id);
        $this->set('showZip', $showZip);
        $this->set('countryList', $this->Country->getCountryList()); #generate list of countries
        $this->set('stateList', $this->State->find('list', array('sort' => 'position ASC'))); #generate list of states
    }
    
    function image_crop($dealer_id, $type, $id=null){
        $this->checkLogin($dealer_id);
        $redirect = '/dealers/show/'.$dealer_id;
        $copy_dealer = $this->Dealer->find('first', array('conditions' => array('Dealer.dealer_id' => $dealer_id), 'fields' => array('Dealer.id', 'Dealer.promo_image'), 'recursive' => -1));
        if($type == 'promo'){
            $image = $this->Dealer->field('promo_image', array('Dealer.id' => $dealer_id));
            $width = 640;
            $height = 100;
            if(!empty($copy_dealer)){
                $copy_img_name = $copy_dealer['Dealer']['promo_image'];
            }
        }elseif($type == 'store'){
            $image = $this->Dealer->Image->field('path', array('Image.dealer_id' => $dealer_id, 'Image.id' => $id));
            $width = 304;
            $height = 317;
            $redirect = '/dealers/images/'.$dealer_id;
            if(!empty($copy_dealer)){
                $copy_img_name = $this->Dealer->Image->field('Image.path', array('Image.dealer_id' => $copy_dealer['Dealer']['id'], 'Image.path' => $image));
            }
        }elseif($type == 'staff'){
            $image = $this->Dealer->Staff->field('photo', array('Staff.dealer_id' => $dealer_id, 'Staff.id' => $id));
            $width = 220;
            $height = 162;
            $redirect = '/dealers/staff/'.$dealer_id;
            if(!empty($copy_dealer)){
                $copy_img_name = $this->Dealer->Staff->field('Staff.photo', array('Staff.dealer_id' => $copy_dealer['Dealer']['id'], 'Staff.photo' => $image));
            }
        }
        if(!empty($image)){
            if(!empty($this->request->data)){
                $data = $this->request->data;
                //pr($this->request->data);
                $new_path = WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$dealer_id.DS.$type.DS.'resized'.DS.$image;
                //die();
                $x1 = $this->request->data['Dealer']['x1'];
                $y1 = $this->request->data['Dealer']['y1'];
                $new_width = $this->request->data['Dealer']['width'];
                $new_height = $this->request->data['Dealer']['height'];

                $srcImg = imagecreatefromjpeg(WWW_ROOT.'files/dealer_imgs/'.$dealer_id.'/'.$type.'/'.$image);
                $newImg = imagecreatetruecolor($width, $height);
                
                imagecopyresampled($newImg, $srcImg, 0, 0, $x1, $y1, $width, $height, $new_width, $new_height);
                if(file_exists($new_path)){
                    $cur_image = md5_file($new_path);
                    unlink($new_path);
                }

                if(imagejpeg($newImg, $new_path)){
                    chmod($new_path, 0777);
                    if(isset($cur_image) && isset($copy_img_name) && !empty($copy_img_name) && $copy_img_name == $image){
                        $copy_image_path = WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$copy_dealer['Dealer']['id'].DS.$type.DS.'resized'.DS.$copy_img_name;
                        if(!file_exists($copy_image_path) || $cur_image == md5_file($copy_image_path)){
                            if(file_exists($copy_image_path)){
                                unlink($copy_image_path);
                            }
                            imagejpeg($newImg, $copy_image_path);
                            chmod($copy_image_path, 0777);
                        }
                    }
                    $this->flash("The resized image has been saved.", $redirect, 3);
                }
            }
            $this->set('image', $dealer_id.'/'.$type.'/'.$image);
            $this->set('width', $width);
            $this->set('height', $height);
            $this->set('type', $type);
        }else{
            $this->flash("The image you selected could not be found.<br>
                                     You will now be redirected to the dealer page.", $redirect, 3);
        }
    }
    
    function staff($id, $requestApproval = 0){ 
        $group_id = $this->checkLogin($id);
        $this->set('group_id', $group_id);
        
        $copy_id = $this->Dealer->field('id', array('dealer_id' => $id));
        $orig_id = $copy_id; 
        if(!empty($copy_id)){
            $this->copy_cropped_image($id, $copy_id, 'staff');
            $this->set('copy_id', $copy_id);
            $copy_data = $this->Dealer->Staff->find('all', array('conditions' => array('dealer_id' => $copy_id), 'fields' => array('name', 'position', 'description', 'photo'),  'order' => 'Staff.id'));
        }
        $replace = FALSE;
        if(!empty($this->request->data) && isset($this->request->data['Staff'])){
            if(empty($this->request->data['Staff'][0]['name']) && empty($this->request->data['Staff'][0]['position']) && empty($this->request->data['Staff'][0]['description']) && empty($this->request->data['Staff'][0]['photo']['name'])){
                unset($this->request->data['Staff'][0]);
            }
            if(isset($copy_data)){
                $old_data = $this->Dealer->Staff->find('all', array('conditions' => array('dealer_id' => $id), 'fields' => array('name', 'position', 'description', 'photo'),  'order' => 'Staff.id'));
                if($old_data == $copy_data){
                    $replace = TRUE;
                }
            }
            
            
            $resize_images = array();
            foreach($this->request->data['Staff'] as $n => $i){
                $replace_data[$n] = $i;
                $replace_data[$n]['dealer_id'] = $copy_id;
                unset($replace_data[$n]['id']);
                if(!empty($i['photo']) && empty($i['photo']['error'])){
                    $this->request->data['Staff'][$n]['photo'] = $this->upload_file($id, $i['photo'], 'staff');
                    $resize_images[] = '/files/dealer_imgs/'.$id.'/staff/'.$this->request->data['Staff'][$n]['photo'];
                    if($replace){
                        $replace_data[$n]['photo'] = $this->request->data['Staff'][$n]['photo'];
                    }
                }else{
                    if(!isset($i['photo']) && isset($i['id'])){
                        $replace_data[$n]['photo'] = $this->Dealer->Staff->field('photo', array('id' => $i['id']));
                    }
                    unset($this->request->data['Staff'][$n]['photo']);
                }
                $this->request->data['Staff'][$n]['dealer_id'] = $id;
            }
            if(empty($this->request->data['Staff']) || $this->Dealer->Staff->saveAll($this->request->data['Staff'])){
                //if(isset($this->request->data['Staff'][0])){
                //    unset($this->request->data['Staff'][0]);
                //}
                
                if($replace){
                    $this->Dealer->Staff->deleteAll(array('dealer_id' => $copy_id), FALSE);
                    $files = glob(WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$copy_id.DS.'staff'.DS.'*'); // get all file names
                    foreach($files as $file){ // iterate files
                        if(is_file($file)){
                            unlink($file); // delete file
                        }
                    }
                    $this->Dealer->Staff->saveAll($replace_data);
                    foreach($replace_data as $r){
                        if(isset($r['photo']) && !empty($r['photo'])){
                            if(!file_exists(WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$copy_id.DS.'staff')){
                                mkdir(WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$copy_id.DS.'staff', 0777);
                            }
                            copy(WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$id.DS.'staff'.DS.$r['photo'], WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$copy_id.DS.'staff'.DS.$r['photo']);
                            chmod(WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$copy_id.DS.'staff'.DS.$r['photo'], 0777);
                        }
                    }
                }
                
            
                if($requestApproval == 1){
                    $this->Dealer->id = $id;
                    $this->Dealer->saveField('approval_ready', 1);
                    $this->email_notify_approval_ready($id);
                }
                $this->set('resize_images', $resize_images);
                $this->set('resized_height', 162);
                $this->set('resized_width', 220);
                $this->flash('Your information has been saved.',
                                    '/dealers/staff/'.$id, 2);
            }
        }
        /*elseif($requestApproval == 1){
            if($requestApproval == 1){
                    $this->Dealer->id = $id;
                    $this->Dealer->saveField('approval_ready', 1);
                    $this->email_notify_approval_ready($id);
                }
                $this->flash('Your information has been saved.',
                                    '/dealers/staff/'.$id, 2);
        }*/
        $this->getQuery();
        $this->layout = "admin";
        $dealer = $this->Dealer->find('first', array('recursive' => -1, 'conditions' => array("Dealer.id" => $id)));
        if (empty($dealer['Dealer']['dealer_id']) &&  $dealer['Dealer']['country_id'] && ($dealer['Dealer']['country_id'] == $this->us_id || $dealer['Dealer']['country_id'] == $this->can_id)){
            $showZip = TRUE;
        }else $showZip = FALSE;
        $data = $this->Dealer->Staff->find('all', array('conditions' => array('dealer_id' => $id)));
        
        $staff_compare = $this->Dealer->Staff->find('all', array('conditions' => array('dealer_id' => $id), 'fields' => array('name', 'position', 'description', 'photo'),  'order' => 'Staff.id'));
        if(!empty($dealer['Dealer']['dealer_id'])){
            $this->copy_cropped_image($dealer['Dealer']['dealer_id'], $id, 'staff');
            $orig_data = $this->Dealer->Staff->find('all', array('conditions' => array('dealer_id' => $dealer['Dealer']['dealer_id']), 'fields' => array('name', 'position', 'description', 'photo'), 'order' => 'Staff.id'));
            $this->set('orig_id', $dealer['Dealer']['dealer_id']);
            $orig_id = $dealer['Dealer']['dealer_id'];
        }elseif(isset($copy_data)){
            $orig_data = $copy_data;
            $orig_id = $copy_id;
        }
        if(isset($orig_data)){
            if($orig_data != $staff_compare){
                $this->set('orig_data', $orig_data);
                $this->set('changed', 1);
            }else{
                foreach($staff_compare as $ok => $ov){
                    $md5_compare = file_exists(WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$id.DS.'staff'.DS.'resized'.DS.$staff_compare[$ok]['Staff']['photo']) ? md5_file(WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$id.DS.'staff'.DS.'resized'.DS.$staff_compare[$ok]['Staff']['photo']) : $staff_compare[$ok]['Staff']['photo'];
                    $md5_orig = file_exists(WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$orig_id.DS.'staff'.DS.'resized'.DS.$orig_data[$ok]['Staff']['photo']) ? md5_file(WWW_ROOT.'files'.DS.'dealer_imgs'.DS.$orig_id.DS.'staff'.DS.'resized'.DS.$orig_data[$ok]['Staff']['photo']) : $orig_data[$ok]['Staff']['photo'];
                    if($md5_compare != $md5_orig){
                        $this->set('orig_data', $orig_data);
                        $this->set('changed', 1);
                        break;
                    }
                }
            }
        }
        
        
        $this->set('data', $data);
        $this->set('id', $id);
        $this->set('showZip', $showZip);
        $this->set('countryList', $this->Country->getCountryList()); #generate list of countries
        $this->set('stateList', $this->State->find('list', array('sort' => 'position ASC'))); #generate list of states
    }
    
    function upload_file($id, $uploadData, $dir){
        $this->checkLogin($id);
        //pr($uploadData);
        //die();
        $imageData = getimagesize($uploadData['tmp_name']);
        $ext = image_type_to_extension($imageData[2]);
        $image_name = substr($uploadData['name'], 0, strpos($uploadData['name'], '.'));
        //pr($uploadData);
        //pr($image_name);
        //die();
        if(in_array($ext, array('.jpeg', '.jpg', '.gif', '.png'))){
            if(!empty($uploadData) && !empty($id)){
                if ( $uploadData['size'] == 0 || $uploadData['error'] !== 0) {
                    return false;
                }

                $uploadFolder = 'files'. DS . 'dealer_imgs' . DS . $id . DS . $dir;
                
                $extra_num = 1;
                $fileName = $image_name;
                while(is_file($uploadFolder . DS . $fileName . $ext)){
                    $fileName = $image_name.$extra_num++;
                }
                
                $image_name = $fileName;
                
                $fileName = $name = $image_name . $ext;
                $uploadPath =  $uploadFolder . DS . $fileName;
                
                if(!file_exists('files'. DS . 'dealer_imgs' . DS . $id)){
                    mkdir('files'. DS . 'dealer_imgs' . DS . $id, 0777);
                }
                if( !file_exists($uploadFolder) ){
                    mkdir($uploadFolder, 0777);
                }

                if (move_uploaded_file($uploadData['tmp_name'], $uploadPath)) {
                    //$this->set('path', $fileName);
                    //$this->Dealer->Image->create();
                    //$this->Dealer->Image->save(array('Image' => array('dealer_id' => $id, 'path' => $fileName)));
                    return $fileName;
                    //return true;
                }
            }
        }
        return false;
    }
    function remove_image($type, $image_id){
        if(!empty($image_id)){
            if($type == 'store'){
                $image = $this->Dealer->Image->findById($image_id);
                if(!empty($image)){
                    $dealer_id = $image['Image']['dealer_id'];
                    $this->checkLogin($dealer_id);
                    if($this->Dealer->Image->delete($image_id)){
                        $copy_id = $this->Dealer->field('id', array('dealer_id' => $dealer_id));
                        if(!empty($copy_id)){
                            $copy_image_id = $this->Dealer->Image->field('id', array('dealer_id' => $copy_id, 'path' => $image['Image']['path']));
                            if(!empty($copy_image_id)){
                                $this->Dealer->Image->delete($copy_image_id);
                                unlink(WWW_ROOT . 'files/dealer_imgs/'.$copy_id.'/store/'.$image['Image']['path']);
                                if(is_file(WWW_ROOT . 'files/dealer_imgs/'.$copy_id.'/store/resized/'.$image['Image']['path'])){
                                    unlink(WWW_ROOT . 'files/dealer_imgs/'.$copy_id.'/store/resized/'.$image['Image']['path']);
                                }
                            }
                        }
                        unlink(WWW_ROOT . 'files/dealer_imgs/'.$dealer_id.'/store/'.$image['Image']['path']);
                        if(is_file(WWW_ROOT . 'files/dealer_imgs/'.$dealer_id.'/store/resized/'.$image['Image']['path'])){
                            unlink(WWW_ROOT . 'files/dealer_imgs/'.$dealer_id.'/store/resized/'.$image['Image']['path']);
                        }
                    }
                    $this->redirect('/dealers/images/'.$dealer_id);
                }
            }elseif($type == 'staff'){
                $staff = $this->Dealer->Staff->findById($image_id);
                if(!empty($staff)){
                    $dealer_id = $staff['Staff']['dealer_id'];
                    $this->checkLogin($dealer_id);
                    if($this->Dealer->Staff->save(array('id' => $image_id, 'photo' => ''))){
                        $copy_id = $this->Dealer->field('id', array('dealer_id' => $dealer_id));
                        if(!empty($copy_id)){
                            $copy_image_id = $this->Dealer->Staff->field('id', array('dealer_id' => $copy_id, 'photo' => $staff['Staff']['photo']));
                            if(!empty($copy_image_id)){
                                $this->Dealer->Staff->save(array('id' => $copy_image_id, 'photo' => ''));
                                unlink(WWW_ROOT . 'files/dealer_imgs/'.$copy_id.'/staff/'.$staff['Staff']['photo']);
                                if(is_file(WWW_ROOT . 'files/dealer_imgs/'.$copy_id.'/staff/resized/'.$staff['Staff']['photo'])){
                                    unlink(WWW_ROOT . 'files/dealer_imgs/'.$copy_id.'/staff/resized/'.$staff['Staff']['photo']);
                                }
                            }
                        }
                        unlink(WWW_ROOT . 'files/dealer_imgs/'.$dealer_id.'/staff/'.$staff['Staff']['photo']);
                        if(is_file(WWW_ROOT . 'files/dealer_imgs/'.$dealer_id.'/staff/resized/'.$staff['Staff']['photo'])){
                            unlink(WWW_ROOT . 'files/dealer_imgs/'.$dealer_id.'/staff/resized/'.$staff['Staff']['photo']);
                        }
                    }
                    $this->redirect('/dealers/staff/'.$dealer_id);
                }
            }elseif($type == 'promo'){
                $dealer = $this->Dealer->findById($image_id);
                if(!empty($dealer) && !empty($dealer['Dealer']['promo_image'])){
                    $this->checkLogin($image_id);
                    if($this->Dealer->save(array('id' => $image_id, 'promo_image' => ''), array('validate' => FALSE))){
                        $copy_id = $this->Dealer->field('id', array('dealer_id' => $image_id, 'promo_image' => $dealer['Dealer']['promo_image']));
                        if(!empty($copy_id)){
                            $this->Dealer->save(array('id' => $copy_id, 'promo_image' => ''));
                            unlink(WWW_ROOT . 'files/dealer_imgs/'.$copy_id.'/promo/'.$dealer['Dealer']['promo_image']);
                            if(is_file(WWW_ROOT . 'files/dealer_imgs/'.$copy_id.'/promo/resized/'.$dealer['Dealer']['promo_image'])){
                                unlink(WWW_ROOT . 'files/dealer_imgs/'.$copy_id.'/promo/resized/'.$dealer['Dealer']['promo_image']);
                            }
                        }
                        unlink(WWW_ROOT . 'files'.DS.'dealer_imgs'.DS.$image_id.DS.'promo'.DS.$dealer['Dealer']['promo_image']);
                        if(is_file(WWW_ROOT . 'files/dealer_imgs/'.$image_id.'/promo/resized/'.$dealer['Dealer']['promo_image'])){
                            unlink(WWW_ROOT . 'files/dealer_imgs/'.$image_id.'/promo/resized/'.$dealer['Dealer']['promo_image']);
                        }
                    }
                }
                $this->redirect('/dealers/show/'.$image_id);
            }
            //pr($image);
            //die();
        }
    }

    function verifyCAUS(){
        $inCAUS = null;
        #gets the country code of user's country selection
        $countryID = $this->Country->find('first', array('recursive' => -1, 'conditions' => array('id' => $this->data['Dealer']['country_id'])));
        #checks to see if this country is US or CA
        $inCAUS = $this->Country->find('first', array('recursive' => -1, 'conditions' => array('id' => $countryID['Country']['id'], 'abbreviation' => array('CA', 'US'))));
        return $inCAUS;
    }
    
    #adds zip to a dealer
    function zip( $id=null){
        $this->checkLogin($id); 
        $this->layout = "admin";
        $this->getQuery();
        $data = null;
        $zips = null;

        if (!empty($id)){
            $countryID = $this->Dealer->field('country_id', array('Dealer.id' => $id));
            $caID = $this->can_id;
            $usID = $this->us_id;
            if (!empty($this->data['Dealer']['zip']) && !empty($id)){
                $zipErrors = '';
                $zipsArr = explode(',',$this->data['Dealer']['zip']);
                foreach($zipsArr as $zip){
                    $isCA = false;
                    $zip = trim(preg_replace('/\s+/', '', $zip));
                    if($countryID == $caID) #if canadian postal code
                    {
                        $zip = strtoupper($zip);
                        if(strlen($zip) > 3) #if more than 3 characters for canadian postal, remove.
                        {
                            $zip = substr($zip, 0, 3);
                        }
                        $isCA = true;
                    }

                    $isZip = $this->Zipcode->getZipCode($zip, $isCA); #check to see if zip codes exist
                    if ($isZip){
                        if(!$this->Dealer->addZip($id, $zip)){
                            if(!empty($zipErrors)){
                                $zipErrors .= '<br/>';
                            }
                            $zipErrors .= "The zipcode you entered ($zip) does not exist.";
                        }
                    }else{
                        if(!empty($zipErrors)){
                            $zipErrors .= '<br/>';
                        }
                        $zipErrors .= "The zipcode you entered ($zip) does not exist.";
                    }
                }
                $this->set("zipError", $zipErrors);
            }

            $data = $this->Dealer->find('first', array('recursive' => 0, 'conditions' => array("Dealer.id" => $id)));
            $zips = $this->Dealer->DealersZipcode->find('all', array('fields' => array('zipcode'), 'conditions' => array('dealer_id' => $id)));
        }
        $this->set('data', $data);
        $this->set('zips', $zips);
        $this->set('countryList', $this->Country->getCountryList());
        $this->set('stateList',$this->State->find('list', array('sort' => 'position ASC')));
        $this->set('id', $id);
        $this->set('showZip', 1);
    }
    
    function get_dealers (){
        $this->checkLogin();
        $dealerName = $this->data['Dealer']['auto'];
        $this->set('dealers', $dealers = $this->Dealer->find('all', array('recursive' => -1, 'fields' => array('Dealer.name', 'Dealer.dealer_number'), 'limit' => 10, 'sort' => 'Dealer.name', 'conditions' => array('Dealer.dealer_id' => NULL, 'or' => array("Dealer.name LIKE" => '%'.$dealerName.'%', 'Dealer.dealer_number LIKE ' => '%'.$dealerName.'%')))));
        $this->layout = "ajax";
    }
    function delete_zip ($dealerID=null, $zip=null)
    {
        $this->checkLogin($dealerID);
        $this->layout = "";
        if($dealerID && $zip){
            $zip = trim(str_replace(" ", "", $zip));
            $this->Dealer->DealersZipcode->deleteAll(array('dealer_id' => $dealerID, 'zipcode_id' => $zip));
        }
        $this->redirect('/dealers/zip/'.$dealerID);
    }
    function delete_many_zips($dealerID=null){
        $this->checkLogin($dealerID);
        $this->layout = "";
        if(!empty($dealerID) && !empty($this->data['Zipcode']['remove'])){
            $this->Dealer->DealersZipcode->deleteAll(array('DealersZipcode.dealer_id' => $dealerID, 'DealersZipcode.zipcode_id' => explode(', ', $this->data['Zipcode']['remove'])));
        }
        $this->redirect('/dealers/zip/'.$dealerID);
    }
    
    function copy_zipcodes(){
        $this->checkLogin();
        if(!empty($this->data['Dealer']['auto']) && !empty($this->data['Dealer']['source']) && !empty($this->data['Dealer']['zipcodes'])){
            $sourceId = $this->data['Dealer']['source'];
            $errorMsg = '';
            $dealer_num = explode(' :: ', $this->data['Dealer']['auto']);
            $dealer_num = $dealer_num[0];
            $dealerId = $this->Dealer->field('id', array("dealer_number" => $dealer_num, 'dealer_id' => NULL));
            if(!empty($dealerId)){
                $this->Dealer->query("INSERT IGNORE INTO dealers_zipcodes (dealer_id, zipcode_id, zipcode) (SELECT ".$dealerId.", zipcode_id, zipcode FROM dealers_zipcodes WHERE dealer_id = ".$sourceId." AND zipcode in (".$this->data['Dealer']['zipcodes']."))");

                $errorMsg .= "<br/>Copied zipcode(s) to dealer $dealer_num";
            }else{
                $errorMsg .= 'Could not find the dealer to copy zipcodes to';
            }
            $data = $this->Dealer->find('first', array('recursive' => -1, 'conditions' => array("Dealer.id" => $sourceId)));
            
            $this->set('data',$data);
            $this->set('countryList', $this->Country->getCountryList());
            $this->set('stateList',$this->State->find('list', array('sort' => 'position ASC')));
            //$this->set('stateList',$this->State->generateList(null, 'position ASC'));
    
            $this->layout = 'admin';
            $this->getQuery();
            // render the zip view so we can display an error messages
            $this->flash($errorMsg, '/dealers/zip/'.$sourceId);
        }else{
            $this->flash('Required data not set', '/dealers');
        }
    }
    
    function test(){
        $this->layout = 'admin';
        echo 'HI';
    }
    
    public function login() {
        if (strpos($_SERVER['HTTP_HOST'], '.ca') !== false) {
            $this->redirect('http://www.sundancespas.com/hot-tub-dealer-locator/dealers/login');
        }
        //pr($this->Session->read('login'));
        $this->layout = "blank";
        $user = null;
        #reset 'Filter By' and view listings
        //$_SESSION['saveQuery'] = null;
        $this->Session->write('name', null);
        $this->Session->write('email', null);
        $this->Session->write('phone', null);
        $this->Session->write('city', null);
        $this->Session->write('zip', null);
        $this->Session->write('state_id', 0);
        $this->Session->write('country_id', $this->us_id);
        $this->Session->write('dealer_number', null);
        if(!empty($this->data['username']) && !empty($this->data['password'])){
            $permission_array = array();
            $user = $this->User->find('first', array('conditions' => array('username' => $this->data['username'], 'password' => $this->data['password'])));
            //pr($user);
            //die();
            if(!empty($user)){
                $login = array(
                    'user_id'=>$user['User']['id'], 
                    'name'=> $user['User']['firstname']." ".$user['User']['lastname'],
                    //'permission_ids'=> $permission_array,
                    'email'=>$user['User']['email'],
                    'group_id' => $user['Group']['id'],
                    'dealer_id' => $user['User']['dealer_id']
                );
                $this->Session->write('login', $login);
                if(!empty($user['User']['dealer_id'])){
                    $this->redirect('/dealers/show/'.$user['User']['dealer_id']);
                }else{
                    $this->redirect('/dealers/index');
                }
                /*if(!empty($user['Group'])){
                    foreach ($user['Group'] as $group){
                        $permission_array[] = $group['permission_id'];
                    }
                }
                $this->Session->write('login', array('user_id'=>$user['User']['id'], 
                    'name'=> $user['User']['firstname']." ".$user['User']['lastname'],
                    'permission_ids'=> $permission_array,
                    'email'=>$user['User']['email']));
                //pr($this->Session->read('login'));
                $this->redirect("/dealers/index");*/
            }else{
                $this->set("errormsg", "Login failed! Please try again.");
            }
        }
    }
    
    function delete_dealer($id){
        $this->checkLogin();
        $this->layout = 'blank';

        $this->email_notify_marketing($id, false);
        
        $this->Dealer->DealersZipcode->deleteAll(array('dealer_id' => $id), FALSE);
        $this->Dealer->delete($id, FALSE);
        $this->redirect('/dealers/index');
    }
    private function checkLogin($dealer_id = null){
        if ($this->Session->check("login")){
            $login = $this->Session->read("login");
            if (!empty($login['permission_ids'])){
                foreach($this->required_permissions as $required){
                    if (!in_array($required, $login['permission_ids'])){
                        $this->flash("You do not have permissions to access this area.<br>
                                     You will now be directed to the login page.", "/dealers/login", 3);
                    }
                }
            }
            if($login['group_id'] != 1){
                $dealer_copy_id = $this->Dealer->field('Dealer.id', array('Dealer.dealer_id' => $login['dealer_id']));
                if(empty($dealer_copy_id)){
                    $dealer_copy_id = $this->copy_dealer($login['dealer_id']);
                }
                if($this->action == 'zip' || $this->action == 'reject_dealer_changes'){
                    $this->flash("You do not have permissions to access this area.<br>
                                    You will now be directed to your dealer page.", "/dealers/show/".$dealer_copy_id, 3);
                }
                if($dealer_id == $login['dealer_id']){
                    if(in_array($this->action, array('images', 'show', 'services', 'quotes', 'staff'))){
                        $this->redirect('/dealers/'.$this->action.'/'.$dealer_copy_id);
                    }else{
                        $this->redirect('/dealers/show/'.$dealer_copy_id);
                    }
                }elseif($dealer_id != $dealer_copy_id){
                    $this->flash("You do not have permissions to access this area.<br>
                                    You will now be directed to your dealer page.", "/dealers/show/".$dealer_copy_id, 3);
                }
            }
        }else{
            $this->flash("You do not have permissions to access this area.<br>
                                     You will now be directed to the login page.", "/dealers/login", 3);
        }
        if(isset($login['group_id'])){
            return $login['group_id'];
        }else return FALSE;
    }
    
    function logout(){
        $this->Session->delete("login");
        $this->redirect("/dealers/login");
    }
    
    function export(){
        $this->checkLogin();
        $this->layout = "admin";
        $query = $this->getQuery(); #calls getQuery() to get $_POST data from index.thtml
        $this->set('countryList', $this->Country->getCountryList());
        $this->set('stateList', $this->State->find('list', array('sort' => 'position ASC')));
    }
    
    function export_view()
    {
        $this->checkLogin();
        ini_set("display_errors", false);
        ini_set("memory_limit","100M");
        $this->layout = "blank";
        
        #all Dealers
        $all = $this->Dealer->find('all', array('conditions' => array('Dealer.dealer_id IS NULL'), 'recursive' => 0));
        $this->set("all", $all);
        
        #all dealers who own zipcodes
        $dealers_zips = $this->Dealer->query("SELECT dz.zipcode_id, Dealer.dealer_number FROM dealers_zipcodes dz, dealers Dealer where dz.dealer_id = Dealer.id AND Dealer.dealer_id IS NULL");

        $this->set("dealers_zips", $dealers_zips);
        
        #filename of xls speadsheet
        $fileName = trim($_POST['filename']);
        if (empty($fileName)){
            $fileName = "new project";
        }
        $fileName .= ".xls";
        $this->set('fileName', $fileName);

        header("Pragma: public");
        header("Expires: 0");
        #header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        #header("Cache-Control: private",false); // required for certain browsers        
        header("Content-Type: application/force-download");
        header('Content-Disposition: attachment; filename="'.addslashes($fileName).'"' );
        #header("Content-Transfer-Encoding: binary\n");
    }
    
    function email_notify_approval_ready($id){
        $to = 'jonathan.davis@jacuzzi.com';

        // $to .= ', ' . 'someone-else@ninthlink.com';  // <--- to add another mail recipient uncomment this line and change email address

        $subject = 'Sundance Spas Dealer Approval Requested';

        $data = $this->Dealer->find('first', array('recursive' => -1, 'conditions' => array("Dealer.id" => $id)));
        if (!empty($data)) {
            $parent_link = Router::url('/', true).'dealers/show/'.$data['Dealer']['dealer_id'];
            $dealer_link = Router::url('/', true).'dealers/show/'.$data['Dealer']['id'];
            $message = '<html><head><title>' . $subject . '</title></head>';
            $message .= '<body><p>A dealer has requested approval for their changes:</p>
                <p>'.$data['Dealer']['name'].' (dealer number '.$data['Dealer']['dealer_number'].')</p>
                <p>You can view the current version at <a href="'.$parent_link.'">'.$parent_link.'</a> or view the dealer\'s changes at <a href="'.$dealer_link.'">'.$dealer_link.'</a></p>';
            $message .= '</body></html>';
            $headers = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Cc: martin.borsanyi@jacuzzi.com' . "\r\n";
			$headers .= 'Bcc: russell@ninthlink.com' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            mail( $to, $subject, $message, $headers);
        }
    }
    
    function pending(){
        $this->Session->write('pending', 'Y');
        $this->redirect('index');
    }

    function email_notify_marketing($id, $is_new = true)
    {
        $to = 'ron@ninthlink.com';

        // $to .= ', ' . 'someone-else@ninthlink.com';  // <--- to add another mail recipient uncomment this line and change email address

        if ($is_new) {
            $subject = 'New Sundance Spas Dealer Added';    
        }else {
            $subject = 'Sundance Spas Dealer Deleted';
        }

        $data = $this->Dealer->find('first', array('recursive' => -1, 'conditions' => array("Dealer.id" => $id)));
        if (!empty($data)) {
            $message = '<html><head><title>' . $subject . '</title></head>';
            $message .= '<body><p>A Sundance Spas dealer has been '.($is_new ? 'added' : 'deleted').'.</p>';
            $message .= '<p>'.$data['Dealer']['name'].'</p>'.
                        '<ul><li>ID: '.$data['Dealer']['id'].'</li>'.
                        '<li>Zip: '.$data['Dealer']['zip'].'</li></ul>'.
                        '</body></html>';
            $headers = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

            mail( $to, $subject, $message, $headers);
        }
    }
    function get_truckload_cities_json(){
        $cities = array_values(
            $this->Dealer->find(
                'all', array(
                    'conditions' => array(
                        //'default_promo' => 1,
                        'additional_html_end >=' => time(),
                        'published' => 'Y'
                        ),
                    'limit' => 5,
                    'fields' => array(
                        'city',
                        'slug',
                        'name',
                        'phone',
                        'address1',
                        'zip',
                        'website',
                        'additional_html_end',
                        'additional_html_start',
                        'alternate_truckload_address',
                        'alternate_truckload_city',
                        'alternate_truckload_state',
                        'alternate_truckload_zip',
                        'alternate_truckload_name'
                        ),
                    'order' => 'additional_html_end ASC',
                    'contain' => array(
                        'State' => array(
                            'name', 'abbreviation',
                            )
                        )
                    )
                )
            );
        $return = array();

        foreach($cities as $c){
            $state = str_replace(' ', '-', strtolower($c['State']['name'].'-'.$c['State']['abbreviation']));
            $return[] = array(
                'name' => $c['Dealer']['name'],
                'address' => $c['Dealer']['address1'],
                'city' => $c['Dealer']['city'],
                'state' => $c['State']['abbreviation'],
                'zip' => $c['Dealer']['zip'],
                'phone' => $c['Dealer']['phone'],
                'link' => '/'.$state.'/'.$c['Dealer']['slug'],
                'website' => $c['Dealer']['website'],
                'tl_name' => $c['Dealer']['alternate_truckload_name'],
                'tl_address' => $c['Dealer']['alternate_truckload_address'],
                'tl_city' => $c['Dealer']['alternate_truckload_city'],
                'tl-state' => $c['Dealer']['alternate_truckload_state'],
                'tl_zip' => $c['Dealer']['alternate_truckload_zip'],
                'start_date' => date('m-d-y', $c['Dealer']['additional_html_start']),
                'end_date' => date('m-d-y', $c['Dealer']['additional_html_end'])
                );
        }
        echo json_encode($return);
        die();
    }
}
?>
