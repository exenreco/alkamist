<?php
/**
 * Title: Alkamist Header (Sticky)
 * 
 * Description: An Horizontal header that sticks to the top of the browser.
 * 
 * Slug: alkamist/header-sticky
 * 
 * Categories: alkamist, header
 * 
 * Keywords: alkamist, header, sticky
 * 
 * Block Types: core/template-part/header
 */
?>

<!-- wp:group {"tagName":"header","style":{"spacing":{"padding":{"top":"0","right":"0","bottom":"0","left":"0"},"blockGap":"0"},"border":{"radius":"0px","bottom":{"color":"var:preset|color|alkamist-tints","width":"4px"}},"position":{"type":"sticky","top":"0px"}},"backgroundColor":"alkamist-secondary","textColor":"alkamist-text","className":"alkamist_header","layout":{"type":"constrained"}} -->
<header id="alkamist-header" class="wp-block-group alkamist_header has-alkamist-text-color has-alkamist-secondary-background-color has-text-color has-background" style="border-radius:0px;border-bottom-color:var(--wp--preset--color--alkamist-tints);border-bottom-width:4px;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0">
    <!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
        <div class="wp-block-group">
            <!-- wp:group {"tagName":"section","className":"site_identity","layout":{"type":"constrained"}} -->
                <section id="site-identity" class="wp-block-group site_identity">
                    <!-- wp:site-logo /-->
                </section>
            <!-- /wp:group -->

            <!-- wp:group {"tagName":"section","className":"alkamist_navigation","layout":{"type":"constrained"}} -->
                <section id="alkamist-navigation" class="wp-block-group alkamist_navigation">
                    <!-- wp:navigation {"overlayMenu":"always","icon":"menu"} /-->
                </section>
            <!-- /wp:group -->
        </div>
    <!-- /wp:group -->
</header>
<!-- /wp:group -->