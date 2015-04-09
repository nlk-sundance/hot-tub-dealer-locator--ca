<?php if($this->Session->read('login.group_id') == 1){?>
<td id="sidebar">
                <h1>Dealers</h1>
    <script type="text/javascript">
    //hides/appears "Filter By"
    function openTable(divId) {
        Effect.toggle(divId, 'blind', {duration: .2});
}
</script>
    <?php echo $this->Form->create('Dealer', array('action' => 'index', 'type' => 'post', 'attributes' => array('name' => 'filter-form')));?>
    <!--form method="post" action="<?php //echo $html->url('/dealers/index');?>" name="filter-form"-->
    <input type="hidden" name="updateQuery" value="1">
    <fieldset>
        <legend><a href="#" onclick="openTable('filterBy'); return false;">Filter By <?php echo $this->Html->image('btn_down.gif', array('border' => 0));?></a></legend>
        <div id="filterBy">
        <table>
            <tr>
                <td>Name:</td>
                <td><input type="text" name="data[Filter][name]" value="<?php echo $filter['name'];?>" id="text-name"></td>
            </tr>
            <tr>
                <td>Email:</td>
                <td><input type="text" name="data[Filter][email]" value="<?php echo $filter['email'];?>" id="text-email"></td>
            </tr>
            <tr>
                <td>Phone:</td>
                <td><input type="text" name="data[Filter][phone]" value="<?php echo $filter['phone'];?>" id="text-phone"></td>
            </tr>
            <tr>
                <td>Published:</td>
                <td>
                    <?php echo $this->Form->select('Filter.published', array('Y' => 'Yes', 'N' => 'No'), array('value' => $filter['published'], 'id'=> 'published', 'blank' => TRUE));?>
                    <!--select name="data[Filter][published]" id="sel-published">
                        <option></option>
                        <option value="Y" <?php if ($filter['published'] == "Y") echo $filter['published'];?>>Yes</option>
                        <option value="N" <?php if ($filter['published'] == "N") echo $filter['published'];?>>No</option>
                    </select-->
                </td>
            </tr>
            <tr>
                <td>City:</td>
                <td><input type="text" name="data[Filter][city]" value="<?php echo $filter['city']?>" id="text-city"></td>
            </tr>
            <tr>
            <tr>
                <td>Zip Code:</td>
                <td><input type="text" name="data[Filter][zip]" value="<?php echo $filter['zip']?>" id="text-zip"></td>
            </tr>
            <tr>
                <td>State:</td>
                <td>
                    <?php echo $this->Form->select('Filter.state_id', $stateList, array('value' => $filter['state_id'], 'id'=> 'sel-state'));?>
                    <?php //echo $html->selectTag("Filter/state_id", $stateList, $filter['state_id'], array('id'=> 'sel-state')); ?>
                </td>
            </tr>
            <tr>
                <td>Country:</td>
                <td>
                    <?php echo $this->Form->select('Filter.country_id', $countryList, array('value' => $filter['country_id'], 'id'=> 'sel-country'));?>
                    <?php //echo $html->selectTag("Filter/country_id", $countryList, $filter['country_id'], array('id'=> 'sel-country')); ?>
                </td>
            </tr>
            <tr>
                <td>Number:</td>
                <td>
                    <?php echo $this->Form->input("Filter.dealer_number", array('value' => $filter['dealer_number'], 'id'=> 'sel-number', 'label' => FALSE)); ?>
                </td>
            </tr>
            <tr>
                <td>Pending:</td>
                <td>
                    <?php echo $this->Form->select('Filter.pending', array('Y' => 'Yes', 'N' => 'No'), array('value' => $filter['pending'], 'id'=> 'pending', 'blank' => TRUE));?>
                </td>
            </tr>
            <tr><td colspan=2>
                <div align="center">
                <input type="submit" name="" value=" Filter " >
                <input type="reset" name="" value=" Clear " onclick="clearFilterForm(this.form); return false;">
                </div>
            </td></tr>
        </table></div>
    </fieldset>
    <?php echo $this->Form->end();?>
<script type="text/javascript">
    function clearFilterForm(f)
    {
        $('sel-state').selectedIndex = '';
        $('sel-country').selectedIndex = '';
        $('sel-number').selectedIndex = '';
        $('sel-published').selectedIndex = '';
        $('text-name').value = '';
        $('text-email').value = '';
        $('text-phone').value = '';
        $('text-city').value = '';
        $('text-zip').value = '';
    }
</script>
</td>
<?php }?>