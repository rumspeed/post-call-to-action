<!-- create the CTA box -->
<div class="rum-post-cta-box">
	<div class="rum-post-cta-image">
		<!-- display the featured image from the embedded post/page/etc. -->
		<?php get_the_post_thumbnail() ?>
	</div>
    <div class="rum-post-cta-text">
        <!-- display the cta text -->
	    <!-- text should be the title from the embedded post/page/etc. -->
		<h2><?php echo get_the_title(); ?></h2>
    </div>
	<div class="rum-post-cta-button">
        <!-- display the cta button -->
		<?php echo get_option( 'rum_post_cta_button_text' ); ?>
    </div>
</div>
