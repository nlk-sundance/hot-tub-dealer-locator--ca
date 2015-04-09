<?php //echo $javascript->link('datechooser'); ?>
<?php echo $this->Html->script('tinymce/tinymce.min');?>
<?php 
$admin = $this->Session->read('login.group_id');
if($admin == 1){?>
    <?php echo $this->Html->script('datechooser', array('inline' => TRUE)); ?>
    <?php echo $this->Html->css('datechooser', array('inline' => TRUE)); ?>
    <?php //echo $html->css('datechooser'); ?>
    <script type="text/javascript">
        events.add(window, 'load', WindowLoad);
        function WindowLoad(){
                var start_date = document.getElementById('start_date_div');
                start_date.DateChooser = new DateChooser();
                start_date.DateChooser.setXOffset(5);
                start_date.DateChooser.setYOffset(-5);
                start_date.DateChooser.setUpdateField('DealerAdditionalHtmlStart', 'M j, Y');
                start_date.DateChooser.setIcon('<?php echo $this->Html->url("/img/datechooser.png"); ?>', 'DealerAdditionalHtmlStart');

                var end_date = document.getElementById('end_date_div');
                end_date.DateChooser = new DateChooser();
                end_date.DateChooser.setXOffset(5);
                end_date.DateChooser.setYOffset(-5);
                end_date.DateChooser.setUpdateField('DealerAdditionalHtmlEnd', 'M j, Y');
                end_date.DateChooser.setIcon('<?php echo $this->Html->url("/img/datechooser.png"); ?>', 'DealerAdditionalHtmlEnd');

                var start_sale_date = document.getElementById('start_sale_date_div');
                start_sale_date.DateChooser = new DateChooser();
                start_sale_date.DateChooser.setXOffset(5);
                start_sale_date.DateChooser.setYOffset(-5);
                start_sale_date.DateChooser.setUpdateField('DealerAdditionalHtmlStartSale', 'M j, Y');
                start_sale_date.DateChooser.setIcon('<?php echo $this->Html->url("/img/datechooser.png"); ?>', 'DealerAdditionalHtmlStartSale');
        }
    </script>
<?php }?>
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
            if(isset($dealer_approval_id)){
                echo $this->Html->link('This dealer\'s changes are ready for approval.', '/dealers/show/'.$dealer_approval_id).'<br /><br />';
            }
            echo $this->element('dealer_tabs');
                ?>
            <?php
            if (!empty($data['Dealer']['id'])){
                ?>
                <?php echo $this->Form->create('Dealer', array('action' => 'show/' . $data['Dealer']['id'], 'type' => 'file', 'id' => 'form-dealers'));?>
                <!--form method="post" action="<?php //echo $html->url('/dealers/show/' . $data['Dealer']['id']); ?>" id="form-dealers"-->
                <?php
            }else{
                ?>
                <?php echo $this->Form->create('Dealer', array('action' => 'show', 'type' => 'post', 'id' => 'form-dealers'));?>
                    <!--form method="post" action="<?php //echo $html->url('/dealers/show'); ?>" id="form-dealers"-->
                <?php
            }
            echo $this->Form->hidden('Save.action', array('id' => "input-action")); #hidden id input-action
            echo $this->Form->hidden('Dealer.id', array('value' => $data['Dealer']['id']));
            ?>
                    <?php
                    //$dealer_fields => array('name', )
                    if($admin == 1){
                        if(empty($data['Dealer']['dealer_id'])){
                            echo 'Dealer User Fields:';
                            echo '<table>';
                            $user_fields = array(
                                'username' => array('label' => 'Username'),
                                'password' => array('label' => 'Password'),
                                'firstname' => array('label' => 'First Name'),
                                'lastname' => array('label' => 'Last Name'),
                                'email' => array('label' => 'Email')
                            );
                            if(isset($data['User']['id'])){
                                $user_fields['id'] = array('type' => 'hidden');
                            }
                            foreach($user_fields as $field_name => $field){
                                $options = array('between' => '</td><td class="form-data">', 'format' => array('before', 'label', 'between', 'input', 'error', 'after'), 'div' => array('tag'=> 'tr'), 'before' => '<td class="form-label">', 'after' => '</td>', 'default' => (isset($data['User'][$field_name]) ? $data['User'][$field_name] : ''));
                                if(!empty($field)){
                                    $options = array_merge($options, $field);
                                }
                                echo $this->Form->input('User.'.$field_name, $options);
                            }
                            echo '</table><br />Dealer Fields:';
                        }else{
                            echo 'This is a dealer-modified copy of '.$this->Html->link('Dealer '.$data['Dealer']['dealer_id'], '/dealers/show/'.$data['Dealer']['dealer_id']).'.';
                        }
                    }?>
                    <table>
                        <?php
                        $fields = array(
                            'dealer_number' => array('dealer_limit' => TRUE),
                            'name' => array(),
                            'address1' => array('label' => 'Address Line 1', 'dealer_limit' => TRUE),
                            'address2' => array('label' => 'Address Line 2', 'dealer_limit' => TRUE),
                            'city' => array('dealer_limit' => TRUE, 'onChange' => 'changeSlug(this);'),
                            'zip' => array('label' => 'Zip Code', 'dealer_limit' => TRUE),
                            'state_id' => array('options' => $stateList, 'dealer_limit' => TRUE),
                            'country_id' => array('options' => $countryList, 'dealer_limit' => TRUE),
                            'region_num' => array('label' => 'Region #', 'dealer_limit' => TRUE),
                            'email' => array(),
                            'phone' => array('label' => 'Phone 1'),
                            'phone2' => array('label' => 'Phone 2'),
                            'fax' => array(),
                            'website' => array('dealer_limit' => TRUE),
                            'published' => array('type' => 'select', 'options' => array('Y' => 'Yes', 'N' => 'No'), 'dealer_limit' => TRUE),
                            'additional_html_dates' => array('dealer_limit' => TRUE),
                            'default_promo' => array('type' => 'select', 'options' => array(0 => 'No', 1 => 'Yes'), 'label' => 'Include Default Truckload Promo', 'dealer_limit' => TRUE),
                            'additional_html' => array('style' => 'width:100%;height:200px;', 'label' => 'Additional HTML', 'dealer_limit' => TRUE),
                            'url_redirect' => array('label' => 'Custom URL Redirect', 'dealer_limit' => TRUE),
                            'about_title' => array(),
                            'about_body' => array('wysiwyg' => 'undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent', 'label' => 'About Body'),
                            'services_text' => array('wysiwyg' => 'undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent', 'label' => 'Services SEO Text'),
                            'staff_text' => array('wysiwyg' => 'undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent', 'label' => 'Staff SEO Text'),
                            'hours' => array('label' => 'Store Hours', 'wysiwyg' => 'undo redo'),
                            'latitude' => array('dealer_limit' => TRUE),
                            'longitude' => array('dealer_limit' => TRUE),
                            'slug' => array('dealer_limit' => TRUE, 'label' => 'Custom City URL')
                        );
                        if($admin == 2){
                            $fields['name']['disabled'] = 'disabled';
                        }
                        if(empty($data['Dealer']['promo_image'])){
                            $fields['promo_image'] = array('type' => 'file');
                            $fields['promo_image']['after'] = '<br /><font color="red"><b>Image will be scaled and cropped to 640px by 100px.</b></font><br />You can find a FREE online image editor at <a href="https://pixlr.com/editor/" target="_blank">https://pixlr.com/editor/</a>
                            </td>';
                        }
                        $fields['longitude']['after'] = '<br />Please go to <a href="http://www.latlong.net/" target="_blank">http://www.latlong.net/</a> to find the latitude and longitude of an address
                            </td>';
                        $fields['url_redirect']['after'] = '<br /><font color="red"><b><u>PLEASE FORMAT URL AS:</u>&nbsp;&nbsp;&nbsp;http://www.website.com</b></font>
                            </td>';
                        $fields['about_title']['after'] = '<br /><font color="black"><a href="'.$this->Html->url('/files/SDS_Writing_Style_Guide_for_Dealers.pdf').'" target="_blank">Please click here for dealer writing guidelines</a>.</font>
                            </td>';
                        $fields['website']['after'] = '<br /><font color="red"><b><u>PLEASE FORMAT WEBSITE URL AS:</u>&nbsp;&nbsp;&nbsp;http://www.website.com</b></font>
                            </td>';
                        $fields['country_id']['after'] = ' ' . $this->Html->link('Add country', '/add_country/' . $data['Dealer']['id'], array('onClick' => 'showAddCountry(); return false;')).'
                                </div>
                                <div id="add-country" style="display:none">
                                    <table>
                                        <tr>
                                            <td class="form-label"> New Country:</td>
                                            <td class="form-data">
                                                <input type="text" name="countryName" value="" id="country-name" maxlength="45" /><br/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="form-label">Abbreviation:</td>
                                            <td class="form-data">
                                                <input type="text" name="countryAbbreviation" value="" id="country-abbreviation" maxlength="5" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="form-data" colspan="2">
                                                <input type="submit" name="addNewCountry" value="Add">
                                                <input type="button" onClick="hideAddCountry()" value="Cancel">
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </td>
                        </tr>';
                        $fields['country_id']['between'] = '<td class="form-data">
                                <div id="country-sel">';
                        foreach($fields as $field_name => $field){
                            if(($admin == 1 && (!isset($data['Dealer']['dealer_id']) || empty($data['Dealer']['dealer_id']))) || !isset($field['dealer_limit'])){
                                if(isset($field['model'])){
                                    $model = $field['model'];
                                    unset($field['model']);
                                }else $model = 'Dealer';
                                $options = array('between' => '</td><td class="form-data">', 'format' => array('before', 'label', 'between', 'input', 'error', 'after'), 'div' => array('tag'=> 'tr'), 'before' => '<td class="form-label">', 'after' => '</td>', 'default' => (isset($data[$model][$field_name]) ? $data[$model][$field_name] : ''));
                                if(!empty($field)){
                                    $options = array_merge($options, $field);
                                }
                                if($field_name == 'additional_html_dates'){?>
                                    <tr>
                                        <td class="form-label">Additional HTML Dates</td>
                                        <td class="form-data">
                                            <div id="start_date_div">
                                                <input type="text" id="DealerAdditionalHtmlStart" readonly="readonly" name="data[Date][additional_html_start]" value="<?php echo (isset($data['Date']['additional_html_start']) ? htmlentities($data['Date']['additional_html_start'], ENT_QUOTES, 'UTF-8') : ''); ?>"/>
                                            </div>
                                            through
                                            <div id="end_date_div">
                                                <input type="text" id="DealerAdditionalHtmlEnd" readonly="readonly" name="data[Date][additional_html_end]" value="<?php echo (isset($data['Date']['additional_html_end']) ? htmlentities($data['Date']['additional_html_end'], ENT_QUOTES, 'UTF-8') : ''); ?>"/>
                                            </div>
                                                <input type="button" value="Clear Dates" onClick="$('DealerAdditionalHtmlStart').value='';$('DealerAdditionalHtmlEnd').value='';" />
                                            <?php echo $this->Form->error('Dealer.additional_html_start_empty', 'You must enter a start date if you want to set an end date.') ?>
                                            <?php echo $this->Form->error('Dealer.additional_html_end_empty', 'You must enter an end date if you want to set a start date.') ?>
                                            <?php echo $this->Form->error('Dealer.additional_html_end_early', 'Please select an end date that is after the start date.') ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="form-label">Optional Sale Start Date</td>
                                        <td class="form-data">
                                            <div id="start_sale_date_div">
                                                <input type="text" id="DealerAdditionalHtmlStartSale" readonly="readonly" name="data[Date][additional_html_start_sale]" value="<?php echo (isset($data['Date']['additional_html_start_sale']) ? htmlentities($data['Date']['additional_html_start_sale'], ENT_QUOTES, 'UTF-8') : ''); ?>"/>
                                            </div>
                                                <input type="button" value="Clear Date" onClick="$('DealerAdditionalHtmlStartSale').value='';" />
                                        </td>
                                    </tr>
                                <?php }elseif(isset($field['wysiwyg'])){
                                    $wysiwyg = $field['wysiwyg'];
                                    $wysiwyg_options = array('width' => '500px', 'toolbar_items_size' => 'small', 'force_br_newlines' => 'true', 'forced_root_block' => "", 'force_p_newlines' => 'false', 'menubar' => 'false', 'toolbar' => $wysiwyg);
                                    if((isset($presave_data) && isset($orig_dealer_data) && $orig_dealer_data['Dealer'][$field_name] != $presave_data['Dealer'][$field_name]) || (!isset($presave_data) && isset($orig_dealer_data) && $orig_dealer_data['Dealer'][$field_name] != $data['Dealer'][$field_name])){
                                        if(isset($disable_changed_fields)){
                                            $wysiwyg_options['readonly'] = 1;
                                        }
                                        $after_field = '<tr><td class="form-label" style="background-color:FF9F9F"><label>'.(isset($disable_changed_fields) ? 'Dealer\'s Version' : 'Original').'</label></td><td class="form-data">'.$orig_dealer_data['Dealer'][$field_name].'</td></tr>';
                                    }else $after_field = '';
                                    unset($field['wysiwyg']);
                                    $field['value'] = $data[$model][$field_name];
                                    ?>
                                    <tr>
                                        <td class="form-label"><?php echo (isset($field['label']) ? $field['label'] : $field_name);?></td>
                                        <td class="form-data">
                                            <?php echo $this->Wysiwyg->textarea($model.'.'.$field_name, $field, $wysiwyg_options);?>
                                        </td>
                                    </tr>
                                <?php 
                                    echo $after_field;
                                }else{
                                    if(!in_array($field_name, array('published', 'id', 'dealer_id', 'approval_ready')) && ((isset($presave_data) && isset($orig_dealer_data) && $orig_dealer_data['Dealer'][$field_name] != $presave_data['Dealer'][$field_name]) || (!isset($presave_data) && isset($orig_dealer_data) && $orig_dealer_data['Dealer'][$field_name] != $data['Dealer'][$field_name]))){
                                        if($field_name == 'promo_image'){
                                            if(empty($orig_dealer_data['Dealer']['promo_image'])){
                                                $orig_value = 'None';
                                            }else{
                                                $orig_value = '<img src="'.$this->Html->url($this->Image->resizedUrl('/files/dealer_imgs/'.$orig_dealer_data['Dealer']['id'].'/promo/'.$orig_dealer_data['Dealer']['promo_image'], 640, 100)).'?'.rand(10000, 99999).'" />';
                                                //$orig_value = $this->Image->resize('/files/dealer_imgs/'.$orig_dealer_data['Dealer']['id'].'/promo/'.$orig_dealer_data['Dealer']['promo_image'], 640, 100);
                                            }
                                        }else{
                                            $orig_value = $orig_dealer_data['Dealer'][$field_name];
                                        }
                                        if(isset($disable_changed_fields)){
                                            $options['disabled'] = 'disabled';
                                        }
                                        $after_field = '<tr><td class="form-label" style="background-color:FF9F9F"><label>'.(isset($disable_changed_fields) ? 'Dealer\'s Version' : 'Original').'</label></td><td class="form-data">'.$orig_value.'</td></tr>';
                                    }else $after_field = '';
                                    echo $this->Form->input($model.'.'.$field_name, $options);
                                    echo $after_field;
                                }
                            }
                        }
                        if(!empty($data['Dealer']['promo_image'])){?>
                            <tr>
                                <td class="form-label">Promo Image</td>
                                <td class="form-data">
                                    <?php if(is_file(WWW_ROOT.'files/dealer_imgs/'.$id.'/promo/'.$data['Dealer']['promo_image'])){
                                        echo '<img src="'.$this->Html->url($this->Image->resizedUrl('/files/dealer_imgs/'.$id.'/promo/'.$data['Dealer']['promo_image'], 640, 100)).'?'.rand(10000, 99999).'" />';
                                    }?>
                                    <?php if(!isset($promo_image_changed) && ((!isset($orig_dealer_data) || $orig_dealer_data['Dealer']['promo_image'] == $data['Dealer']['promo_image']))){?>
                                        <br />
                                        <?php echo $this->Html->link('Crop Image', '/dealers/image_crop/'.$id.'/promo', array(), 'Are you sure you want to crop this image?');?> |
                                        <?php echo $this->Html->link('Remove Image', '/dealers/remove_image/promo/'.$id, array(), 'Are you sure you want to remove and delete this image?');?>
                                    <?php }?>
                                </td>
                            </tr>
                            <?php if(isset($promo_image_changed) || (isset($orig_dealer_data) && $orig_dealer_data['Dealer']['promo_image'] != $data['Dealer']['promo_image'])){
                                if(empty($orig_dealer_data['Dealer']['promo_image'])){
                                    $orig_value = 'None';
                                }else{
                                    $orig_value = '<img src="'.$this->Html->url($this->Image->resizedUrl('/files/dealer_imgs/'.$orig_dealer_data['Dealer']['id'].'/promo/'.$orig_dealer_data['Dealer']['promo_image'], 640, 100)).'?'.rand(10000, 99999).'" />';
                                    //$orig_value = $this->Image->resize('/files/dealer_imgs/'.$orig_dealer_data['Dealer']['id'].'/promo/'.$orig_dealer_data['Dealer']['promo_image'], 640, 100);
                                }
                                echo '<tr><td class="form-label" style="background-color:FF9F9F"><label>'.(isset($disable_changed_fields) ? 'Dealer\'s Version' : 'Original').'</label></td><td class="form-data">'.$orig_value.'</td></tr>';
                            }
                        }?>
                    </table>
                    <?php if($admin == 2){?>
                        <div class="form-bottom">
                            <input type="button" style="width:auto" value="Save and Continue Editing" onclick="saveDealer()" />
                            <input id="DealerApprovalReady" type="hidden" value="0" name="data[Dealer][approval_ready]" />
                            <input type="button" style="width:auto" onclick="if(confirm('Are you sure you want to submit your changes for approval?')){saveApproveDealer();}" value="Save And Request Approval" />
                        </div>
                    <?php }else{?>
                        <div class="form-bottom">
                            <input type="button" value="Save" onclick="saveDealer()" />
                            <input type="button" value="Save &amp; Close" onclick="saveCloseDealer()" />
                            <input type="button" value="Save &amp; New" onclick="saveNewDealer()" />
                            <input type="button" value="Cancel" onclick="window.location = '<?php echo $this->Html->url('/dealers'); ?>';" />
                        </div>
                        <?php if(!empty($data['Dealer']['dealer_id'])){?>
                            <div class="form-bottom">
                                <input type="button" style="width:409px" onclick="if(confirm('Are you sure you want to approve these changes to go live?  This will overwrite all the current live dealer information.')){saveApproved();}" value="Save And Approve Changes" />
                                <input type="button" style="width:409px" onclick="if(confirm('Are you sure you want to reject and delete these changes?  This will delete all of the dealer\'s changes.')){rejectChanges();}" value="Reject and Delete Changes" />
                            </div>
                    <?php }}?>
                <?php echo $this->Form->end();?>
        </td>
    </tr>
</table>

<script language="JavaScript" type="text/javascript">
    function changeSlug(cityInput){
        if(confirm('You have changed the city name.  Do you want the URL slug to change to match the new city?')){
            var city = cityInput.value;
            var slug = city.split(" ").join("-").split("'").join('-').split(',').join('-');
            $('DealerSlug').value = 'hot-tubs-'+slug.toLowerCase();
        }
    }
    
    function saveDealer()
    {
        //$ = getElementById
        $('input-action').value = "save"; //changing hidden field id=input-action
        $('form-dealers').submit(); //submit form-dealers
    }
    
    function saveApproved(){
        $('input-action').value = "approve"; //changing hidden field id=input-action
        $('form-dealers').submit(); //submit form-dealers
    }
    
    function rejectChanges(){
        window.location = '<?php echo $this->Html->url('/dealers/reject_dealer_changes/'.$data['Dealer']['id']); ?>';
    }
    
    function saveApproveDealer(){
        $('DealerApprovalReady').value = 1;
        saveDealer();
    }
 
    function saveCloseDealer()
    {
        $('input-action').value = "saveClose";
        $('form-dealers').submit();     
    }
 
    function saveNewDealer()
    {
        $('input-action').value = "saveNew";
        $('form-dealers').submit();
    }
 
    function showAddCountry()
    {
        $('country-sel').style.display = 'none';
        $('add-country').style.display = 'block';
    }
    function hideAddCountry()
    {
        $('country-sel').style.display = 'block';
        $('add-country').style.display = 'none';
    }
</script>
