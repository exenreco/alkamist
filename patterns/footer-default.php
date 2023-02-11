<?php
/**
 * Title: Alkamist Footer (Default)
 * 
 * Description: The default footer alkamist ships with.
 * 
 * Slug: alkamist/footer-default
 * 
 * Categories: alkamist, footer
 * 
 * Keywords: alkamist, footer, default
 * 
 * Block Types: core/template-part/footer
 */

    ## Copyright date
    $date = date("Y");

    ## Theme namespace
    $namespace = "alkamist";

    ## Developer link
    $link = "#";

    ## copright text
    $copyright = __("© $date $namespace", $namespace);
?>

<!-- wp:group {"tagName":"footer","style":{"spacing":{"padding":{"top":"var:preset|spacing|2","right":"var:preset|spacing|2","bottom":"var:preset|spacing|2","left":"var:preset|spacing|2"},"blockGap":"0"},"elements":{"link":{"color":{"text":"var:preset|color|alkamist-tertiary-text"}}}},"textColor":"alkamist-secondary-text","className":"default","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"},"fontSize":"small"} -->
<footer id="footer-wrapper" class="wp-block-group default has-alkamist-secondary-text-color has-text-color has-link-color has-small-font-size" style="padding-top:var(--wp--preset--spacing--2);padding-right:var(--wp--preset--spacing--2);padding-bottom:var(--wp--preset--spacing--2);padding-left:var(--wp--preset--spacing--2)">
    <!-- wp:group {"layout":{"type":"flex","orientation":"vertical","justifyContent":"left"},"fontSize":"small"} -->
    <div class="wp-block-group has-small-font-size">
        <!-- wp:group {"layout":{"type":"constrained"}} -->
        <div class="wp-block-group">
            <!-- wp:site-title {"level":2,"style":{"typography":{"textTransform":"uppercase"}},"fontSize":"large"} /-->
        </div>
        <!-- /wp:group -->

        <!-- wp:group {"layout":{"type":"constrained"}} -->
        <div class="wp-block-group">
            <!-- wp:paragraph {"textColor":"alkamist-background","fontSize":"small"} -->
            <p class="has-alkamist-background-color has-text-color has-small-font-size"><?php printf($copyright); ?></p>
            <!-- /wp:paragraph -->
        </div>

        <!-- /wp:group -->
    </div>
    <!-- /wp:group -->

    <!-- wp:group {"layout":{"type":"constrained"}} -->
    <div class="wp-block-group">
        <!-- wp:paragraph {"style":{"elements":{"link":{"color":{"text":"var:preset|color|alkamist-quaternary"}}}},"textColor":"alkamist-quaternary","fontSize":"small"} -->
        <p class="has-alkamist-quaternary-color has-text-color has-link-color has-small-font-size">
            <?php
                printf(
                    esc_html__( 'Proudly powered by %s', 'alkamist' ),
                    '<a href="' . 
                    esc_url( __( 'https://wordpress.org', 'alkamist' ) ) . 
                    '" rel="nofollow">WordPress</a>'
                );
            ?>
        </p>
        <!-- /wp:paragraph -->
    </div>
    <!-- /wp:group -->
</footer>
<!-- /wp:group -->