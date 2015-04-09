<!--h2>Thank you for your inquiry</h2>
<p><?php echo $thankYouText ?></p-->

<h2>Hot Tubs <?php echo $stateName?></h2>
<table width="405" cellpadding="0" cellspacing="0" class="expanded">
	<tr valign="top">
		<?php $rows = ceil(count($cityList) / 2);?>
		<td width="108" style="vertical-align:top"><img src="<?php echo $this->webroot;?>img/states/stateOutline_<?php echo $stateAbbr?>.gif" /></td>
		<td style="vertical-align:top"><table width="295" cellpadding="0" cellspacing="0">
		<?php $i = 0;
			$countCities = count($cityList)-1;
			foreach($cityList as $key=>$city):
				if($key == 0):
					echo '<tr>';
				endif;
				$cityLinkName = strtolower(str_replace(' ', '-', $city['Dealer']['city']));
		?>
				<td width="50%" style="vertical-align:top"><a href="<?php echo $this->webroot.$name_abbrev.'/'.$city['Dealer']['slug'];?>/" title="Hot Tubs <?php echo $city['Dealer']['city'].' '.strtoupper($stateAbbr)?>"><?php echo $city['Dealer']['city'] ?></a></td>
				<?php 
				$num = $i%2; 
				if($num == 1):
					echo '</tr>'; 
					if($i < $countCities):
						echo'<tr>';
					endif;
				endif;
				$i++;
				?>
		<?php endforeach; ?>
	<?php echo'</tr></table></td>'?>
</table><br /><br />
<?php /*
<h2><a href="#" class="expand">Search By State</a></h2><br />
<!--stateList -->
<table width="374" cellpadding="0" cellspacing="0" class="expand">
	<?php 
	if(!empty($stateList)):
		$rCounter = 25;
		for($lCounter=0; $lCounter < 25; $lCounter++) { 
			$stateNameL = strtolower($stateList[$lCounter]['State']['name']);
			$stateNameL = str_replace(' ', '-', $stateNameL);
			$stateNameR = strtolower($stateList[$rCounter]['State']['name']);
			$stateNameR = str_replace(' ', '-', $stateNameR); ?>
			<tr>
				<td width="50%">
					<a href="<?php echo $baseURL.$stateNameL.'-'.strtolower($stateList[$lCounter]['State']['abbreviation'])?>/" title="Hot Tubs <?php echo $stateList[$lCounter]['State']['name']?>"><?php echo $stateList[$lCounter]['State']['name'] ?></a>
				</td>
				<td width="50%">
					<a href="<?php echo $baseURL.$stateNameR.'-'.strtolower($stateList[$rCounter]['State']['abbreviation'])?>/" title="Hot Tubs <?php echo $stateList[$rCounter]['State']['name']?>"><?php echo $stateList[$rCounter]['State']['name'] ?></a>
				</td>
			</tr>
			<?php $rCounter++;
		}
	endif;
	?>
</table><br />
<a href="#" id="interactivemap">View Interactive Map</a><br /><br />

<br />
*/ ?>
<?php echo $this->element('seotxt'); ?>
<p><br /></p>
<?php echo $this->element('locatedealerform');?>
<?php echo $this->element('stateList');?>
<p><a href="<?php echo $this->webroot?>" title="Hot Tub Dealers">Search United States</a> | <a href="<?php echo $this->webroot;?>" title="Hot Tub Dealers">Search the Map</a></p>