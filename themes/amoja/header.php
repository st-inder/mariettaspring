<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-PDLXFPPR');</script>
<!-- End Google Tag Manager -->
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
	<link rel="profile" href="//gmpg.org/xfn/11">
	<link rel="stylesheet" type="text/css" href="https://mariettaspringstreatment.com/wp-content/themes/amoja-child/custom.css?ver=<?php echo rand(111,999)?>">
	<?php
	/**
	 * Functions hooked in to wp_head action
	 *
	 * @see amoja_pingback_header - 1
	 */
	wp_head();

	?>
</head>
<body <?php body_class(); ?>>
	<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PDLXFPPR"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<?php wp_body_open(); ?>
<?php do_action('amoja_before_site'); ?>

<div id="page" class="hfeed site">
	<?php
	/**
	 * Functions hooked in to amoja_before_header action
	 *
	 */
	do_action('amoja_before_header');
    if (amoja_is_elementor_activated() && etb_header_enabled()) {
        do_action('etb_header');
    } else {
        get_template_part('template-parts/header/header-1');
    }

	/**
	 * Functions hooked in to amoja_before_content action
	 *
	 */
	do_action('amoja_before_content');
	$col_class = is_page_template( 'template-homepage.php' ) ? 'col-fluid clear' : 'col-full clear';
	$content_class = is_page_template( 'template-homepage.php' ) ? 'site-content-page' : 'site-content';
    if (amoja_is_elementor_activated() && (etb_single_enabled() || etb_archive_enabled()) || is_singular('etb_library') || is_singular('elementor_library')) {
        $col_class = 'col-fluid clear';
    }

	?>

	<div id="content" class="<?php echo esc_attr($content_class);?>" tabindex="-1">
		<div class="<?php echo esc_attr($col_class);?>">

<?php
/**
 * Functions hooked in to amoja_content_top action
 *
 */
do_action('amoja_content_top');

