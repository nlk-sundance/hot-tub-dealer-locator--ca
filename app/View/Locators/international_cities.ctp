<!-- Locate A Dealer -->
<style>
    #main a.text-link{
        color: #797979;
        font-size: 12px;
        text-decoration: none;
        cursor: text;
    }
</style>
<div class="breadcrumbs">
    <?php echo $this->Html->link('Search', '/', array('title' => 'Hot Tub Stores'));?> >
    <?php if(!empty($stateName) && !empty($cityName)){ ?>
        <?php echo $this->Html->link($_SESSION['country'], '/', array('title' => 'Hot Tub Stores'));?> >
        <?php echo $this->Html->link($stateName, '/'.$stateInfo, array('title' => (!empty($stateName) ? 'Hot Tubs in '.$stateName : '')));?>
        <?php echo (!empty($cityName)) ? ' > '.$cityName : ''?>
    <?php }else{?>
        Results
    <?php } ?>
</div>
<h1 class="header"><?php if(isset($barTitle)){echo $barTitle;} ?></h1>
    <?php if(!empty($errorMsg)): ?>
        <div class="errorMsg"><?php echo $errorMsg ?></div>
    <?php elseif(empty($dealer) || (!isset($dealer[0]['Dealer']) && !isset($dealer['Dealer']))):?>
        <div class="bar2">Sorry, there were no results found for your search. Please make sure you have entered a valid zip code or postal code and try again.</div>
    <?php else:
        foreach($dealer as $d): ?>
        <h3 class="dealerheader">
            <?php if(!empty($cityInfo) && $countryID == 1) : ?>
                <?php echo $this->Html->link(strtoupper($d['Dealer']['name']), '/'.$stateInfo.'/'.$cityInfo.'/'.$d['Dealer']['id'].'/', array('title' => strtoupper($d['Dealer']['name']).' in '.$cityName.', '.$d['Dealer']['zip'], 'style' => 'color: white;'));?>
            <?php else :?>
                <?php echo strtoupper($d['Dealer']['name']) ?>
            <?php endif; ?>
        </h3>
        <p>
            <?php
            if(!empty($d['Dealer']['phone'])):
                echo (!empty($d['Dealer']['phone2']) ? 'Sales: ' : '') .'<span class="phone">'. $d['Dealer']['phone'] .'</span><br/>';
            endif;
            if(!empty($d['Dealer']['phone2'])):
                echo (!empty($d['Dealer']['phone']) ? 'Service: ' : '') .'<span class="phone2">'. $d['Dealer']['phone2'] .'</span><br/>';
            endif;
            echo '<span class="address1">'. $d['Dealer']['address1'] .'</span>';
            if(!empty($d['Dealer']['address2'])):
                echo '<br /><span class="address2">'.$d['Dealer']['address2'] .'</span>';
            endif;
            if(!empty($d['Dealer']['city'])):
                echo '<br /><span class="city">'.$d['Dealer']['city'] .'</span>';
            endif;
            if(!empty($d['State']['abbreviation'])):
                echo ', <span class="state">'.$d["State"]["abbreviation"] .'</span>';
            endif;
            if(!empty($d['Dealer']['zip'])):
                echo ' <span class="dzip">'.$d["Dealer"]["zip"] .'</span>';
            endif; ?>
            <?php if(!isset($outsideUS) && $countryID == 1) : ?>
                <?php echo $this->Html->link($this->Html->image('btnviewmap.jpg', array('border' => 0)), '/'.$stateInfo.'/'.$cityInfo.'/'.$d['Dealer']['id'].'/', array('title' => $d['Dealer']['name'].' in '.$cityName.(!empty($d['Dealer']['zip']) ? ', '.$d['Dealer']['zip'] : '')));?>
            <?php else: ?>
                <br />
            <?php endif; ?>
        </p>
        <!--/div>
        <div class="links"-->
            <?php if(!empty($d['Dealer']['email'])): ?>
                <div id="website"><a href="mailto:<?php echo $d['Dealer']['email']?>?subject=JacuzziHottubs.com Information Request"><?php echo $d['Dealer']['email']?></a></div>
            <?php endif; ?>
            <?php if(!empty($d['Dealer']['website'])): ?>
                <?php echo $this->Html->link('View Website', '/omniture/'.$d["Dealer"]["id"], array('target' => '_blank', 'rel' => 'nofollow'));?>
            <?php endif; ?>
                <style>
                    #get-a-quote-btn a {background-image:url('<?php echo $this->Html->url("/img/get-dealer-pricing-btn.png");?>');height:49px;width:250px;display:block;}
                    #get-a-quote-btn a:hover {background-image:url('<?php echo $this->Html->url("/img/get-dealer-pricing-btn-over.png")?>');}
                </style>
                <div id="get-a-quote-btn">
                    <br />
                    <a href="/get-a-quote/"><?php //echo $html->image('get_dealer_pricing_btn.png');?></a>
                    <br />
                </div>
            <?php if(isset($d['Dealer']['default_promo']) && $d['Dealer']['default_promo'] == 1 && !empty($d['Dealer']['additional_html_start']) && !empty($d['Dealer']['additional_html_end']) && $d['Dealer']['additional_html_start'] <= time() && $d['Dealer']['additional_html_end'] >= time()){ ?>
                <?php $sale_start_date = (!empty($d['Dealer']['additional_html_start_sale']) ? $d['Dealer']['additional_html_start_sale'] : $d['Dealer']['additional_html_start']);
                $sale_dates = date('F j', $sale_start_date).'-'.(date('F', $sale_start_date)==date('F', $d['Dealer']['additional_html_end']) ? date('j', $d['Dealer']['additional_html_end']) : date('F j', $d['Dealer']['additional_html_end']));?>
                <br /><br />
                <?php $line_broken = true;?>
                <table>
                    <tr>
                        <td style="vertical-align:middle"><div id="truckd">
                            <font color="#B98100"><strong>LIMITED TIME ONLY JACUZZI FACTORY TRUCKLOAD SALE <?php echo strtoupper($sale_dates);?></strong></font>
                            <br />
                            From <?php echo $sale_dates;?>, the Jacuzzi&reg; Hot Tub Truckload Sale will be at <?php echo $d['Dealer']['name']?>, with factory-direct savings of UP TO 50%! <a href="http://www.jacuzzitruckload.com/sales/" target="_blank">Click here</a> for more information.</div>
                        </td>
                        <td>&nbsp;&nbsp;</td>
                        <td><img src="http://www.jacuzzihottubs.com/images/promo/jacuzzi-truckload-small.jpg" /></td>
                    </tr>
                </table>
            <?php }?>
            <?php if(!empty($d['Dealer']['additional_html']) && (empty($d['Dealer']['additional_html_start']) || ($d['Dealer']['additional_html_start'] <= time() && $d['Dealer']['additional_html_end'] >= time()))): ?>
                <?php if(!isset($line_broken)){?><br /><?php }?><br />
                <div id="additional_html"><?php echo $d['Dealer']['additional_html'];?></div>
            <?php endif; ?>
    <?php endforeach; ?>
    <?php endif; ?>
    <div class="clear"></div>
    <div class="horz660"></div>
    <?php if(isset($cityName) && !empty($cityName)){?>
        <div style="margin:0px 8px 8px 5px;">
            <p style="color:#797979">
                <?php if($seo_page_type == 'sale'){?>
                        Shopping for a spa in <?php echo $cityName;?>? Hot tub sale prices are tempting but Jacuzzi recommends choosing the right hot tub before you compare prices. How do you select the best hot tub? Start by checking the reputation of the spa manufacturer. Find out how long the company has been in business, and whether they have spa industry certifications and honors. Positive reviews from customers and independent sources are good guidelines, too. If the manufacturer has an authorized <a class="text-link" href="/dealer-locator/">hot tub dealer</a> who can make a <?php echo $cityName;?> hot tub sale, you have the assurance of local service and support. But the main reasons to stick with a reputable name like Jacuzzi comes from the peace of mind of knowing that their products are durable and reliable, with quality performance and features.
                    </p>
                    <p style="color:#797979">
                        The next step is to get an overview of all the hot tub models available. <?php echo $cityName;?> hot tub sale models are on display at your local Jacuzzi Hot Tubs dealer. You can also see models online and <a class="text-link" href="http://www.jacuzzihottubs.com/multi-media/">watch informative videos</a>. You may think you know what you want, but wait until you see all the amazing possibilities: elevated waterfalls, full-body lounge seats with overall massaging jets, 7-person hot tubs, soft-hued lighting glowing from within the spa, and energy efficient features. That doesn't include options like stereos and stainless steel jets.
                    </p>
                    <p style="color:#797979">
                        <?php echo $cityName;?> hot tub sales run the gamut from used spas available from private parties to brand-new hot tubs with full warranties. New hot tubs can be surprisingly affordable and most Jacuzzi&reg; hot tub dealers are willing to work with you on pricing. And something to know before you go to your dealer in <?php echo $cityName;?> &#8212; hot tub sale financing is available online, so you can walk into the showroom knowing what you can afford.
                <?php }elseif($seo_page_type == 'accessories'){?>
                        In <?php echo $cityName;?>, hot tub accessories are hot! Find the best selection of Jacuzzi Hot Tubs accessories online or at your <?php echo $cityName;?> Jacuzzi&reg; dealer. Everything from hot tub covers and water cleaners to steps and beverage holders. If you love living the spa life at home in <?php echo $cityName;?>, <a class="text-link" href="http://www.jacuzzihottubs.com/accessories/">hot tub accessories</a> are a great way to make the experience even more enjoyable.
                    </p>
                    <p style="color:#797979">
                    Start by being practical and protect your investment with a hot tub cover. A hot tub cover keeps your Jacuzzi hot tub free from leaves and dirt and helps hold in the heat &#8212; a smart way to save energy costs. Steps that complement your spa make it easy to enter and exit the hot tub. Coordinating planters give you a way to change the look of your hot tub surroundings with plants that grow seasonally in <?php echo $cityName;?>. Hot tub accessories are made for fun and convenience, too. Get more tips from our blog about enhancing your spa with <a class="text-link" href="http://www.jacuzzihottubs.com/hot-tub-blog/category/hot-tub-accessories/">hot tub accessories</a>.
                    </p>
                    <p style="color:#797979">
                    Hot tub owner needs include spa supplies for maintaining clean and sparkling water. The Jacuzzi Exclusives&#8482; line has them all: cleaning and maintenance products, filters, mineral spa sanitizers, and genuine Jacuzzi parts.
                    </p>
                    <p style="color:#797979">
                    <?php echo $cityName;?> hot tub accessories are available from your Jacuzzi <a class="text-link" href="/dealer-locator/">hot tub dealer</a>. Stop by the showroom or contact your dealer for <?php echo $cityName;?> hot tub accessories.
                <?php }elseif($seo_page_type == 'reviews'){?>
                        Jacuzzi Hot Tubs is often mentioned in <?php echo $cityName;?> hot tub reviews. As one of the best-known names in hydrotherapy, Jacuzzi is held up as the standard in hot tub innovation, reliability and all-around quality. Other hot tub manufacturers' brands may seem to have many of the same features and options as Jacuzzi, but none of them can compare. Patented jets engineered by Jacuzzi, original designs and styling, a variety of sizes and affordability are just some of the plusses on the Jacuzzi side of any comparison.
                    </p>
                    <p style="color:#797979">
                        <?php echo $cityName;?> hot tub reviews also refer to Jacuzzi because <?php echo $cityName;?> is home to a Jacuzzi Hot Tubs dealership. Shoppers not only have the chance to browse online for hot tubs, or learn more about them on the Jacuzzi blog, they can also see a selection of sparkling Jacuzzi hot tubs in the <?php echo $cityName;?> Jacuzzi dealer's showroom. You can bring your swimsuit and try out a water-filled Jacuzzi when you visit the dealer, something <?php echo $cityName;?> hot tub reviews may not tell you. Relaxing in the seats, feeling the jet massage, seeing the lights glowing inside the hot tub &#8212; <?php echo $cityName;?>, hot tub reviews alone cannot describe the Jacuzzi experience!
                    </p>
                    <p style="color:#797979">
                        <?php echo $cityName;?> hot tub reviews give you a good place to start your spa search, but make plans to visit your <?php echo $html->link($cityName.' Jacuzzi Hot Tubs dealer', '/'.$stateInfo.'/'.'hot-tubs-'.str_replace(array('\'', ' ', ','), '-', strtolower($cityName)), array('class'=>'text-link'));?>. You'll see for yourself why Jacuzzi deserves high ratings.
                <?php }elseif(isset($custom_seo_text) && !empty($custom_seo_text)){ ?>
                    <?php echo $custom_seo_text;?>
                <?php }elseif($countryID['Country']['id'] == 3){ ?>
                    Massaging jets, steaming water, and inviting bubbles; Just the mere idea of spas can send you into soothing thoughts of relaxation and rejuvenation. If ideas of spoiling yourself to the hydrotherapy benefits of a whirlpool or hosting a hot tub party on your outdoor patio are circulating in your mind, it's time to visit a <?php echo $cityName;?>, <?php echo $stateName;?> hot tub retailer. Jacuzzi dealers in <?php echo $cityName;?> will provide you with all the important information about whirlpools, from indoor and outdoor options and price ranges to special sales and customer reviews. Give into your temptations, visit our retailers, view the wide selection of hot tubs and spas, and treat yourself to a tub today.
                    </p>
                    <p style="color:#797979">
                    The hot tub sitting in your backyard in <?php echo $cityName;?> is there for you when your muscles ache, when you've had a long day at the office, and when you need to spruce up your backyard party. You turn to your spa for your all relaxation needs and party entertainment, so it's important to keep your spa in prime condition to meet your expectations and lifestyle requirements. Visit your local hot tub retailer at <?php echo $d['Dealer']['address1'];?> in <?php echo $cityName;?> for all the maintenance supplies your spa requires to ensure it bubbles, heats, and spoils. At <?php echo $d['Dealer']['name'];?>, find out about the necessary chemicals, filters, covers, and parts so your spa stays in prime condition. You can also call <?php echo $d['Dealer']['phone'];?> or download a free brochure to learn more about additional accessories, such as steps, audio controls, and spa cubbies to further personalize your backyard whirlpool.
                <?php }elseif(isset($d) && !empty($d)){?>
                    <?php echo $cityName;?> hot tub providers offer first-time buyers all the must-know facts about tubs, including available indoor and outdoor selections, features, price ranges, and maintenance information, to guarantee you're prepared to choose a hot tub fitting both your preferences and budget.</p>
                    <p style="color:#797979">
                        Whether you are in search of a cozy three-seat Jacuzzi spa for intimate gatherings or you prefer a seven-person hot tub for those backyard bashes of yours, browse the hot tub dealers in <?php echo $cityName;?>, <?php echo $stateName;?> to find the whirlpool best suited to your needs. Our Jacuzzi hot tub dealer at <?php echo $d['Dealer']['address1'];?> will present you with all of the available tubs, from the ones best for private hydrotherapy to the ones ideal for hosting multiple guests. Come visit your local hot tub and spa retail store today.
                    </p>
                    <p style="color:#797979">
                        Visit a local <?php echo $cityName;?> dealer to experience Jacuzzi's winning patented design and value. There's no denying our hot tubs spoil you with the rest, relaxation, and rejuvenation you desire and deserve, but do realize your tub does need a little love and care in return. When it comes to the health and performance of your whirlpool, there are several necessary supplies and accessories available to keep it bubbling at its best, which you can find at Jacuzzi retailers. Browse the <?php echo $d['Dealer']['name'];?> selection of parts, chemicals, and filters to guarantee your backyard tub presents you with the highest quality of performance. In addition to these maintenance tools, ask your trusted Jacuzzi retailers about the variety of hot tub complements to further improve your <?php echo $cityName;?> whirlpool experience, such as covers and lifts along with other personalized accessories. Check out steps and wireless audio remotes when you visit your Jacuzzi store in <?php echo $cityName;?>. For additional information on prolonging the life of your hot tub, contact your local Jacuzzi dealers at <?php echo $d['Dealer']['phone'];?> or download a free brochure today!
                <?php }?>
            </p>
        </div>
    <?php }?>
    <?php /*if(isset($nearbyCities) && !empty($nearbyCities)):?>
    <div class="horz660"></div>
        <h2><a href="#" onclick="jQuery('#searchbystate').toggle(); return false;">+/- Search By Nearby Cities</a></h2>
        <div id="searchbystate" class="nobarbox" style="display:none">
            <?php foreach($nearbyCities as $nearbyCity):
                echo '<ul >'.$nearbyCity.'</ul>';
            endforeach; ?>
            <div class="clear"></div>
        </div>
	<?php endif; */ ?>	
	
<?php
    $_SESSION['inUSCA'] = $inUSCA;
?>
<!-- SiteCatalyst code version: H.10.
Copyright 1997-2007 Omniture, Inc. More info available at
http://www.omniture.com -->
<script language="JavaScript" src="http://www.jacuzzihottubs.com/wp-content/themes/jht/js/SiteCatalyst.js"></script>
<script language="JavaScript"><!--
/* You may give each page an identifying name, server, and channel on
the next lines. */
s.pageName=""
s.server=""
s.channel=""
s.pageType=""
s.prop1=""
s.prop2=""
s.prop3=""
s.prop4=""
s.prop5=""
s.referrer=""
/* Conversion Variables */
s.campaign=""
s.state=""
s.zip=""
s.events="event7"
s.products=""
s.purchaseID=""
s.eVar1=""
s.eVar2="<?php echo $_SESSION['country']; ?>"
s.eVar3="<?php if(!empty($_SESSION['inUSCA']) && isset($zip_searched)) { echo $zip_searched; } ?>"
s.eVar4=""
s.eVar5=""
/************* DO NOT ALTER ANYTHING BELOW THIS LINE ! **************/
var s_code=s.t();if(s_code)document.write(s_code)//--></script>
<script language="JavaScript"><!--
if(navigator.appVersion.indexOf('MSIE')>=0)document.write(unescape('%3C')+'\!-'+'-')
//--></script><noscript><a href="http://www.omniture.com" title="Web Analytics"><img
src="http://jacuzzipremiumhottubs.jacuzzi.com.112.2O7.net/b/ss/jacuzzipremiumhottubs.jacuzzi.com/1/H.10--NS/0"
height="1" width="1" border="0" alt="" /></a></noscript><!--/DO NOT REMOVE/-->
<!-- End SiteCatalyst code version: H.10. -->
