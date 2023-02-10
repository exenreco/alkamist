<?php
/**
 * Title: Timeline Blog Loop
 * 
 * Description: Display posts in a format similar to facebook feeds.
 * 
 * Slug: alkamist/blog-default
 * 
 * Categories: alkamist, blog-loop, uncategorized
 * 
 * Keywords: alkamist, blog-loop, post
 */
?>

<!-- wp:group {"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:group {"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:columns {"style":{"spacing":{"padding":{"top":"var:preset|spacing|2","right":"var:preset|spacing|2","bottom":"var:preset|spacing|2","left":"var:preset|spacing|2"}}}} -->
<div class="wp-block-columns" style="padding-top:var(--wp--preset--spacing--2);padding-right:var(--wp--preset--spacing--2);padding-bottom:var(--wp--preset--spacing--2);padding-left:var(--wp--preset--spacing--2)"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:query {"queryId":7,"query":{"perPage":3,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false},"displayLayout":{"type":"list","columns":3}} -->
<div class="wp-block-query"><!-- wp:post-template -->
<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|2","right":"0","bottom":"10px","left":"0"},"blockGap":"23px"}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"left","verticalAlignment":"top"}} -->
<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--2);padding-right:0;padding-bottom:10px;padding-left:0"><!-- wp:group {"style":{"border":{"radius":"100%","width":"0px","style":"none"},"layout":{"flexSize":"48px"}},"layout":{"type":"constrained","justifyContent":"center"}} -->
<div class="wp-block-group" style="border-style:none;border-width:0px;border-radius:100%"><!-- wp:avatar {"size":42,"isLink":true,"align":"center","style":{"border":{"radius":"100%","width":"5px"}},"borderColor":"alkamist-tertiary-background"} /--></div>
<!-- /wp:group -->

<!-- wp:group {"style":{"spacing":{"padding":{"top":"0","right":"0","bottom":"0","left":"0"},"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group" style="margin-top:0;margin-bottom:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:post-author-name {"style":{"typography":{"textTransform":"capitalize","fontStyle":"normal","fontWeight":"700"}},"fontSize":"small"} /-->

<!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"left"},"fontSize":"small"} -->
<div class="wp-block-group has-small-font-size"><!-- wp:post-date {"format":"D M d, y"} /-->

<!-- wp:paragraph -->
<p> at </p>
<!-- /wp:paragraph -->

<!-- wp:post-date {"format":"g:ia"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:quote -->
<blockquote class="wp-block-quote"><!-- wp:cover {"overlayColor":"alkamist-secondary-background","contentPosition":"center center","style":{"spacing":{"padding":{"top":"var:preset|spacing|2","right":"var:preset|spacing|2","bottom":"var:preset|spacing|2","left":"var:preset|spacing|2"}},"color":{}}} -->
<div class="wp-block-cover" style="padding-top:var(--wp--preset--spacing--2);padding-right:var(--wp--preset--spacing--2);padding-bottom:var(--wp--preset--spacing--2);padding-left:var(--wp--preset--spacing--2)"><span aria-hidden="true" class="wp-block-cover__background has-alkamist-secondary-background-background-color has-background-dim-100 has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:columns {"style":{"spacing":{"padding":{"top":"var:preset|spacing|2","right":"var:preset|spacing|2","bottom":"var:preset|spacing|2","left":"var:preset|spacing|2"}},"border":{"width":"4px","radius":"4px"}},"borderColor":"alkamist-wash"} -->
<div class="wp-block-columns has-border-color has-alkamist-wash-border-color" style="border-width:4px;border-radius:4px;padding-top:var(--wp--preset--spacing--2);padding-right:var(--wp--preset--spacing--2);padding-bottom:var(--wp--preset--spacing--2);padding-left:var(--wp--preset--spacing--2)"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:post-title {"isLink":true,"style":{"typography":{"textTransform":"capitalize"}}} /-->

<!-- wp:spacer {"height":"4px","style":{"spacing":{"margin":{"top":"var:preset|spacing|1","bottom":"var:preset|spacing|1"}}}} -->
<div style="margin-top:var(--wp--preset--spacing--1);margin-bottom:var(--wp--preset--spacing--1);height:4px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->

<!-- wp:post-content /--></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div></div>
<!-- /wp:cover --></blockquote>
<!-- /wp:quote -->
<!-- /wp:post-template -->

<!-- wp:query-pagination -->
<!-- wp:query-pagination-previous /-->

<!-- wp:query-pagination-numbers /-->

<!-- wp:query-pagination-next /-->
<!-- /wp:query-pagination -->

<!-- wp:query-no-results -->
<!-- wp:paragraph {"placeholder":"Add text or blocks that will display when a query returns no results."} -->
<p></p>
<!-- /wp:paragraph -->
<!-- /wp:query-no-results --></div>
<!-- /wp:query --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->