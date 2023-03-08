<?php
## This script uses strict types
declare(strict_types=1);

## This script has a namespace
namespace Alkamist;

/**
 * Title: Sticky Header
 * 
 * Description: An html header that sticks to the top of the browser window on scoll.
 * 
 * Slug: alkamist/header-sticky
 * 
 * Categories: alkamist, header, sticky
 * 
 * Keywords: alkamist, header, sticky
 * 
 * Block Types: core/template-part/header
 */

## ensure patterns class exists
if( ! \class_exists( 'Alkamist\Patterns', true ) 
|| ! \method_exists( 'Alkamist\Patterns', 'sticky_header' ) )
{
    return;
}

use Alkamist\Patterns as Patterns;

$instance       = Patterns::init();
$namespace      = $instance::get_namespace();
$settings       = \do_action($namespace . "sticky_header");
?>

<!-- wp:group {"tagName":"header", "style":{"layout":{"flexSize":"98%"},"spacing":{"padding":{"top":"0","right":"0","bottom":"0","left":"0"}}},"className":"default","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"},"fontSize":"small"} -->
<header id="alkamist-header-wrapper" class="wp-block-group default has-small-font-size" style="padding-top:0;padding-right:0;padding-bottom:0;padding-left:0">
    <!-- wp:group {"tagName":"section","style":{"spacing":{"padding":{"top":"var:preset|spacing|1","right":"var:preset|spacing|1","bottom":"var:preset|spacing|1","left":"var:preset|spacing|1"},"blockGap":"var:preset|spacing|2"}},"className":"default","layout":{"type":"flex","orientation":"vertical"},"fontSize":"small"} -->
        <section id="alkamist-site-identity" class="wp-block-group default has-small-font-size" style="padding-top:var(--wp--preset--spacing--1);padding-right:var(--wp--preset--spacing--1);padding-bottom:var(--wp--preset--spacing--1);padding-left:var(--wp--preset--spacing--1)">
            <!-- wp:site-title {"textAlign":"left","style":{"typography":{"textTransform":"uppercase","fontStyle":"normal","fontWeight":"900","lineHeight":"0"},"elements":{"link":{"color":{"text":"var:preset|color|alkamist-secondary-accent"}}}},"textColor":"alkamist-secondary-accent","fontSize":"xx-large"} /-->
            <!-- wp:site-tagline {"textAlign":"left","style":{"typography":{"lineHeight":"0"}},"fontSize":"small"} /-->
        </section>
    <!-- /wp:group -->
    <!-- wp:group {"tagName":"section","style":{"spacing":{"padding":{"top":"var:preset|spacing|1","right":"var:preset|spacing|1","bottom":"var:preset|spacing|1","left":"var:preset|spacing|1"}}},"className":"default","layout":{"type":"flex","flexWrap":"nowrap"}} -->
        <section id="alkamist-header-navigation" class="wp-block-group default" style="padding-top:var(--wp--preset--spacing--1);padding-right:var(--wp--preset--spacing--1);padding-bottom:var(--wp--preset--spacing--1);padding-left:var(--wp--preset--spacing--1)"><!-- wp:navigation {"icon":"menu","style":{"spacing":{"blockGap":"var:preset|spacing|1"}}} -->
            <!-- wp:page-list /-->
            <!-- /wp:navigation -->
        </section>
    <!-- /wp:group -->
</header>
<!-- /wp:group -->

<!-- wp:paragraph {"style":{"elements":{"link":{"color":{"text":"var:preset|color|alkamist-quaternary"}}}},"textColor":"alkamist-quaternary","fontSize":"small"} -->
<p class="has-alkamist-quaternary-color has-text-color has-link-color has-small-font-size">
    <?php
        var_dump( has_action($namespace . "sticky_header") ); 
        var_dump( $settings );
    ?>
</p>
<!-- /wp:paragraph -->