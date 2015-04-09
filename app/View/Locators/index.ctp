<?php echo $this->element('locatedealerformsimple');?>

<div class="hidden-states" style="display: none">
	<h2>Popular Cities</h2>
	<ul class="colLists">
	    <li>
	        <ul class="colList">
	        	<li><a href="<?php echo $baseURL.'colorado-co/hot-tubs-highlands-ranch/' ?>" title="Hot Tubs Denver CO">Denver</a></li>
				<li><a href="<?php echo $baseURL.'oklahoma-ok/hot-tubs-oklahoma-city/' ?>" title="Hot Tubs Oklahoma City OK">Oklahoma City</a></li>
				<li><a href="<?php echo $baseURL.'illinois-il/hot-tubs-downers-grove/' ?>" title="Hot Tubs Elmhurst IL">Elmhurst</a></li>
				<li><a href="<?php echo $baseURL.'new-jersey-nj/hot-tubs-cherry-hill/' ?>" title="Hot Tubs Philadelphia PA">Philadelphia</a></li>
			</ul>
	    </li>
	    <li>
			<ul class="colList">
	        	<li><a href="<?php echo $baseURL.'north-carolina-nc/hot-tubs-greensboro/' ?>" title="Hot Tubs Greensboro NC">Greensboro</a></li>
				<li><a href="<?php echo $baseURL.'pennsylvania-pa/hot-tubs-pittsburgh/' ?>" title="Hot Tubs Pittsburgh PA">Pittsburgh</a></li>
				<li><a href="<?php echo $baseURL.'connecticut-ct/hot-tubs-avon/' ?>" title="Hot Tubs Hartford New Haven CT">Hartford - New Haven</a></li>
				<li><a href="<?php echo $baseURL.'california-ca/hot-tubs-san-diego/' ?>" title="Hot Tubs San Diego CA">San Diego</a></li>
			</ul>
	    </li>
	    <li>
			<ul class="colList">
	        	<li><a href="<?php echo $baseURL.'california-ca/hot-tubs-santa-ana/' ?>" title="Hot Tubs Irvine CA">Irvine</a></li>
				<li><a href="<?php echo $baseURL.'california-ca/hot-tubs-san-jose/' ?>" title="Hot Tubs San Jose CA">San Jose</a></li>
				<li><a href="<?php echo $baseURL.'nevada-nv/hot-tubs-las-vegas/' ?>" title="Hot Tubs Las Vegas NV">Las Vegas</a></li>
				<li><a href="<?php echo $baseURL.'washington-wa/hot-tubs-seattle/' ?>" title="Hot Tubs Seattle WA">Seattle</a></li>
			</ul>
	    </li>
	    <li>
			<ul class="colList">
	        	<li><a href="<?php echo $baseURL.'minnesota-mn/hot-tubs-lakeville/' ?>" title="Hot Tubs Minneapolis Saint Paul MN">Minneapolis - Saint Paul</a></li>
				<li><a href="<?php echo $baseURL.'missouri-mo/hot-tubs-st-louis/' ?>" title="Hot Tubs St. Louis MO">St. Louis</a></li>
			</ul>
	    </li>
	</ul>
	<h2>Search By State</h2>
	<!--stateList -->
	<ul class="colLists">
		<?php
		if(!empty($stateList)):
			$rCounter = 25;
			$stateCount = count($stateList);
			for($lCounter=0; $lCounter < $stateCount; $lCounter++) {
				if ( $lCounter%13 == 0 ) {
					if ( $lCounter > 0 ) echo '</ul></li>';
					echo '<li><ul class="colList">';
				}
		?>
				<li><a href="<?php echo $baseURL.strtolower($stateList[$lCounter]['State']['name']).'-'.strtolower($stateList[$lCounter]['State']['abbreviation'])?>/" title="Hot Tubs <?php echo $stateList[$lCounter]['State']['name']?>"><?php echo $stateList[$lCounter]['State']['name'] ?></a></li>
				<?php
			}
		endif;
		?>
	</li></ul></li></ul>
	<p><br /></p>
</div>