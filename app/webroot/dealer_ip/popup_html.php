<?php
if ( $city_name ) {
$popped = false;
if ( isset($_GET['popped']) && $_GET['popped'] == true ) $popped = true;

if ( $popped ) {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sundance Spas Truckload</title>
<style type="text/css">
@font-face {
    font-family: 'GSMT';
    src: url('/wp-content/themes/jht/fonts/gsmt-webfont.eot');
    src: url('/wp-content/themes/jht/fonts/gsmt-webfont.eot?#iefix') format('embedded-opentype'),
         url('/wp-content/themes/jht/fonts/gsmt-webfont.woff') format('woff'),
         url('/wp-content/themes/jht/fonts/gsmt-webfont.ttf') format('truetype'),
         url('/wp-content/themes/jht/fonts/gsmt-webfont.svg#GSMT') format('svg');
    font-weight: normal;
    font-style: normal;
}
body { margin: 0; padding: 0 }
#tpop { float: left; width: 536px; height: 224px; background: url(/wp-content/themes/jht/images/bg/truckpop.jpg) no-repeat 0 0; padding: 17px 0 0 24px; font-family: "GSMT", Arial, Helvetica, sans-serif; color: #fff; position: relative }
#tpop h3 { margin: 0; font-size: 19px; line-height: 19px; font-weight: normal; color: #dfac00; text-transform: uppercase; font-style: italic }
#tpop h1 { margin: 0; font-size: 40px; line-height: 40px; text-transform: uppercase; font-weight: normal }
#tpop h4 { margin: 10px 0 6px; font-size: 18px; line-height: 20px; font-weight: normal; letter-spacing: 0.012em }
#tpop h2 { margin: 0; font-size: 20px; line-height: 24px; color: #e0ac00; text-transform: uppercase; font-weight: normal; letter-spacing: 0.02em }
#tpop a { float: left; width: 190px; font: bold 12px/18px Arial, Helvetica, sans-serif; padding: 196px 355px 0 15px; height: 45px; position: absolute; top: 0; left: 0; text-align: center; text-transform: uppercase; background: url(/wp-content/themes/jht/images/icons/tbtn.png) no-repeat 15px 187px; color: #000; text-decoration: none; text-shadow: 1px 1px 1px #fff }
</style>
</head>
<body>
<?php } ?>
<div id="tpop">
<h3>Congratulations</h3>
<h1><?php echo $city_name; ?>!</h1>
<h4>The Sundance Spas Truckload Sale<br />
is coming to your town.</h4>
<h2>Save up to 50%</h2>
<a href="http://www.jacuzzitruckload.com" target="_blank">View Details</a>
</div>
<?php if ( $popped ) { ?>
</body>
</html>
<?php }
}
?>