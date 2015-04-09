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
            echo $this->element('dealer_tabs');
            ?>
            <div>For each staff member, please enter their name, position, select an image (optional), and a brief description of their experience. Images will be scaled and cropperd to 220px by 162px. You can find a FREE online image editor at <a href="https://pixlr.com/editor/" target="_blank">https://pixlr.com/editor/</a>
            <br>Click "Save and Continue Editing" to add more, or "Save and Request Approval" if you are done editing your dealer information. </div>
            <?php $disabled = FALSE;
            if($admin == 2){
                unset($copy_id);
                unset($orig_data);
            }
            if(isset($copy_id) && isset($changed)){
                $disabled = TRUE;?>
                <div>The staff data have been altered by the dealer.  You can view the changes <?php echo $this->Html->link('here', '/dealers/staff/'.$copy_id);?></div>
            <?php }elseif($group_id == 1 && isset($orig_id)){?>
                <div>This is a dealer-modified copy of <?php echo $this->Html->link('Dealer '.$orig_id, '/dealers/staff/'.$orig_id);?>.</div>
            <?php } 
            echo $this->Form->create('Dealer', array( 'type' => 'file'));?>
            <table id="list">
                <tr>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Photo</th>
                    <th>Description</th>
                    <th>Delete</th>
                </tr>
                <?php
                $i = 0;
                foreach($data as $s){?>
                    <tr class="<?php echo ($i % 2) ? 'on' : '';?>">
                        <td>
                            <?php echo $this->Form->hidden('Staff.'.$s['Staff']['id'].'.id', array('value' => $s['Staff']['id']));?>
                            <?php echo $this->Form->input('Staff.'.$s['Staff']['id'].'.name', array('label' => FALSE, 'default' => $s['Staff']['name'], 'disabled' => $disabled));?>
                        </td>
                        <td>
                            <?php echo $this->Form->input('Staff.'.$s['Staff']['id'].'.position', array('label' => FALSE, 'default' => $s['Staff']['position'], 'disabled' => $disabled));?>
                        </td>
                        <td>
                            <?php if(!empty($s['Staff']['photo'])){?>
                                <?php echo '<img src="'.$this->Html->url($this->Image->resizedUrl('/files/dealer_imgs/'.$id.'/staff/'.$s['Staff']['photo'], 220, 162, array('class' => 'dealerimg'))).'?'.rand(10000, 99999).'" />';?>
                                <?php //echo $this->Image->resize('/files/dealer_imgs/'.$id.'/staff/'.$s['Staff']['photo'], 220, 162);?>
                                <br />
                                <?php if(!$disabled){
                                    echo $this->Html->link('Crop Image', '/dealers/image_crop/'.$id.'/staff/'.$s['Staff']['id'], array(), 'Are you sure you want to crop this image?').' | ';
                                    echo $this->Html->link('Remove Photo', '/dealers/remove_image/staff/'.$s['Staff']['id'], array(), 'Are you sure you want to remove and delete this image?');
                                }
                            }else{
                                echo $this->Form->input('Staff.'.$s['Staff']['id'].'.photo', array('type' => 'file','label' => FALSE, 'disabled' => $disabled));
                            }
                            ?>
                        </td>
                        <td>
                            <?php echo $this->Form->input('Staff.'.$s['Staff']['id'].'.description', array('label' => FALSE, 'default' => $s['Staff']['description'], 'disabled' => $disabled));?>
                        </td>
                        <td>
                            <?php if(!$disabled){
                                echo $this->Html->link('Delete', '/dealers/delete_staff/'.$s['Staff']['id'], array(), 'Are you sure you want to delete this staff member?');
                            }?>
                        </td>
                    </tr>
                    <?php if(isset($orig_data)){
                        if(!isset($orig_data[$i])){
                            $orig_data[$i] = array('Staff' => array('name' => '', 'position' => '', 'description' => '', 'photo' => ''));
                        }
                        echo '<tr><td colspan="5" style="background-color:FF9F9F"><label>'.(isset($copy_id) ? 'Dealer\'s Version' : 'Original').':</label></td></tr><tr><td class="form-label" style="background-color:FF9F9F">'.$orig_data[$i]['Staff']['name'].'</td><td style="background-color:FF9F9F">'.$orig_data[$i]['Staff']['position'].'</td><td style="background-color:FF9F9F">'.(!empty($orig_data[$i]['Staff']['photo']) ? '<img src="'.$this->Html->url($this->Image->resizedUrl('/files/dealer_imgs/'.(isset($copy_id) ? $copy_id : $orig_id).'/staff/'.$orig_data[$i]['Staff']['photo'], 220, 162, array('class' => 'dealerimg'))).'?'.rand(10000, 99999).'" />' : '').'</td><td style="background-color:FF9F9F">'.$orig_data[$i]['Staff']['description'].'</td><td style="background-color:FF9F9F"></td></tr>';
                    }?>
                <?php $i++;
                }
                if(!$disabled){?>
                    <tr>
                        <td colspan="5">
                            Add new:
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo $this->Form->input('Staff.0.name', array('label' => FALSE, 'required' => FALSE));?>
                        </td>
                        <td>
                            <?php echo $this->Form->input('Staff.0.position', array('label' => FALSE));?>
                        </td>
                        <td>
                            <?php echo $this->Form->input('Staff.0.photo', array('type' => 'file','label' => FALSE));?>
                        </td>
                        <td>
                            <?php echo $this->Form->input('Staff.0.description', array('label' => FALSE));?>
                        </td>
                        <td></td>
                    </tr>
                <?php }?>
            </table>
            <?php if($admin == 2){?>
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
        $('DealerStaffForm').submit(); //submit form-dealers
    }
    
    function saveApproveDealer(){
        $('DealerStaffForm').setAttribute('action', '<?php echo Router::url(null, true);?>/1');
        saveDealer();
    }
</script>