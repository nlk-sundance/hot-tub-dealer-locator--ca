<?php if (!empty($id)) { ?>
    <div class="tabs">
        <?php
        $tabs = array(
            'show' => 'Dealer Detail',
            'quotes' => 'Quotes',
            'services' => 'Services',
            'images' => 'Images',
            'staff' => 'Staff'
        );
        #can only own zip codes if in Canada or United States so don't show 
        $admin = $this->Session->read('login.group_id');
        if($showZip && $admin == 1){
            $tabs['zip'] = 'Zipcodes';
        }
        foreach($tabs as $link => $name){
            if($this->action == $link){
                $options = array('id' => 'tab-on');
            }else{
                $options = array();
            }
            echo $this->Html->link($name, '/dealers/'.$link.'/' . $id, $options);
        }
        ?>
    </div>
<?php }?>