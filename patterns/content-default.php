<?php
/**
 * Title: Alkamist Content (Default)
 * 
 * Description: The default page content.
 * 
 * Slug: alkamist/content-default
 * 
 * Categories: alkamist, content
 * 
 * Keywords: alkamist, content, default
 * 
 * Block Types: core/template-part/content
 */
?>

<!-- wp:group {"tagName":"main","style":{"dimensions":{"minHeight":"100vh"}},"className":"default","layout":{"type":"constrained"}} -->
<main id="alkamist-content" class="wp-block-group default" style="min-height:100vh">
    <!-- wp:group {"tagName":"section","style":{"spacing":{"padding":{"top":"var:preset|spacing|2","right":"var:preset|spacing|2","bottom":"var:preset|spacing|2","left":"var:preset|spacing|2"}}},"className":"default","layout":{"type":"constrained"}} -->
    <section id="content-wrapper" class="wp-block-group default" style="padding-top:var(--wp--preset--spacing--2);padding-right:var(--wp--preset--spacing--2);padding-bottom:var(--wp--preset--spacing--2);padding-left:var(--wp--preset--spacing--2)">
        <!-- wp:columns {"className":"default"} -->
            <div class="wp-block-columns default" id="page-column">
                <!-- wp:column -->
                    <div class="wp-block-column"><!-- wp:post-content /--></div>
                <!-- /wp:column -->
            </div>
        <!-- /wp:columns -->
    </section>
    <!-- /wp:group -->
</main>
<!-- /wp:group -->