<script language="javascript" type="text/javascript">
    function limitText(limitField, limitCount, limitNum) {
        if (limitField.value.length > limitNum) {
            limitField.value = limitField.value.substring(0, limitNum);
        } else {
            var num_left = limitNum - limitField.value.length;
            limitCount.update(num_left+'');
        }
    }
</script>
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
            if(isset($msg)){
                echo '<div class="error-banner">'.$msg.'</div>';
            }
            if ($err){
                ?>
                <div class="error-banner">Please correct the errors below.</div>

            <?php
            }
            echo $this->element('dealer_tabs');?>
            <div>Enter up to four quotes/testimonials that will rotate automatically at the top of your dealer page. For each quote, enter the content/copy in the larger boxes, and the person's name (and location, if desired), in the "By" box below each quote box. If no quotes are entered, default quotes will be displayed. Click "Save and Continue Editing" to add more, or "Save and Request Approval" if you are done editing your dealer information.</div>
            <?php $disabled = FALSE;
            if($admin == 2){
                unset($copy_id);
                unset($orig_data);
            }
            if(isset($copy_id) && isset($changed)){
                $disabled = TRUE;?>
                <div>The quotes have been altered by the dealer.  You can view the changes <?php echo $this->Html->link('here', '/dealers/quotes/'.$copy_id);?></div>
            <?php }elseif($group_id == 1 && isset($orig_id)){?>
                <div>This is a dealer-modified copy of <?php echo $this->Html->link('Dealer '.$orig_id, '/dealers/quotes/'.$orig_id);?>.</div>
            <?php } 
            echo $this->Form->create('Dealer', array('action' => 'quotes/' . $id, 'type' => 'post', 'id' => 'form-dealers'));
            ?>
                <table>
                    <?php 
                    for($i = 0; $i < 4; $i++){
                        if(isset($data[$i])){
                            $quote = $data[$i]['Quote'];
                        }else{
                            $quote = array(
                                'id' => 0,
                                'dealer_id' => $id,
                                'quote' => '',
                                'name' => ''
                            );
                        }
                        $options = array('disabled' => $disabled, 'label' => 'Quote #'.($i+1), 'between' => '</td><td class="form-data">', 'format' => array('before', 'label', 'between', 'input', 'error', 'after'), 'div' => array('tag'=> 'tr'), 'before' => '<td class="form-label">', 'after' => '</td>', 'default' => $quote['quote']);
                        $count_options = array();
                        if(!$disabled){
                            $count_options['onKeyDown'] = "limitText($('Quote".$i."Quote'),$('countdown".$i."'),330);";
                            $count_options['onKeyUp'] = "limitText($('Quote".$i."Quote'),$('countdown".$i."'),330);";
                            $count_options['after'] = '<br /><font size="1"><span size="1" id="countdown'.$i.'">'.(330 - strlen($quote['quote'])).'</span> of 330 characters remaining.</font></td>';
                        }
                        if(isset($quote['id']) && !empty($quote['id'])){
                            echo $this->Form->hidden('Quote.'.$i.'.id', array('value' => $quote['id']));
                        }
                        echo $this->Form->input('Quote.'.$i.'.quote', array_merge($options, $count_options));
                        $options['label'] = 'By';
                        $options['default'] = $quote['name'];
                        echo $this->Form->input('Quote.'.$i.'.name', $options);
                        if(isset($orig_data)){
                            if(!isset($orig_data[$i])){
                                $orig_data[$i] = array('Quote' => array('quote' => '', 'name' => ''));
                            }
                            echo '<tr><td class="form-label" style="background-color:FF9F9F"><label>'.(isset($copy_id) ? 'Dealer\'s Version' : 'Original').'</label></td><td class="form-data">"'.$orig_data[$i]['Quote']['quote'].'"<br /><br />By "'.$orig_data[$i]['Quote']['name'].'"</td></tr>';
                        }
                    }?>
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
        $('form-dealers').submit(); //submit form-dealers
    }
    
    function saveApproveDealer(){
        $('form-dealers').setAttribute('action', '<?php echo Router::url(null, true);?>/1');
        saveDealer();
    }
</script>