<div class="breadcrumbs">
    <?php echo $this->Html->link('Search', '/', array('title' => 'Hot Tub Stores'));?> >
    <?php echo $this->Html->link(($countryId == 3) ? "Canada" : "United States", '/', array('title' => 'Hot Tub Stores'));?> >
    <?php echo $stateName ?>
</div>

<h1>Locate a <?php echo $barTitle; ?></h1>
<?php if ($countryId == 3) { ?>
    <div style="clear: left; float: left;width: 150px; height: 200px;">
        The Province of <?php echo $stateName ?>
    </div>
<?php } elseif ($countryId == 1) { //if US ?>
    <div style="clear: left; float: left;width: 150px; height: 200px;">
        <img src="<?php echo $this->Html->url("/img/states/") . str_replace(' ', '-', strtolower($stateName)) . '.jpg' ?>" alt="The State of <?php echo $stateName ?>" />
    </div>
<?php
}
$i = 1;
$countCity = count($cityList);
$lastIndex = $countCity - 1;
$half = round($countCity / 2);
$diff = 200;
if ($half > 13) {
    $diff = (($half - 13) * 18) + 200;
}

//echo '<div style="width: 411px; float: left; height: '.$diff.'px; margin-left: 40px;">';
echo '<div style="width: 411px; float: left; margin-left: 40px;">';
if (empty($cityList)) {
    echo 'There are currently no Jacuzzi Hot Tub Dealers in ' . $stateName;
} else {
    foreach ($cityList as $key => $city) {
        $cityName = str_replace('.', '', strtolower(trim($city['Dealer']['city'])));
        $cityName = str_replace(' ', '-', strtolower(trim($cityName))) . '-hot-tubs';
        $c = trim(ucwords(strtolower($city['Dealer']['city'])));
        if ($i == 1){
            echo '<ul class="cityList" style="margin: 0pt; padding: 0pt; float: left; width: 49%; list-style-type: none;">';
        }
        echo '<li>';
        echo $this->Html->link($c, '/'.$name_abbrev.'/'.$cityName.'/', array('title' => $c.' Hot Tubs'));
        //echo '<a href="' . BASEDIR . '/' . $name_abbrev . '/' . $cityName . '/" title="' . $c . ' Hot Tubs">' . $c . '</a>';
        echo '</li>';

        if ($key == $lastIndex || $i == $half) {
            echo '</ul>';
        }

        if ($i == $half && $key != $lastIndex) {
            $i = 1;
        } elseif ($key != $lastIndex) {
            $i++;
        }
    }
}
?>
</div>
<div class="clear"></div>

<div class="bar2">
    <a href="#" onClick="toggle_element( 'searchbystate' );return false;" style="color: white;text-decoration: none;">+/- Search By <?php echo ($countryId == 3) ? "Province" : "State" ?></a>
</div>
<div id="searchbystate" class="barbox" style="display: none;">
<?php
$i = 1;
$lastState = count($stateList) - 1;
$maxCol = ($countryId == 3) ? 4 : 13;

foreach ($stateList as $key => $s) {
    $stateUrl = str_replace(' ', '-', strtolower($s['State']['name'] . '-' . $s['State']['abbreviation']));
    if ($i == 1)
        echo '<ul>';

    echo '<li>';
    echo $this->Html->link($s['State']['name'], '/'.$stateUrl.'/', array('title' => 'Hot Tubs in '.$s['State']['name']));
    //echo '<a title="Hot Tubs in ' . $s['State']['name'] . '" href="' . BASEDIR . '/' . $stateUrl . '/">' . $s['State']['name'] . '</a>';
    echo '</li>';

    if ($i == $maxCol) {
        echo '</ul>';
        $i = 1;
        continue;
    } elseif ($key == $lastState) {
        echo '</ul>';
        echo '<div class="clear"></div>';
        break;
    }
    $i++;
}
?>
</div>

<div class="horz660"></div>
<div style="margin:0px 8px 8px 5px;">
    <?php if ($countryId == 3) { ?>
        <p style="color:#797979">
            Jacuzzi provides the world's most recognized brand of hot tubs and spas.
        </p>
        <p style="color:#797979">
            Consult our free brochure or visit a local Jacuzzi dealer to learn more about how you can treat yourself to the relaxing hydrotherapy benefits or spoil your friends and family to a hot tub party in your backyard. Regardless of how you choose to indulge in the luxury of a hot tub, visit hot tub stores in <?php echo $stateName; ?> near you to find the whirlpool best suiting your needs, preferences, and budget. <?php echo $stateName; ?> Jacuzzi dealers will provide you with all the information you need to know concerning indoor and outdoor selections, the hottest sales, and customer reviews, so you can choose the best tub for your lifestyle. There's a hot tub out there looking for a home in your backyard, so let the spa retailers in <?php echo $stateName; ?> help you find it.
        </p>
        <p style="color:#797979">
            Hot tubs in <?php echo $stateName; ?> present you with a seemingly never ending list of possibilities for entertainment and relaxation. Regardless of whether you are one to relax in your spa for hydrotherapy benefits or if you tend to open the tub up during your backyard cookouts, keeping your spa performing at its highest level is important. In order to maintain your spa's health and prolong its lifespan, come into your local Jacuzzi retailer to acquire all the necessary maintenance supplies. Our hot tub dealers will provide you all the chemicals, parts, and filters to ensure your tub functions at its finest. Visit Jacuzzi stores as they offer additional accessories, such as lifts, covers, steps, and more to further personalize and protect your very own hot tub spa in <?php echo $stateName; ?>.
        </p>
    <?php } else { ?>
        <p style="color:#797979">
            Explore the world's most recognized brand of hot tubs and spas. Our dealers for hot tubs in <?php echo $stateName; ?> provide you with the reviews, sales, and information you need to find the hot tub best suiting your lifestyle and budget. Visit one of our authorized Jacuzzi retailers today and learn more about our tubs' true energy efficiency and patented-jet hydrotherapy.
        </p>
        <p style="color:#797979">
            Dip into your personal indoor hot tub for your own private hydrotherapy session or turn up the heat and host an outdoor hot tub party on your backyard patio. Relax and unwind alone or invite your friends to kick back in a Jacuzzi spa of your very own. Regardless of how you plan on indulging in your personal hot tub, visit Jacuzzi dealers in <?php echo $stateName; ?> for the whirlpool you've always dreamed of at surprisingly affordable prices. 
        </p>
        <p style="color:#797979">
            Our authorized Jacuzzi hot tub stores in <?php echo $stateName; ?> can provide all the accessories and maintenance supplies you need from filters and chemicals to sanitizers and covers, to ensure your backyard whirlpool performs at the highest level possible. Come on in to your local dealer and browse the extensive selection of lifts, parts, steps, and spa caddies, which let you not only personalize your hot tub, but also help keep it in tip-top shape. From the necessary supplies to the nonessential touches, you will find everything you need and more at the Jacuzzi dealers in <?php echo $stateName; ?>. If you would like to do some research prior to visiting your local store, just download a free brochure to learn more about our wide selection of hot tubs and spas.
        </p>
    <?php } ?>
</div>