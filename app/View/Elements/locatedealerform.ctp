<p>Find <strong>hot tub dealers</strong>&nbsp;near you. Select your country from the menu below. If you are in the United States or Canada, enter your zip code or postal code, as well.</p>
<div class="locateDealerForm">
	<form action="<?php echo $this->Html->url('/cities/');?>" method="post" name="locform" id="locform" onsubmit="document.getElementById('zipcodeSearch').value=1;">
		<input type="hidden" name="zipcodeSearch" id="zipcodeSearch" value="0" />
		<table>
				<tr>
					<td width="66"><label for="country">Country</label></td>
					<td width="243"><?php
					//echo '<pre style="display:none">'. print_r($countryList,true) .'</pre>';
                                        
                                        if(isset($lngTxt['defaultCountry']) && !empty($lngTxt['defaultCountry'])){
                                            $default_country = $lngTxt['defaultCountry'];
                                        }elseif (strpos($_SERVER['HTTP_HOST'], '.ca') !== false) {
                                            $default_country = 3;
                                        }else $default_country = 1;
					echo $this->Form->select("Dealer.country_id", $countryList, array('default' => $default_country, 'id'=>'country', 'empty' => FALSE)); #drop down list of countries ?></td>
					<td width="130"><label for="zip">Zip/Postal Code</label></td>
					<td width="160"><input type="text" maxlength="7" id="zip" class="text" name="zip" /></td>
					<td><input src="/wp-content/themes/sundance/images/icons/search-arrow.jpg" value="submit" type="image" /></td>
				</tr>
		</table>
	</form>
</div>
<p><small>By clicking search you agree to the  <A onclick="window.open('http://www.sundancespas.com/LocateDealer/TermsOfUse.html', 'Size', 'width=600, height=400, location=no, menubar=no,resizeable=1,scrollbars=yes,toolbar=0,top=100,left=100');return false;"	href='http://www.sundancespas.com/LocateDealer/TermsOfUse.html'>Terms Of Use</a>.</small></p>