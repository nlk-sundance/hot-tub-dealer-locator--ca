<div class="locateDealerFormSimple">
	<h4>Our professional dealers can answer all your questions<br />and help you find the hot tub of your dreams.</h4>
	<form action="<?php echo $this->Html->url('/cities/');?>" method="post" name="locform" id="locform" onsubmit="document.getElementById('zipcodeSearch').value=1;">
		<input type="hidden" name="zipcodeSearch" id="zipcodeSearch" value="0" />
		<table>
				<tr>
					<td>
						<label for="country">Country</label>
					</td>
					<td>
						<?php 
                                                /*if(isset($lngTxt['defaultCountry']) && !empty($lngTxt['defaultCountry'])){
                                                    $default_country = $lngTxt['defaultCountry'];
                                                }else*/
                                                if (strpos($_SERVER['HTTP_HOST'], '.ca') !== false) {
                                                    $default_country = 3;
                                                }else $default_country = 1;
                                                echo $this->Form->select("Dealer.country_id", $countryList, array('default' => $default_country, 'id'=>'country', 'empty' => FALSE)); #drop down list of countries ?>
					</td>
				</tr>
				<tr>
					<td>
						<label for="zip">Zip or Postal Code</label>
					</td>
					<td>
						<input type="text" maxlength="7" id="zip" class="text" name="zip" />
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<input src="/wp-content/themes/sundance/images/icons/search-arrow.jpg" value="submit" type="image" />
					</td>
				</tr>
		</table>
	</form>
</div>
