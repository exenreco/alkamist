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

<!-- wp:group {"tagName":"footer","style":{"spacing":{"padding":{"top":"0","right":"0","bottom":"0","left":"0"},"blockGap":"0"},"border":{"top":{"color":"var:preset|color|alkamist-wash","width":"8px"}}},"backgroundColor":"alkamist-secondary-background","className":"default","layout":{"type":"constrained"}} -->
<footer id="alkamist-footer" class="wp-block-group default has-alkamist-secondary-background-background-color has-background" style="border-top-color:var(--wp--preset--color--alkamist-wash);border-top-width:8px;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0">
    <!-- wp:group {"tagName":"section","style":{"spacing":{"padding":{"top":"var:preset|spacing|2","right":"var:preset|spacing|2","bottom":"var:preset|spacing|2","left":"var:preset|spacing|2"},"blockGap":"0"}},"backgroundColor":"alkamist-primary","className":"default","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
    <section id="footer-wrapper" class="wp-block-group default has-alkamist-primary-background-color has-background" style="padding-top:var(--wp--preset--spacing--2);padding-right:var(--wp--preset--spacing--2);padding-bottom:var(--wp--preset--spacing--2);padding-left:var(--wp--preset--spacing--2)">
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
    </section>
    <!-- /wp:group -->
</footer>
<!-- /wp:group -->