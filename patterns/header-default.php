<?php
/**
 * Title: Default Header
 * 
 * Description: The default header alkamist ships with.
 * 
 * Slug: alkamist/header-default
 * 
 * Categories: alkamist, header
 * 
 * Keywords: alkamist, header
 * 
 * Block Types: core/template-part/header
 */
?>

<!-- wp:group {"tagName":"header","style":{"layout":{"flexSize":"98%"},"spacing":{"padding":{"top":"var:preset|spacing|1","right":"var:preset|spacing|1","bottom":"var:preset|spacing|1","left":"var:preset|spacing|1"}},"border":{"top":{"width":"0px","style":"none"},"right":{"width":"0px","style":"none"},"bottom":{"color":"var:preset|color|alkamist-wash","width":"0px","style":"none"},"left":{"width":"0px","style":"none"}}},"className":"default","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"},"fontSize":"small"} -->
<header id="alkamist-header-wrapper" class="wp-block-group default has-small-font-size" style="border-top-style:none;border-top-width:0px;border-right-style:none;border-right-width:0px;border-bottom-color:var(--wp--preset--color--alkamist-wash);border-bottom-style:none;border-bottom-width:0px;border-left-style:none;border-left-width:0px;padding-top:var(--wp--preset--spacing--1);padding-right:var(--wp--preset--spacing--1);padding-bottom:var(--wp--preset--spacing--1);padding-left:var(--wp--preset--spacing--1)">
    <!-- wp:group {"tagName":"section","style":{"spacing":{"padding":{"top":"0","right":"0","bottom":"0","left":"0"}}},"className":"default","layout":{"type":"constrained","justifyContent":"left"},"fontSize":"small"} -->
    <section id="alkamist-site-identity" class="wp-block-group default has-small-font-size" style="padding-top:0;padding-right:0;padding-bottom:0;padding-left:0">
        <!-- wp:site-title {"textAlign":"left","style":{"typography":{"fontSize":"2.2rem","textTransform":"uppercase","fontStyle":"normal","fontWeight":"900"}}} /-->
        <!-- wp:site-tagline {"textAlign":"left"} /-->
    </section>
    <!-- /wp:group -->

    <!-- wp:group {"tagName":"section","className":"default","layout":{"type":"constrained"}} -->
    <section id="alkamist-header-navigation" class="wp-block-group default">
        <!-- wp:navigation {"icon":"menu"} -->
        <!-- wp:page-list /-->
        <!-- /wp:navigation -->
    </section>
    <!-- /wp:group -->
</header>
<!-- /wp:group -->