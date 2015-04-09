<?php $admin = $this->Session->read('login.group_id');?>
<table id="content">
    <tr>
        <?php echo $this->element('filter', $filter); ?>
        <td id="main">
            <?php
            $err = FALSE;
            if(is_array($this->Form->validationErrors)){
                foreach($this->Form->validationErrors as $e){
                    if(!empty($e)){
                        $err = TRUE;
                        break;
                    }
                }
            }elseif(!empty($this->Form->validationErrors)){
                $err = TRUE;
            }
            if ($err){
                ?>
                <div class="error-banner">Please correct the errors below.</div>

            <?php
            }
            echo $this->element('dealer_tabs');?>
            <div>Place a checkmark next to each service your dealership provides. Click "Save and Continue Editing" to add more, or "Save and Request Approval" if you are done editing your dealer information.</div>
            <?php $disabled = FALSE;
            if($admin == 2){
                unset($copy_id);
                unset($orig_data);
            }
            if(isset($copy_id) && isset($changed)){
                $disabled = TRUE;?>
                <div>The services have been altered by the dealer.  You can view the changes <?php echo $this->Html->link('here', '/dealers/services/'.$copy_id);?></div>
            <?php }elseif($group_id == 1 && isset($orig_id)){?>
                <div>This is a dealer-modified copy of <?php echo $this->Html->link('Dealer '.$orig_id, '/dealers/services/'.$orig_id);?>.</div>
            <?php } 
            if(isset($orig_data)){
                echo '<div style="background-color:#FF9F9F">'.(isset($copy_id) ? 'Dealer\'s Version' : 'Original').':<br />'.$this->Form->select('DealersService.service_id_copy', $services, array('multiple' => 'checkbox', 'value' => $orig_data, 'disabled' => TRUE)).'</div>'.(isset($copy_id) ? 'Original' : 'Dealer\'s Version').':';
            }
            echo $this->Form->create('DealersService');
            echo $this->Form->select(
                'DealersService.service_id',
                $services,
                array('multiple' => 'checkbox', 'value' => $data, 'disabled' => $disabled)
            );
            if($admin == 2){?>
                <div class="form-bottom">
                    <input type="button" style="width:auto" value="Save and Continue Editing" onclick="saveDealer()" />
                    <input type="button" style="width:auto" onclick="if(confirm('Are you sure you want to submit your changes for approval?')){saveApproveDealer();return false;}" value="Save And Request Approval" />
                </div>
                <?php echo $this->Form->end();?>
            <?php }else{
                echo $this->Form->end(array('label' => 'Save', 'disabled' => $disabled));
            }?>
        </td>
    </tr>
</table>
<script language="JavaScript" type="text/javascript">
    function saveDealer(){
        $('DealersServiceServicesForm').submit(); //submit form-dealers
    }
    
    function saveApproveDealer(){
        $('DealersServiceServicesForm').setAttribute('action', '<?php echo Router::url(null, true);?>/1');
        saveDealer();
    }
</script>