JACUZZI
<?php
// mobile check...
if ( defined('MOBILE_DEALER_REDIRECT') ) {
    include(WWW_ROOT.'/Mobile_Detect.php');
    $detect = new Mobile_Detect();
    if ( $detect->isMobile() && ( $detect->isTablet() == false ) ) {
        // note this is still buggy...
        header( 'Location: '. FULL_BASE_URL .'/mobile-dealer-locator/' ) ;
        die;
    }
}
$wordpress_base = FULL_BASE_URL.dirname($this->base);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <!--dl--jacuzzi_ctp-->
<meta charset="UTF-8" />
<title><?php echo (isset($layoutTitle)) ? $layoutTitle : 'Dealer Locator - Sundance Spas Hot Tubs' ?></title>
<meta name="keywords" content="<?php if(isset($metaKeyword)) echo $metaKeyword ?>" />
<meta name="description" content="<?php if(isset($metaDesc)) echo $metaDesc ?>" />
<meta name="robots" content="index,follow" />
<meta name="googlebot" content="index,follow" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" media="all" href="<?php echo $wordpress_base;?>/wp-content/themes/jht/style.css" />
<link rel='stylesheet' id='thickbox-css'  href='<?php echo $wordpress_base;?>/wp-includes/js/thickbox/thickbox.css?ver=20121105' type='text/css' media='all' />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js?ver=1.7.2"></script>
<script type="text/javascript" src="<?php echo $wordpress_base;?>/wp-content/themes/jht/js/jquery.cookie.js?ver=1.0"></script>
<script type='text/javascript'>
/* <![CDATA[ */
var thickboxL10n = {"next":"Next >","prev":"< Prev","image":"Image","of":"of","close":"Close","noiframes":"This feature requires inline frames. You have iframes disabled or your browser does not support them.","loadingAnimation":"http:\/\/www.jacuzzihottubs.com\/wp-includes\/js\/thickbox\/loadingAnimation.gif","closeImage":"http:\/\/www.jacuzzihottubs.com\/wp-includes\/js\/thickbox\/tb-close.png"};
/* ]]> */
</script>
<script type='text/javascript' src='<?php echo $wordpress_base;?>/wp-includes/js/thickbox/thickbox.js?ver=3.1-20121105'></script>
<script type='text/javascript' src='<?php echo $wordpress_base;?>/wp-content/themes/jht/js/frontend.js?ver=1.2.2'></script>
<!-- begin GA Code -->
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-22814648-1']);
  _gaq.push(['_trackPageview']);
  <?php /* if(isset($ga_action)){?>
      _gaq.push(['_trackEvent', 'DealerLocator', '<?php echo $ga_action;?>', '<?php echo isset($ga_label) ? $ga_label : '';?>']);
  <?php } */ ?>

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
<!-- End GA Code -->
</head>
<body class="page locate-dealer-<?php echo $this->action == 'index' ? 'landing' : 'result' ?>">

<?php if ( isset($dealer) && $dealer['Dealer']['city'] ) { ?>
<script>dataLayer = [{'searchLocation': "<?php echo $dealer['Dealer']['city'] . ', ' . $dealer['State']['name'] . ', ' . $dealer['Country']['name']; ?>"}];</script>
<?php } ?>

<!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-MPVB5L"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-MPVB5L');</script>
<!-- End Google Tag Manager -->

<!-- ClickTale Top part -->
<script type="text/javascript">
var WRInitTime=(new Date()).getTime();
</script>
<!-- ClickTale end of Top part -->
<div class="hero">
        <div class="wrap">
            <h1 class="title"><?php echo $lngTxt['locateDealer'] ?></h1>
        </div>
    </div>
    <div class="goldBar10"></div>
    <div class="bd">
        <div class="wrap">
            <div class="twoCol">
              <?php if ($this->action == 'index') { ?>
                  <!-- some html goes here -->
                
                  <?php echo $this->element('dealerLocateBlack'); ?>
              <?php } else { ?>
                <div class="side">
                    <?php echo $this->element('dealerLocate'); ?>
                    <div class="tub-brochure-pricing">
                        <div>
                            <a href="/request-brochure/" class="gold-button-208"><span class="the-content">Free Brochure<span>&gt;</span></span></a>
                        </div>
                        <div class="pages40">
                            <img src="<?php echo FULL_BASE_URL.dirname($this->base);?>/wp-content/themes/jht/images/callouts/40-pages-thumb.png" />
                        </div>
                    </div>
                    <!--div class="scall bro">
                            <a href="/request-brochure/"><span class="icon brochure"></span><strong>Free</strong> Brochure</a>
                        </div>
                        <div class="scall quo"><a href="/get-a-quote/"><strong>Request</strong> a Quote</a></div-->
                </div>
                <div class="main">
                        <!-- START: Middle -->
                        <?php echo $this->Session->flash(); ?>
                        <?php echo $this->fetch('content'); ?>
                        <?php //echo $cakeDebug;?>
                        <!-- END: Middle -->
                        </div>
              <?php } ?>
              <?php echo $this->element('sql_dump'); ?>
            </div>
            <?php include(WWW_ROOT.'/dealer_ip/get_dealer.php');?>
<?php readfile(FULL_BASE_URL.dirname($this->base).'/ftr-dl'. ($this->action == 'index' ? 'landing' : 'results') .'/'); ?>