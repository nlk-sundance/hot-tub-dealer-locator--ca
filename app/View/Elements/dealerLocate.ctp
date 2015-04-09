<div class="dealer-locate">
    <h1>Dealer Locator</h1>
    <p><?php echo $lngTxt['toFind'] ?></p>
    <div id="tranbox">
        <?php echo $this->Form->create('Locator', array('type' => 'post', 'action' => 'cities', 'name' => 'countryZipForm1', 'id' => 'countryZipForm1', 'onSubmit' => 'document.getElementById("zipcodeSearch1").value=1;'));?>
        <!--form action="<?php //echo BASEDIR;?>/cities/" method="post" name="countryZipForm1" id="countryZipForm1" onSubmit="document.getElementById('zipcodeSearch1').value=1;"-->
            <input type="hidden" name="zipcodeSearch" id="zipcodeSearch1" value="0">
            <div id="country">
                <h2><label for="countryInput">Country:</label></h2>
                <?php echo $this->Form->select('Dealer.country_id', $countryList, array('value' => $defaultCtry, 'id' => 'countryInput', 'name' => 'country', 'onChange'=>'disableZip()', 'empty' => FALSE));?>
                <?php //echo $html->selectTag("Dealer/country_id", $countryList, $defaultCtry, array('id'=>'countryInput', 'name'=>'country', 'onChange'=>'disableZip()'), null, false); #drop down list of countries ?>
            </div>
            <div id="zipcode" class="zip-wrap">
                <input id="zipcodeInput" type="text" name="zip" class="text" />
                <input id="go" type="submit" value="Go" onclick="document.getElementById('zipcodeSearch1').value=1;" class="btn" />
            </div>
        <?php echo $this->Form->end();?>
    </div>
</div>