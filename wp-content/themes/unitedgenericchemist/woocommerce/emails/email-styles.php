<?php
/**
 * Email Styles
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-styles.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates/Emails
 * @version 3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Load colors.
$bg              = get_option( 'woocommerce_email_background_color' );
$body            = get_option( 'woocommerce_email_body_background_color' );
$base            = get_option( 'woocommerce_email_base_color' );
$base_text       = wc_light_or_dark( $base, '#202020', '#ffffff' );
$text            = get_option( 'woocommerce_email_text_color' );

// Pick a contrasting color for links.
$link = wc_hex_is_light( $base ) ? $base : $base_text;
if ( wc_hex_is_light( $body ) ) {
	$link = wc_hex_is_light( $base ) ? $base_text : $base;
}

$bg_darker_10    = wc_hex_darker( $bg, 10 );
$body_darker_10  = wc_hex_darker( $body, 10 );
$base_lighter_20 = wc_hex_lighter( $base, 20 );
$base_lighter_40 = wc_hex_lighter( $base, 40 );
$text_lighter_20 = wc_hex_lighter( $text, 20 );

// !important; is a gmail hack to prevent styles being stripped if it doesn't like something.
?>
#wrapper {
	background-color: <?php echo esc_attr( $bg ); ?>;
	margin: 0;
	padding: 70px 0 70px 0;
	-webkit-text-size-adjust: none !important;
	width: 100%;
}

#template_container {
	box-shadow: 0 1px 4px rgba(0,0,0,0.1) !important;
	background-color: <?php echo esc_attr( $body ); ?>;
	border: 1px solid <?php echo esc_attr( $bg_darker_10 ); ?>;
	border-radius: 3px !important;
}

#template_header {
	background-color: <?php echo esc_attr( $base ); ?>;
	border-radius: 3px 3px 0 0 !important;
	color: <?php echo esc_attr( $base_text ); ?>;
	border-bottom: 0;
	font-weight: bold;
	line-height: 100%;
	vertical-align: middle;
	font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;
}

#template_header h1,
#template_header h1 a {
	color: <?php echo esc_attr( $base_text ); ?>;
}

#template_footer td {
	padding: 0;	
}

#template_footer #credit {
	border:0;
	color: <?php echo esc_attr( $base_lighter_40 ); ?>;
	font-family: Arial;
	font-size:12px;
	line-height:125%;
	text-align:center;
	padding: 0 0 0 0;
}
#template_footer #credit tr td a {
     color: <?php echo esc_attr( $base ); ?>;
}
#body_content {
	background-color: <?php echo esc_attr( $body ); ?>;
}

#body_content table td {
	padding: 30px 0 0;
}
#padding_0 {
      padding: 30px 0 0;
}
#body_content table td td {
	padding: 12px;
}

#body_content table td th {
	padding: 12px;
}

#body_content td ul.wc-item-meta {
	font-size: small;
	margin: 1em 0 0;
	padding: 0;
	list-style: none;
}

#body_content td ul.wc-item-meta li {
	margin: 0.5em 0 0;
	padding: 0;
}

#body_content td ul.wc-item-meta li p {
	margin: 0;
}

#body_content p {
	margin: 0 0 16px;
}

#body_content_inner {
    color: <?php echo esc_attr( $text_lighter_20 ); ?>;
    font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;
    font-size: 14px;
    line-height: 150%;
    padding: 0 30px;
    margin-bottom: 30px;
    text-align: <?php echo is_rtl() ? 'right' : 'left'; ?>;
}

.td {
	color: <?php echo esc_attr( $text_lighter_20 ); ?>;
	border: 1px solid <?php echo esc_attr( $body_darker_10 ); ?>;
	vertical-align: middle;
}

.address {
	padding:12px 12px 0;
	color: <?php echo esc_attr( $text_lighter_20 ); ?>;	
}

.text {
	color: <?php echo esc_attr( $text ); ?>;
	font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;
}

.link {
	color: <?php echo esc_attr( $base ); ?>;
}

#header_wrapper {
	padding: 34px 30px 34px 0;
	display: block;
}

h1 {
	color: <?php echo esc_attr( $base ); ?>;
	font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;
	font-size: 30px;
	font-weight: 300;
	line-height: 150%;
	margin: 0;
	text-align: right;
	text-shadow: 0 1px 0 <?php echo esc_attr( $base_lighter_20 ); ?>;
}

h2 {
	color: <?php echo esc_attr( $base ); ?>;
	display: block;
	font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;
	font-size: 18px;
	font-weight: bold;
	line-height: 130%;
	margin: 0 0 18px;
	text-align: <?php echo is_rtl() ? 'right' : 'left'; ?>;
}

h3 {
	color: <?php echo esc_attr( $base ); ?>;
	display: block;
	font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;
	font-size: 16px;
	font-weight: bold;
	line-height: 130%;
	margin: 16px 0 8px;
	text-align: <?php echo is_rtl() ? 'right' : 'left'; ?>;
}

a {
	color: <?php echo esc_attr( $link ); ?>;
	font-weight: normal;
	text-decoration: underline;
}

img {
	border: none;
	display: inline-block;
	font-size: 14px;
	font-weight: bold;
	height: auto;
	outline: none;
	text-decoration: none;
	text-transform: capitalize;
	vertical-align: middle;
	margin-<?php echo is_rtl() ? 'left' : 'right'; ?>: 10px;
}
#template_header_image {
    padding-left: 30px;
}
h2 small {
    font-size:10px;
    width:100%;
    float:left;
    display: inline-block;    
}
#site_title {
    line-height: normal;
    display: inline-block;
    text-align:center;
    width:100%;
    float: left;
}
#bg-cyan-top {
   text-align:center;
   background-color: #19bcbc;
   margin: 0 0 15px;
}
#bg-cyan-top tr td {
   padding:3px;
   font-size: 14px;
   color: #ffffff;
   border-left: 1px solid #ffffff;
   font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;
}
#bg-cyan-top tr td a {
    color: #ffffff;
    text-decoration:none;
}
#bg-cyan-top tr td:first-child {
   border-left: 0 none;
}
#bg-cyan-bottom {
   text-align:center;
   background-color: #19bcbc;
   margin: 0 0 0;
}
#bg-cyan-bottom tr td {
   padding:3px;
   font-size: 14px;
   color: #ffffff;
   border-left: 1px solid #ffffff;
   font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;
}
#bg-cyan-bottom tr td:first-child {
   border-left: 0 none;
}
#bg-gray-bottom {
   text-align:center;
   background-color: #f2f2f2;
   margin: 0 0 0;
   border: 1px solid #dddddd;
}
#bg-gray-bottom tr td {
   padding:6px 3px 3px;
   color: #000000;
   font-size: 14px;
   font-weight:700;
   border-left: 1px solid #dddddd;
   font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;
}
#bg-gray-bottom tr td:first-child {
   border-left: 0 none;
}
#paypal_btn {
   font-weight: normal;
    text-decoration: none !important;
    text-align: center;
    background-color: #01558b;
    color: #ffffff;
    padding: 10px 20px;
    display: inline-block;
    border-radius: 4px;    
   border-radius: 4px;
   -webkit-border-radius: 4px;
   -moz-border-radius: 4px;
   -ms-border-radius: 4px;
   text-transform: uppercase !important;
   animation: colorchange 1s; 
   -webkit-animation: colorchange 1s; 
   animation:colorchange 1s;
    -moz-animation:colorchange 1s infinite;
    -webkit-animation:colorchange 1s infinite;
}
#paypal_btn:hover {   
   background-color: #51BCBC;
   color: #ffffff;
}
@keyframes colorchange {
  0%   {background: #51BCBC;}
  25%  {background: #19568B;}
  50%  {background: #51BCBC;}
  75%  {background: #19568B;}
  100% {background: #51BCBC;}
}

@-webkit-keyframes colorchange {
  0%   {background: #51BCBC;}
  25%  {background: #19568B;}
  50%  {background: #51BCBC;}
  75%  {background: #19568B;}
  100% {background: #51BCBC;}
}
<?php
