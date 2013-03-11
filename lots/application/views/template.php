<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?=$title?></title>
		<meta name="description" content="An online document storage system for easy meeting organization.">
		<link type="text/plain" rel="author" href="<?=base_url('humans.txt');?>" />
		<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0;">
		        
    	<script src="http://code.jquery.com/jquery-1.8.2.js"></script>

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
        <link rel="stylesheet" type="text/css" href="<?=base_url('css/basic.css');?>" media="screen, handheld">
        <link rel="stylesheet" type="text/css" href="<?=base_url('css/mobile.css');?>" media="only screen and (min-width: 320px) and (max-width: 640px)">
        <link rel="stylesheet" type="text/css" href="<?=base_url('css/desktop.css');?>" media="only screen and (min-width: 640px)">
<!--         <link rel="stylesheet" href="<?=base_url('css/main.css');?>"> -->
<!--         <link rel="stylesheet" href="<?=base_url('css/parchmeet.css');?>"> -->
<!-- 	    <script src="<?=base_url('js/vendor/modernizr-2.6.2.min.js');?>"></script> -->
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->

        <!-- Add your site or application content here -->
		<header>
			<?php $this->load->view('includes/header');?>
		</header> 
		<article class="content" role="main">
			<?php $this->load->view($main_content);?>
		</article>
		<footer>
			<?php $this->load->view('includes/footer');?>
		</footer>       
        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
        <script>
            var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
            (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
            g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
            s.parentNode.insertBefore(g,s)}(document,'script'));
        </script>
        
       
    </body>
</html>
