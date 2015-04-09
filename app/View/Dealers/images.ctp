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
            <div>Upload up to 4 images that will appear at the top of your dealer page. Images, for example, might show your showroom floor or the front of your building. Images will rotate automatically. <br>Click "Save and Continue Editing" to add more, or "Save and Request Approval" if you are done editing your dealer information. <br><a href="http://www.jacuzzi.com/hot-tubs/dealer-locator/files/Dealer-Images.pdf">To learn more about uploading dealer images, please click here to download the instructional pdf</a>.</div> 
            <div class="error-banner">Images will be scaled and cropped to 304px by 317px.</div>
            <?php $disabled = FALSE;
            if($admin == 2){
                unset($copy_id);
                unset($orig_data);
            }
            if(isset($copy_id) && isset($changed)){
                $disabled = TRUE;?>
                <div>The images have been altered by the dealer.  You can view the changes <?php echo $this->Html->link('here', '/dealers/images/'.$copy_id);?></div>
            <?php }elseif($group_id == 1 && isset($orig_id)){?>
                <div>This is a dealer-modified copy of <?php echo $this->Html->link('Dealer '.$orig_id, '/dealers/images/'.$orig_id);?>.</div>
            <?php }
            echo $this->Form->create('Dealer', array( 'type' => 'file'));?>
            <table>
            <?php
            for($i = 0; $i < 4; $i++){
                echo '<tr><td class="form-label">Image #'.($i+1).':</td><td class="form-data">';
                if(isset($data[$i]) && !empty($data[$i])){
                    echo $this->Form->hidden('Image.'.$i.'.path', array('disabled' => $disabled, 'value' => $data[$i]['Image']['path']));
                    //echo $this->Image->resize('/files/dealer_imgs/'.$id.'/store/'.$data[$i]['Image']['path'], 304, 317, array('class' => 'dealerimg'));
                    echo '<img src="'.$this->Html->url($this->Image->resizedUrl('/files/dealer_imgs/'.$id.'/store/'.$data[$i]['Image']['path'], 304, 317, array('class' => 'dealerimg'))).'?'.rand(10000, 99999).'" />';

                    if(!$disabled){
                        echo '<br />';
                        echo $this->Html->link('Crop Image', '/dealers/image_crop/'.$id.'/store/'.$data[$i]['Image']['id'], array(), 'Are you sure you want to crop this image?').' | ';
                        echo $this->Html->link('Remove Image #'.($i+1), '/dealers/remove_image/store/'.$data[$i]['Image']['id'], array(), 'Are you sure you want to remove and delete this image?');
                    }
                    //link(string $title, mixed $url = null, array $options = array(), string $confirmMessage = false)
                }else{
                    echo $this->Form->input('Image.'.$i.'.path', array('type' => 'file','label' => FALSE, 'disabled' => $disabled));
                }
                if(isset($orig_data)){
                    if(!isset($orig_data[$i])){
                        $orig_data[$i] = array('Image' => array('path' => ''));
                    }
                    echo '<tr><td class="form-label" style="background-color:FF9F9F"><label>'.(isset($copy_id) ? 'Dealer\'s Version' : 'Original').'</label></td><td class="form-data">';
                    echo (empty($orig_data[$i]['Image']['path']) ? '' : '<img src="'.$this->Html->url($this->Image->resizedUrl('/files/dealer_imgs/'.(isset($copy_id) ? $copy_id : $orig_id).'/store/'.$orig_data[$i]['Image']['path'], 304, 317, array('class' => 'dealerimg'))).'?'.rand(10000, 99999).'" />').'</td></tr>';
                }
                echo '</td></tr>';
            }?>
            </table>
            <?php if($admin == 2){?>
                <div class="form-bottom">
                    <input type="button" style="width:auto" value="Upload and Continue Editing" onclick="saveDealer()" />
                    <input type="button" style="width:auto" onclick="if(confirm('Are you sure you want to submit your changes for approval?')){saveApproveDealer();return false;}" value="Upload And Request Approval" />
                </div>
                <?php echo $this->Form->end();?>
            <?php }else{
                echo $this->Form->end(array('label' => 'Upload', 'disabled' => $disabled));
            }?>
        </td>
    </tr>
</table>
<script language="JavaScript" type="text/javascript">
    function saveDealer(){
        $('DealerImagesForm').submit(); //submit form-dealers
    }
    
    function saveApproveDealer(){
        $('DealerImagesForm').setAttribute('action', '<?php echo Router::url(null, true);?>/1');
        saveDealer();
    }
</script>