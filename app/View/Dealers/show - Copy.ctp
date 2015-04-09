<?php //echo $javascript->link('datechooser'); ?>
<?php echo $this->Html->script('datechooser', array('inline' => TRUE)); ?>
<?php echo $this->Html->css('datechooser', array('inline' => TRUE)); ?>
<?php echo $this->Html->script('tinymce/tinymce.min');?>
<?php //echo $html->css('datechooser'); ?>
<script type="text/javascript">
    events.add(window, 'load', WindowLoad);
    function WindowLoad(){
        <?php if(!isset($readonly_fields) || !in_array('additional_html_start', $readonly_fields)){?>
            var start_date = document.getElementById('start_date_div');
            start_date.DateChooser = new DateChooser();
            start_date.DateChooser.setXOffset(5);
            start_date.DateChooser.setYOffset(-5);
            start_date.DateChooser.setUpdateField('DealerAdditionalHtmlStart', 'M j, Y');
            start_date.DateChooser.setIcon('<?php echo $this->Html->url("/img/datechooser.png"); ?>', 'DealerAdditionalHtmlStart');
        <?php }?>

        <?php if(!isset($readonly_fields) || !in_array('additional_html_end', $readonly_fields)){?>
            var end_date = document.getElementById('end_date_div');
            end_date.DateChooser = new DateChooser();
            end_date.DateChooser.setXOffset(5);
            end_date.DateChooser.setYOffset(-5);
            end_date.DateChooser.setUpdateField('DealerAdditionalHtmlEnd', 'M j, Y');
            end_date.DateChooser.setIcon('<?php echo $this->Html->url("/img/datechooser.png"); ?>', 'DealerAdditionalHtmlEnd');
        <?php }?>
        
        <?php if(!isset($readonly_fields) || !in_array('additional_html_start_sale', $readonly_fields)){?>
            var start_sale_date = document.getElementById('start_sale_date_div');
            start_sale_date.DateChooser = new DateChooser();
            start_sale_date.DateChooser.setXOffset(5);
            start_sale_date.DateChooser.setYOffset(-5);
            start_sale_date.DateChooser.setUpdateField('DealerAdditionalHtmlStartSale', 'M j, Y');
            start_sale_date.DateChooser.setIcon('<?php echo $this->Html->url("/img/datechooser.png"); ?>', 'DealerAdditionalHtmlStartSale');
        <?php }?>
    }
</script>
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
                echo $this->Html->link('This dealer\'s changes are ready for approval.', '/dealers/show/'.$dealer_approval_id['Dealer']['id']).'<br /><br />';
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
                    $admin = $this->Session->read('login.group_id');
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
                            'address1' => array('label' => 'Address Line 1'),
                            'address2' => array('label' => 'Address Line 2'),
                            'city' => array(),
                            'zip' => array('label' => 'Zip Code'),
                            'state_id' => array('options' => $stateList),
                            'country_id' => array('options' => $countryList),
                            'region_num' => array('label' => 'Region #', 'dealer_limit' => TRUE),
                            'email' => array(),
                            'phone' => array('label' => 'Phone 1'),
                            'phone2' => array('label' => 'Phone 2'),
                            'fax' => array(),
                            'website' => array(),
                            'published' => array('type' => 'select', 'options' => array('Y' => 'Yes', 'N' => 'No'), 'dealer_limit' => TRUE),
                            'additional_html_dates' => array(),
                            'default_promo' => array('type' => 'select', 'options' => array(0 => 'No', 1 => 'Yes'), 'label' => 'Include Default Truckload Promo'),
                            'additional_html' => array('style' => 'width:100%;height:200px;', 'label' => 'Additional HTML'),
                            'url_redirect' => array('label' => 'Custom URL Redirect'),
                            'about_title' => array(),
                            'about_body' => array('wysiwyg' => 'undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent'),
                            'wet_test' => array('label' => 'Include Wet Test?'),
                            'hours' => array('label' => 'Store Hours', 'wysiwyg' => 'undo redo'),
                            'latitude' => array('dealer_limit' => TRUE),
                            'longitude' => array('dealer_limit' => TRUE)
                        );
                        if(empty($data['Dealer']['promo_image'])){
                            $fields['promo_image'] = array('type' => 'file');
                            $fields['promo_image']['after'] = '<br /><font color="red"><b>Image will be scaled and cropped to 640px by 100px.</b></font>
                            </td>';
                        }
                        $fields['longitude']['after'] = '<br />Please go to <a href="http://www.latlong.net/" target="_blank">http://www.latlong.net/</a> to find the latitude and longitude of an address
                            </td>';
                        $fields['url_redirect']['after'] = '<br /><font color="red"><b><u>PLEASE FORMAT URL AS:</u>&nbsp;&nbsp;&nbsp;http://www.website.com</b></font>
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
                            if($admin == 1 || !isset($field['dealer_limit'])){
                                if(isset($readonly_fields) && in_array($field_name, $readonly_fields)){
                                    $field['readonly'] = 'readonly';
                                    $field['class'] = 'readonly';
                                }
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
                                            <?php if(!isset($readonly_fields) || !in_array('additional_html_start', $readonly_fields)){?>
                                                <input type="button" value="Clear Dates" onClick="$('DealerAdditionalHtmlStart').value='';$('DealerAdditionalHtmlEnd').value='';" />
                                            <?php }?>
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
                                            <?php if(!isset($readonly_fields) || !in_array('additional_html_start_sale', $readonly_fields)){?>
                                                <input type="button" value="Clear Date" onClick="$('DealerAdditionalHtmlStartSale').value='';" />
                                            <?php }?>
                                        </td>
                                    </tr>
                                <?php }elseif(isset($field['wysiwyg'])){?>
                                    <tr>
                                        <td class="form-label"><?php echo $field_name;?></td>
                                        <td class="form-data">
                                            <?php echo $this->Wysiwyg->textarea($model.'.'.$field_name, array('value' => $data[$model][$field_name]), array('width' => '500px', 'toolbar_items_size' => 'small', 'force_br_newlines' => 'true', 'forced_root_block' => "", 'force_p_newlines' => 'false', 'menubar' => 'false', 'toolbar' => $field['wysiwyg']));?>
                                        </td>
                                    </tr>
                                <?php }else{
                                    echo $this->Form->input($model.'.'.$field_name, $options);
                                }
                            }
                        }
                        if(!empty($data['Dealer']['promo_image'])){?>
                            <tr>
                                <td class="form-label">Promo Image</td>
                                <td class="form-data">
                                    <?php if(is_file(WWW_ROOT.'files/dealer_imgs/'.$id.'/promo/'.$data['Dealer']['promo_image'])){
                                        echo $this->Image->resize('/files/dealer_imgs/'.$id.'/promo/'.$data['Dealer']['promo_image'], 640, 100);
                                    }?>
                                    <br />
                                    <?php echo $this->Html->link('Remove Image', '/dealers/remove_image/promo/'.$id, array(), 'Are you sure you want to remove and delete this image?');?>
                                </td>
                        <?php }?>
                        <!--tr>
                            <td class="form-required"><Dealer Number:</td>
                            <td class="form-data"-->
                                <?php //echo $this->Form->input('Dealer.dealer_number', array('between' => '</td><td class="form-data">', 'div' => array('tag'=> 'tr'), 'before' => '<td class="form-label">', 'after' => '</td>', 'default' => (isset($data['Dealer']['dealer_number']) ? $data['Dealer']['dealer_number'] : '')));?>
                                <!--input type="text" size="50" name="data[Dealer][dealer_number]" value="<?php //echo $data['Dealer']['dealer_number']; ?>"/-->
                                <?php //echo $this->Form->error('Dealer.dealer_number', 'Dealer number is required and must be unique.') ?>
                            <!--/td>
                        </tr-->
                        <!--tr>
                            <td class="form-required">Name:</td>
                            <td class="form-data">
                                <input type="text" size="50" name="data[Dealer][name]" value="<?php //echo htmlentities($data['Dealer']['name'], ENT_QUOTES, 'UTF-8'); ?>"/>
                                <?php //echo $this->Form->error('Dealer.name', 'Name is required.') ?>
                            </td>
                        </tr-->
                        <!--tr>
                            <td class="form-required">Address Line 1:</td>
                            <td class="form-data">
                                <input type="text" size="50" name="data[Dealer][address1]" value="<?php //echo htmlentities($data['Dealer']['address1'], ENT_QUOTES, 'UTF-8'); ?>"/>
                                <?php //echo $this->Form->error('Dealer.address1', 'Address is required.') ?>
                            </td>
                        </tr-->
                        <!--tr>
                            <td class="form-label">Address Line 2:</td>
                            <td class="form-data">
                                <input type="text" size="50" name="data[Dealer][address2]" value="<?php //echo htmlentities($data['Dealer']['address2'], ENT_QUOTES, 'UTF-8'); ?>"/>
                            </td>
                        </tr-->
                        <!--tr>
                            <td class="form-required">City:</td>
                            <td class="form-data">
                                <input type="text" size="50" name="data[Dealer][city]" value="<?php //echo htmlentities($data['Dealer']['city'], ENT_QUOTES, 'UTF-8'); ?>"/>
                                <?php //if ($this->Form->isFieldError('Dealer.city')) {
                                    //echo $this->Form->error('Dealer.city', 'Please enter a city consisting of only letters, numbers and spaces. (No punctuations EX: " . , \' - ;)');
                                //}?>
                            </td>
                        </tr-->
                        <!--tr>
                            <td class="form-required">Zip Code:</td>
                            <td class="form-data">
                                <input type="text" maxlength="7" name="data[Dealer][zip]" value="<?php //echo htmlentities($data['Dealer']['zip'], ENT_QUOTES, 'UTF-8'); ?>"/>
                                <?php //echo $this->Form->error('Dealer.zip', 'A valid zip code is required (letters, numbers).') ?>
                            </td>
                        </tr-->
                        <!--tr>
                            <td class="form-required">State:</td>
                            <td class="form-data">
                                <?php //echo $this->Form->select("Dealer.state_id", $stateList, array('value' => $data["Dealer"]["state_id"], 'blank' => FALSE)); #drop down list of states
                                //echo $this->Form->error('Dealer.state_id', 'State is required.'); ?>
                            </td>
                        </tr-->
                        <!--tr>
                            <td class="form-required">Country:</td>
                            <td class="form-data">
                                <div id="country-sel">
                                    <?php
                                    //echo $this->Form->select("Dealer.country_id", $countryList, array('value' => $data["Dealer"]["country_id"], 'blank' => FALSE)); #drop down list of countries 
                                    //echo $this->Form->error('Dealer.country_id', 'Country is required.');
                                    //echo ' ' . $this->Html->link('Add country', '/add_country/' . $data['Dealer']['id'], array('onClick' => 'showAddCountry(); return false;'));
                                    ?>
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
                        </tr-->
                        <!--tr>
                            <td class="form-label">Region #:</td>
                            <td class="form-data">
                                <input type="text" size="6" maxlength="6" name="data[Dealer][region_num]" value="<?php //echo htmlentities($data['Dealer']['region_num'], ENT_QUOTES, 'UTF-8'); ?>"/>
                                <?php //echo $this->Form->error('Dealer.region_num', 'Region Number must be 6 alphanumeric characters long.') ?>
                            </td>
                        </tr-->
                        <!--tr>
                            <td class="form-label">Email:</td>
                            <td class="form-data">
                                <input type="text" size="35" name="data[Dealer][email]" value="<?php //echo htmlentities($data['Dealer']['email'], ENT_QUOTES, 'UTF-8'); ?>"/>
                                <?php //echo $this->Form->error('Dealer.email', 'Email must be correct.') ?>
                            </td>
                        </tr-->
                        <!--tr>
                            <td class="form-label">Phone 1:</td>
                            <td class="form-data">
                                <input type="text" size="25" name="data[Dealer][phone]" value="<?php //echo htmlentities($data['Dealer']['phone'], ENT_QUOTES, 'UTF-8'); ?>"/>
                                <?php //echo $this->Form->error('Dealer.phone', 'A valid Phone number is required (letters, numbers, -).') ?>
                            </td>
                        </tr-->
                        <!--tr>
                            <td class="form-label">Phone 2:</td>
                            <td class="form-data">
                                <input type="text" size="25" name="data[Dealer][phone2]" value="<?php echo htmlentities($data['Dealer']['phone2'], ENT_QUOTES, 'UTF-8'); ?>"/>
                                <?php //echo $this->Form->error('Dealer.phone2', 'A valid Phone number is required (letters, numbers, -).') ?>
                            </td>
                        </tr-->
                        <!--tr>
                            <td class="form-label">Fax:</td>
                            <td class="form-data">
                                <input type="text" size="50" name="data[Dealer][fax]" value="<?php echo htmlentities($data['Dealer']['fax'], ENT_QUOTES, 'UTF-8'); ?>"/>
                            </td>
                        </tr-->
                        <!--tr>
                            <td class="form-label">Website:</td>
                            <td class="form-data">
                                <input type="text" size="50" name="data[Dealer][website]" value="<?php echo htmlentities($data['Dealer']['website'], ENT_QUOTES, 'UTF-8'); ?>"/>
                                <br /><font color="red"><b><u>PLEASE FORMAT WEBSITE URL AS:</u>&nbsp;&nbsp;&nbsp;http://www.website.com</b></font>
                            </td>
                        </tr-->
                        <!--tr>
                            <td class="form-label">Published:</td>
                            <td class="form-data">
                                <select name="data[Dealer][published]">
                                    <option value="Y" <?php if ($data['Dealer']['published'] == 'Y') {
                                        echo 'selected="selected"';
                                    } else {
                                        echo '';
                                    } ?>>Yes</option>
                                    <option value="N" <?php if ($data['Dealer']['published'] == 'N') {
                                        echo 'selected="selected"';
                                    } else {
                                        echo '';
                                    } ?>>No</option>
                                </select>
                            </td>
                        </tr-->
                        <!--tr>
                            <td class="form-label">Custom SEO Text:</td>
                            <td class="form-data">
                                <textarea name="data[Dealer][custom_seo_text]" style="width:100%;height:200px;"><?php //echo htmlentities($data['Dealer']['custom_seo_text'], ENT_QUOTES, 'UTF-8'); ?></textarea>
                            </td>
                        </tr-->
                        <!--tr>
                            <td class="form-label">Additional HTML Dates:</td>
                            <td class="form-data">
                                <div id="start_date_div">
                                    <input type="text" id="DealerAdditionalHtmlStart" readonly="readonly" name="data[Date][additional_html_start]" value="<?php echo (isset($data['Date']['additional_html_start']) ? htmlentities($data['Date']['additional_html_start'], ENT_QUOTES, 'UTF-8') : ''); ?>"/>
                                </div>
                                through
                                <div id="end_date_div">
                                    <input type="text" id="DealerAdditionalHtmlEnd" readonly="readonly" name="data[Date][additional_html_end]" value="<?php echo (isset($data['Date']['additional_html_end']) ? htmlentities($data['Date']['additional_html_end'], ENT_QUOTES, 'UTF-8') : ''); ?>"/>
                                </div>
                                <input type="button" value="Clear Dates" onClick="$('DealerAdditionalHtmlStart').value='';$('DealerAdditionalHtmlEnd').value='';" />
                                <?php //echo $this->Form->error('Dealer.additional_html_start_empty', 'You must enter a start date if you want to set an end date.') ?>
                                <?php //echo $this->Form->error('Dealer.additional_html_end_empty', 'You must enter an end date if you want to set a start date.') ?>
                                <?php //echo $this->Form->error('Dealer.additional_html_end_early', 'Please select an end date that is after the start date.') ?>
                            </td>
                        </tr-->
                        <!--tr>
                            <td class="form-label">Optional Sale Start Date:</td>
                            <td class="form-data">
                                <div id="start_sale_date_div">
                                    <input type="text" id="DealerAdditionalHtmlStartSale" readonly="readonly" name="data[Date][additional_html_start_sale]" value="<?php echo (isset($data['Date']['additional_html_start_sale']) ? htmlentities($data['Date']['additional_html_start_sale'], ENT_QUOTES, 'UTF-8') : ''); ?>"/>
                                </div>
                                <input type="button" value="Clear Date" onClick="$('DealerAdditionalHtmlStartSale').value='';" />
                            </td>
                        </tr-->
                        <!--tr>
                            <td class="form-label">Include Default Truckload Promo:</td>
                            <td class="form-data">
                                <select name="data[Dealer][default_promo]">
                                    <option value="0" <?php if ($data['Dealer']['default_promo'] == 0) {
                                        echo 'selected="selected"';
                                    } else {
                                        echo '';
                                    } ?>>No</option>
                                    <option value="1" <?php if ($data['Dealer']['default_promo'] == 1) {
                                        echo 'selected="selected"';
                                    } else {
                                        echo '';
                                    } ?>>Yes</option>
                                </select>
                            </td>
                        </tr-->
                        <!--tr>
                            <td class="form-label">Additional HTML:</td>
                            <td class="form-data">
                                <textarea name="data[Dealer][additional_html]" style="width:100%;height:200px;"><?php echo htmlentities($data['Dealer']['additional_html'], ENT_QUOTES, 'UTF-8'); ?></textarea>
                            </td>
                        </tr-->
                        <!--tr>
                            <td class="form-label">Custom URL Redirect:</td>
                            <td class="form-data">
                                <input type="text" size="50" name="data[Dealer][url_redirect]" value="<?php echo htmlentities($data['Dealer']['url_redirect'], ENT_QUOTES, 'UTF-8'); ?>"/>
                                <br /><font color="red"><b><u>PLEASE FORMAT URL AS:</u>&nbsp;&nbsp;&nbsp;http://www.website.com</b></font>
                            </td>
                        </tr-->
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
                            </div>
                    <?php }}?>
                <?php echo $this->Form->end();?>
        </td>
    </tr>
</table>

<script language="JavaScript" type="text/javascript">
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
