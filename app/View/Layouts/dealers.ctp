DEALERS
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

// hreflang
function jht_do_hreflang() {
    $url = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
    $p = parse_url($url);
    $a = array(
        '/hot-tub-dealer-locator/quebec-qc/hot-tubs-valdor/' => '<link rel="alternate" href="/hot-tub-dealer-locator/quebec-qc/hot-tubs-valdor/" hreflang="en-us" /><link rel="alternate" href="http://www.sundancespas.ca/hot-tub-dealer-locator/quebec-qc/hot-tubs-valdor/" hreflang="en-ca" />',
        '/hot-tub-dealer-locator/quebec-qc/hot-tubs-saint-jean-sur-richelieu' => '<link rel="alternate" href="/hot-tub-dealer-locator/quebec-qc/hot-tubs-saint-jean-sur-richelieu/" hreflang="en-us" /><link rel="alternate" href="http://www.sundancespas.ca/hot-tub-dealer-locator/quebec-qc/hot-tubs-saint-jean-sur-richelieu/" hreflang="en-ca" />',
        '/hot-tub-dealer-locator/british-columbia-bc/hot-tubs-fernie' => '<link rel="alternate" href="/hot-tub-dealer-locator/british-columbia-bc/hot-tubs-fernie/" hreflang="en-us" /><link rel="alternate" href="http://www.sundancespas.ca/hot-tub-dealer-locator/british-columbia-bc/hot-tubs-fernie/" hreflang="en-ca" />',
        '/hot-tub-dealer-locator/manitoba-mb/hot-tubs-winnipeg' => '<link rel="alternate" href="/hot-tub-dealer-locator/manitoba-mb/hot-tubs-winnipeg/" hreflang="en-us" /><link rel="alternate" href="http://www.sundancespas.ca/hot-tub-dealer-locator/manitoba-mb/hot-tubs-winnipeg/" hreflang="en-ca" />',
        '/hot-tub-dealer-locator/quebec-qc/hot-tubs-brossard' => '<link rel="alternate" href="/hot-tub-dealer-locator/quebec-qc/hot-tubs-brossard/" hreflang="en-us" /><link rel="alternate" href="http://www.sundancespas.ca/hot-tub-dealer-locator/quebec-qc/hot-tubs-brossard/" hreflang="en-ca" />',
        '/hot-tub-dealer-locator/quebec-qc/hot-tubs-bois-des-filion' => '<link rel="alternate" href="/hot-tub-dealer-locator/quebec-qc/hot-tubs-bois-des-filion/" hreflang="en-us" /><link rel="alternate" href="http://www.sundancespas.ca/hot-tub-dealer-locator/quebec-qc/hot-tubs-bois-des-filion/" hreflang="en-ca" />',
        '/hot-tub-dealer-locator/quebec-qc/hot-tubs-ville-vanier' => '<link rel="alternate" href="/hot-tub-dealer-locator/quebec-qc/hot-tubs-ville-vanier/" hreflang="en-us" /><link rel="alternate" href="http://www.sundancespas.ca/hot-tub-dealer-locator/quebec-qc/hot-tubs-ville-vanier/" hreflang="en-ca" />',
        '/hot-tub-dealer-locator/quebec-qc/hot-tubs-levis' => '<link rel="alternate" href="/hot-tub-dealer-locator/quebec-qc/hot-tubs-levis/" hreflang="en-us" /><link rel="alternate" href="http://www.sundancespas.ca/hot-tub-dealer-locator/quebec-qc/hot-tubs-levis/" hreflang="en-ca" />',
        '/hot-tub-dealer-locator/quebec-qc/hot-tubs-granby' => '<link rel="alternate" href="/hot-tub-dealer-locator/quebec-qc/hot-tubs-granby/" hreflang="en-us" /><link rel="alternate" href="http://www.sundancespas.ca/hot-tub-dealer-locator/quebec-qc/hot-tubs-granby/" hreflang="en-ca" />',
        '/hot-tub-dealer-locator/quebec-qc/hot-tubs-vaudreuil-dorion' => '<link rel="alternate" href="/hot-tub-dealer-locator/quebec-qc/hot-tubs-vaudreuil-dorion/" hreflang="en-us" /><link rel="alternate" href="http://www.sundancespas.ca/hot-tub-dealer-locator/quebec-qc/hot-tubs-vaudreuil-dorion/" hreflang="en-ca" />',
        '/hot-tub-dealer-locator/quebec-qc/hot-tubs-victoriaville' => '<link rel="alternate" href="/hot-tub-dealer-locator/quebec-qc/hot-tubs-victoriaville/" hreflang="en-us" /><link rel="alternate" href="http://www.sundancespas.ca/hot-tub-dealer-locator/quebec-qc/hot-tubs-victoriaville/" hreflang="en-ca" />',
        '/hot-tub-dealer-locator/quebec-qc/hot-tubs-shawinigan-sud' => '<link rel="alternate" href="/hot-tub-dealer-locator/quebec-qc/hot-tubs-shawinigan-sud/" hreflang="en-us" /><link rel="alternate" href="http://www.sundancespas.ca/hot-tub-dealer-locator/quebec-qc/hot-tubs-shawinigan-sud/" hreflang="en-ca" />',
        '/hot-tub-dealer-locator/quebec-qc/hot-tubs-drummondville' => '<link rel="alternate" href="/hot-tub-dealer-locator/quebec-qc/hot-tubs-drummondville/" hreflang="en-us" /><link rel="alternate" href="http://www.sundancespas.ca/hot-tub-dealer-locator/quebec-qc/hot-tubs-drummondville/" hreflang="en-ca" />',
        '/hot-tub-dealer-locator/quebec-qc/hot-tubs-gatineau' => '<link rel="alternate" href="/hot-tub-dealer-locator/quebec-qc/hot-tubs-gatineau/" hreflang="en-us" /><link rel="alternate" href="http://www.sundancespas.ca/hot-tub-dealer-locator/quebec-qc/hot-tubs-gatineau/" hreflang="en-ca" />',
        '/hot-tub-dealer-locator/british-columbia-bc/hot-tubs-vancouver' => '<link rel="alternate" href="/hot-tub-dealer-locator/british-columbia-bc/hot-tubs-vancouver/" hreflang="en-us" /><link rel="alternate" href="http://www.sundancespas.ca/hot-tub-dealer-locator/british-columbia-bc/hot-tubs-vancouver/" hreflang="en-ca" />',
        '/hot-tub-dealer-locator/ontario-on/hot-tubs-newmarket' => '<link rel="alternate" href="/hot-tub-dealer-locator/ontario-on/hot-tubs-newmarket/" hreflang="en-us" /><link rel="alternate" href="http://www.sundancespas.ca/hot-tub-dealer-locator/ontario-on/hot-tubs-newmarket/" hreflang="en-ca" />',
        '/hot-tub-dealer-locator/ontario-on/hot-tubs-whitby' => '<link rel="alternate" href="/hot-tub-dealer-locator/ontario-on/hot-tubs-whitby/" hreflang="en-us" /><link rel="alternate" href="http://www.sundancespas.ca/hot-tub-dealer-locator/ontario-on/hot-tubs-whitby/" hreflang="en-ca" />',
        '/hot-tub-dealer-locator/ontario-on/hot-tubs-thunder-bay' => '<link rel="alternate" href="/hot-tub-dealer-locator/ontario-on/hot-tubs-thunder-bay/" hreflang="en-us" /><link rel="alternate" href="http://www.sundancespas.ca/hot-tub-dealer-locator/ontario-on/hot-tubs-thunder-bay/" hreflang="en-ca" />',
        '/hot-tub-dealer-locator/quebec-qc/hot-tubs-laval' => '<link rel="alternate" href="/hot-tub-dealer-locator/quebec-qc/hot-tubs-laval/" hreflang="en-us" /><link rel="alternate" href="http://www.sundancespas.ca/hot-tub-dealer-locator/quebec-qc/hot-tubs-laval/" hreflang="en-ca" />',
        '/hot-tub-dealer-locator/quebec-qc/hot-tubs-auteuil-laval' => '<link rel="alternate" href="/hot-tub-dealer-locator/quebec-qc/hot-tubs-auteuil-laval/" hreflang="en-us" /><link rel="alternate" href="http://www.sundancespas.ca/hot-tub-dealer-locator/quebec-qc/hot-tubs-auteuil-laval/" hreflang="en-ca" />',
        '/hot-tub-dealer-locator/quebec-qc/hot-tubs-blainville' => '<link rel="alternate" href="/hot-tub-dealer-locator/quebec-qc/hot-tubs-blainville/" hreflang="en-us" /><link rel="alternate" href="http://www.sundancespas.ca/hot-tub-dealer-locator/quebec-qc/hot-tubs-blainville/" hreflang="en-ca" />',
        '/hot-tub-dealer-locator/quebec-qc/hot-tubs-st-eustache' => '<link rel="alternate" href="/hot-tub-dealer-locator/quebec-qc/hot-tubs-st-eustache/" hreflang="en-us" /><link rel="alternate" href="http://www.sundancespas.ca/hot-tub-dealer-locator/quebec-qc/hot-tubs-st-eustache/" hreflang="en-ca" />',
        '/hot-tub-dealer-locator/quebec-qc/hot-tubs-longueuil' => '<link rel="alternate" href="/hot-tub-dealer-locator/quebec-qc/hot-tubs-longueuil/" hreflang="en-us" /><link rel="alternate" href="http://www.sundancespas.ca/hot-tub-dealer-locator/quebec-qc/hot-tubs-longueuil/" hreflang="en-ca" />',
        '/hot-tub-dealer-locator/quebec-qc/hot-tubs-rimouski' => '<link rel="alternate" href="/hot-tub-dealer-locator/quebec-qc/hot-tubs-rimouski/" hreflang="en-us" /><link rel="alternate" href="http://www.sundancespas.ca/hot-tub-dealer-locator/quebec-qc/hot-tubs-rimouski/" hreflang="en-ca" />',
        '/hot-tub-dealer-locator/alberta-ab/hot-tubs-calgary' => '<link rel="alternate" href="/hot-tub-dealer-locator/alberta-ab/hot-tubs-calgary/" hreflang="en-us" /><link rel="alternate" href="http://www.sundancespas.ca/hot-tub-dealer-locator/alberta-ab/hot-tubs-calgary/" hreflang="en-ca" />',
        '/hot-tub-dealer-locator/quebec-qc/hot-tubs-repontigny' => '<link rel="alternate" href="/hot-tub-dealer-locator/quebec-qc/hot-tubs-repontigny/" hreflang="en-us" /><link rel="alternate" href="http://www.sundancespas.ca/hot-tub-dealer-locator/quebec-qc/hot-tubs-repontigny/" hreflang="en-ca" />',
        '/hot-tub-dealer-locator/ontario-on/hot-tubs-southampton' => '<link rel="alternate" href="/hot-tub-dealer-locator/ontario-on/hot-tubs-southampton/" hreflang="en-us" /><link rel="alternate" href="http://www.sundancespas.ca/hot-tub-dealer-locator/ontario-on/hot-tubs-southampton/" hreflang="en-ca" />',
        '/hot-tub-dealer-locator/quebec-qc/hot-tubs-st.-hubert/ http://www.sundancespas.ca/hot-tub-dealer-locator/quebec-qc/hot-tubs-st.-hubert/    <link rel="alternate" /hot-tub-dealer-locator/quebec-qc/hot-tubs-st.-hubert/ hreflang="en-us" /><link rel="alternate" href="http://www.sundancespas.ca/hot-tub-dealer-locator/quebec-qc/hot-tubs-st.-hubert/" hreflang="en-ca" />',
        '/hot-tub-dealer-locator/quebec-qc/hot-tubs-sorel-tracy' => '<link rel="alternate" href="/hot-tub-dealer-locator/quebec-qc/hot-tubs-sorel-tracy/" hreflang="en-us" /><link rel="alternate" href="http://www.sundancespas.ca/hot-tub-dealer-locator/quebec-qc/hot-tubs-sorel-tracy/" hreflang="en-ca" />',
        '/hot-tub-dealer-locator/quebec-qc/hot-tubs-thetford-mines' => '<link rel="alternate" href="/hot-tub-dealer-locator/quebec-qc/hot-tubs-thetford-mines/" hreflang="en-us" /><link rel="alternate" href="http://www.sundancespas.ca/hot-tub-dealer-locator/quebec-qc/hot-tubs-thetford-mines/" hreflang="en-ca" />',
        '/hot-tub-dealer-locator/quebec-qc/hot-tubs-chicoutimi' => '<link rel="alternate" href="/hot-tub-dealer-locator/quebec-qc/hot-tubs-chicoutimi/" hreflang="en-us" /><link rel="alternate" href="http://www.sundancespas.ca/hot-tub-dealer-locator/quebec-qc/hot-tubs-chicoutimi/" hreflang="en-ca" />',
        '/hot-tub-dealer-locator/quebec-qc/hot-tubs-terrebonne' => '<link rel="alternate" href="/hot-tub-dealer-locator/quebec-qc/hot-tubs-terrebonne/" hreflang="en-us" /><link rel="alternate" href="http://www.sundancespas.ca/hot-tub-dealer-locator/quebec-qc/hot-tubs-terrebonne/" hreflang="en-ca" />',
        '/hot-tub-dealer-locator/alberta-ab/hot-tubs-edmonton' => '<link rel="alternate" href="/hot-tub-dealer-locator/alberta-ab/hot-tubs-edmonton/" hreflang="en-us" /><link rel="alternate" href="http://www.sundancespas.ca/hot-tub-dealer-locator/alberta-ab/hot-tubs-edmonton/" hreflang="en-ca" />',
        '/hot-tub-dealer-locator/quebec-qc/hot-tubs-sherbrooke' => '<link rel="alternate" href="/hot-tub-dealer-locator/quebec-qc/hot-tubs-sherbrooke/" hreflang="en-us" /><link rel="alternate" href="http://www.sundancespas.ca/hot-tub-dealer-locator/quebec-qc/hot-tubs-sherbrooke/" hreflang="en-ca" />',
        '/hot-tub-dealer-locator/alberta-ab/hot-tubs-red-deer' => '<link rel="alternate" href="/hot-tub-dealer-locator/alberta-ab/hot-tubs-red-deer/" hreflang="en-us" /><link rel="alternate" href="http://www.sundancespas.ca/hot-tub-dealer-locator/alberta-ab/hot-tubs-red-deer/" hreflang="en-ca" />',
        '/hot-tub-dealer-locator/quebec-qc/hot-tubs-st-jerome' => '<link rel="alternate" href="/hot-tub-dealer-locator/quebec-qc/hot-tubs-st-jerome/" hreflang="en-us" /><link rel="alternate" href="http://www.sundancespas.ca/hot-tub-dealer-locator/quebec-qc/hot-tubs-st-jerome/" hreflang="en-ca" />',
        '/hot-tub-dealer-locator/ontario-on/hot-tubs-kingston' => '<link rel="alternate" href="/hot-tub-dealer-locator/ontario-on/hot-tubs-kingston/" hreflang="en-us" /><link rel="alternate" href="http://www.sundancespas.ca/hot-tub-dealer-locator/ontario-on/hot-tubs-kingston/" hreflang="en-ca" />',
        '/hot-tub-dealer-locator/ontario-on/hot-tubs-brockville' => '<link rel="alternate" href="/hot-tub-dealer-locator/ontario-on/hot-tubs-brockville/" hreflang="en-us" /><link rel="alternate" href="http://www.sundancespas.ca/hot-tub-dealer-locator/ontario-on/hot-tubs-brockville/" hreflang="en-ca" />',
        '/hot-tub-dealer-locator/ontario-on/hot-tubs-belleville' => '<link rel="alternate" href="/hot-tub-dealer-locator/ontario-on/hot-tubs-belleville/" hreflang="en-us" /><link rel="alternate" href="http://www.sundancespas.ca/hot-tub-dealer-locator/ontario-on/hot-tubs-belleville/" hreflang="en-ca" />',
        '/hot-tub-dealer-locator/ontario-on/hot-tubs-hamilton' => '<link rel="alternate" href="/hot-tub-dealer-locator/ontario-on/hot-tubs-hamilton/" hreflang="en-us" /><link rel="alternate" href="http://www.sundancespas.ca/hot-tub-dealer-locator/ontario-on/hot-tubs-hamilton/" hreflang="en-ca" />',
        '/hot-tub-dealer-locator/ontario-on/hot-tubs-burlington' => '<link rel="alternate" href="/hot-tub-dealer-locator/ontario-on/hot-tubs-burlington/" hreflang="en-us" /><link rel="alternate" href="http://www.sundancespas.ca/hot-tub-dealer-locator/ontario-on/hot-tubs-burlington/" hreflang="en-ca" />',
        '/hot-tub-dealer-locator/ontario-on/hot-tubs-oakville' => '<link rel="alternate" href="/hot-tub-dealer-locator/ontario-on/hot-tubs-oakville/" hreflang="en-us" /><link rel="alternate" href="http://www.sundancespas.ca/hot-tub-dealer-locator/ontario-on/hot-tubs-oakville/" hreflang="en-ca" />',
        '/hot-tub-dealer-locator/british-columbia-bc/hot-tubs-victoria' => '<link rel="alternate" href="/hot-tub-dealer-locator/british-columbia-bc/hot-tubs-victoria/" hreflang="en-us" /><link rel="alternate" href="http://www.sundancespas.ca/hot-tub-dealer-locator/british-columbia-bc/hot-tubs-victoria/" hreflang="en-ca" />',
        '/hot-tub-dealer-locator/quebec-qc/hot-tubs-pierrefonds' => '<link rel="alternate" href="/hot-tub-dealer-locator/quebec-qc/hot-tubs-pierrefonds/" hreflang="en-us" /><link rel="alternate" href="http://www.sundancespas.ca/hot-tub-dealer-locator/quebec-qc/hot-tubs-pierrefonds/" hreflang="en-ca" />',
        '/hot-tub-dealer-locator/quebec-qc/hot-tubs-st.-constant/   http://www.sundancespas.ca/hot-tub-dealer-locator/quebec-qc/hot-tubs-st.-constant/  <link rel="alternate" /hot-tub-dealer-locator/quebec-qc/hot-tubs-st.-constant/ hreflang="en-us" /><link rel="alternate" href="http://www.sundancespas.ca/hot-tub-dealer-locator/quebec-qc/hot-tubs-st.-constant/" hreflang="en-ca" />',
        '/hot-tub-dealer-locator/ontario-on/hot-tubs-orleans' => '<link rel="alternate" href="/hot-tub-dealer-locator/ontario-on/hot-tubs-orleans/" hreflang="en-us" /><link rel="alternate" href="http://www.sundancespas.ca/hot-tub-dealer-locator/ontario-on/hot-tubs-orleans/" hreflang="en-ca" />',
        '/hot-tub-dealer-locator/ontario-on/hot-tubs-nepean' => '<link rel="alternate" href="/hot-tub-dealer-locator/ontario-on/hot-tubs-nepean/" hreflang="en-us" /><link rel="alternate" href="http://www.sundancespas.ca/hot-tub-dealer-locator/ontario-on/hot-tubs-nepean/" hreflang="en-ca" />',
        '/hot-tub-dealer-locator/quebec-qc/hot-tubs-ste-agathe' => '<link rel="alternate" href="/hot-tub-dealer-locator/quebec-qc/hot-tubs-ste-agathe/" hreflang="en-us" /><link rel="alternate" href="http://www.sundancespas.ca/hot-tub-dealer-locator/quebec-qc/hot-tubs-ste-agathe/" hreflang="en-ca" />',
        '/hot-tub-dealer-locator/ontario-on/hot-tubs-harrow' => '<link rel="alternate" href="/hot-tub-dealer-locator/ontario-on/hot-tubs-harrow/" hreflang="en-us" /><link rel="alternate" href="http://www.sundancespas.ca/hot-tub-dealer-locator/ontario-on/hot-tubs-harrow/" hreflang="en-ca" />',
        '/hot-tub-dealer-locator/ontario-on/hot-tubs-london' => '<link rel="alternate" href="/hot-tub-dealer-locator/ontario-on/hot-tubs-london/" hreflang="en-us" /><link rel="alternate" href="http://www.sundancespas.ca/hot-tub-dealer-locator/ontario-on/hot-tubs-london/" hreflang="en-ca" />',
        '/hot-tub-dealer-locator/quebec-qc/hot-tubs-montreal' => '<link rel="alternate" href="/hot-tub-dealer-locator/quebec-qc/hot-tubs-montreal/" hreflang="en-us" /><link rel="alternate" href="http://www.sundancespas.ca/hot-tub-dealer-locator/quebec-qc/hot-tubs-montreal/" hreflang="en-ca" />',
        '/hot-tub-dealer-locator/quebec-qc/hot-tubs-st-georges' => '<link rel="alternate" href="/hot-tub-dealer-locator/quebec-qc/hot-tubs-st-georges/" hreflang="en-us" /><link rel="alternate" href="http://www.sundancespas.ca/hot-tub-dealer-locator/quebec-qc/hot-tubs-st-georges/" hreflang="en-ca" />',
        '/hot-tub-dealer-locator/quebec-qc/hot-tubs-notre-dame-des-prairies' => '<link rel="alternate" href="/hot-tub-dealer-locator/quebec-qc/hot-tubs-notre-dame-des-prairies/" hreflang="en-us" /><link rel="alternate" href="http://www.sundancespas.ca/hot-tub-dealer-locator/quebec-qc/hot-tubs-notre-dame-des-prairies/" hreflang="en-ca" />',
        '/hot-tub-dealer-locator/quebec-qc/hot-tubs-cowansville' => '<link rel="alternate" href="/hot-tub-dealer-locator/quebec-qc/hot-tubs-cowansville/" hreflang="en-us" /><link rel="alternate" href="http://www.sundancespas.ca/hot-tub-dealer-locator/quebec-qc/hot-tubs-cowansville/" hreflang="en-ca" />',
        '/hot-tub-dealer-locator/quebec-qc/hot-tubs-valleyfield' => '<link rel="alternate" href="/hot-tub-dealer-locator/quebec-qc/hot-tubs-valleyfield/" hreflang="en-us" /><link rel="alternate" href="http://www.sundancespas.ca/hot-tub-dealer-locator/quebec-qc/hot-tubs-valleyfield/" hreflang="en-ca" />',
        '/hot-tub-dealer-locator/ontario-on/hot-tubs-mississauga' => '<link rel="alternate" href="/hot-tub-dealer-locator/ontario-on/hot-tubs-mississauga/" hreflang="en-us" /><link rel="alternate" href="http://www.sundancespas.ca/hot-tub-dealer-locator/ontario-on/hot-tubs-mississauga/" hreflang="en-ca" />',
        '/hot-tub-dealer-locator/quebec-qc/hot-tubs-beloeil' => '<link rel="alternate" href="/hot-tub-dealer-locator/quebec-qc/hot-tubs-beloeil/" hreflang="en-us" /><link rel="alternate" href="http://www.sundancespas.ca/hot-tub-dealer-locator/quebec-qc/hot-tubs-beloeil/" hreflang="en-ca" />',
        '/hot-tub-dealer-locator/ontario-on/hot-tubs-collingwood' => '<link rel="alternate" href="/hot-tub-dealer-locator/ontario-on/hot-tubs-collingwood/" hreflang="en-us" /><link rel="alternate" href="http://www.sundancespas.ca/hot-tub-dealer-locator/ontario-on/hot-tubs-collingwood/" hreflang="en-ca" />',
        '/hot-tub-dealer-locator/quebec-qc/hot-tubs-st-hyacinthe' => '<link rel="alternate" href="/hot-tub-dealer-locator/quebec-qc/hot-tubs-st-hyacinthe/" hreflang="en-us" /><link rel="alternate" href="http://www.sundancespas.ca/hot-tub-dealer-locator/quebec-qc/hot-tubs-st-hyacinthe/" hreflang="en-ca" />',
        '/hot-tub-dealer-locator/quebec-qc/hot-tubs-st--catharines' => '<link rel="alternate" href="/hot-tub-dealer-locator/quebec-qc/hot-tubs-st--catharines/" hreflang="en-us" /><link rel="alternate" href="http://www.sundancespas.ca/hot-tub-dealer-locator/quebec-qc/hot-tubs-st--catharines/" hreflang="en-ca" />',
    );
  return $a[ $p['path'] ];
}



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <!--dl--dealers_ctp-->
<meta charset="UTF-8" />
<title><?php echo (isset($layoutTitle)) ? $layoutTitle : 'Dealer Locator - Sundance Spas' ?></title>
<meta name="keywords" content="<?php if(isset($metaKeyword)) echo $metaKeyword ?>" />
<meta name="description" content="<?php if(isset($metaDesc)) echo $metaDesc ?>" />
<meta name="robots" content="index,follow" />
<meta name="googlebot" content="index,follow" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" media="all" href="<?php echo $wordpress_base;?>/wp-content/themes/jht/style.css" />
<link rel="stylesheet" type="text/css" media="all" href="<?php echo $wordpress_base;?>/wp-content/themes/jht/style-dlanding.css" />
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
<script type='text/javascript' src='<?php echo $wordpress_base;?>/wp-content/themes/jht/js/jquery.placeholder.js?ver=1.0'></script>
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
<?php echo jht_do_hreflang(); ?>
</head>
<body class="page locate-dealer-<?php echo $this->action == 'index' ? 'landing' : 'result' ?> page-template">

<?php if ( $dealer['Dealer']['city'] ) { ?>
<script>dataLayer = [{'searchLocation': "<?php echo $dealer['Dealer']['city'] . ', ' . $dealer['State']['name'] . ', ' . $dealer['Country']['name']; ?>"}];</script>
<?php } ?>

<!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-NTFWKQ"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-NTFWKQ');</script>
<!-- End Google Tag Manager -->

<!-- ClickTale Top part -->
<script type="text/javascript">
var WRInitTime=(new Date()).getTime();
</script>
<!-- ClickTale end of Top part -->
<?php /*
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
                            <img src="/wp-content/themes/jht/images/callouts/40-pages-thumb.png" />
                        </div>
                    </div>
                    <!--div class="scall bro">
                            <a href="/request-brochure/"><span class="icon brochure"></span><strong>Free</strong> Brochure</a>
                        </div>
                        <div class="scall quo"><a href="/get-a-quote/"><strong>Request</strong> a Quote</a></div-->
                </div>
                <div class="main">
                        <!-- START: Middle -->
                        */?>
                        <?php echo $this->Session->flash(); ?>
                        <?php echo $this->fetch('content'); ?>
                        <?php //echo $cakeDebug;?>
                        <!-- END: Middle -->
<?php /*                        </div>
              <?php } ?>
              <?php echo $this->element('sql_dump'); ?>
            </div>
 */  ?>
            <?php include(WWW_ROOT.'/dealer_ip/get_dealer.php');?>
<?php readfile(FULL_BASE_URL.dirname($this->base).'/ftr-dl'. ($this->action == 'index' ? 'landing' : 'results') .'/'); ?>
