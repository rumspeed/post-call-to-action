<!-- create the CTA box -->
<div class="rum-cta-box">
	<div class="">
		<!-- display the featured image from the embedded post/page/etc. -->
		<?php rum_post_cta_image() ?>
	</div>
    <div class="rum-cta-text">
        <!-- display the cta text -->
	    <!-- text should be the title from the embedded post/page/etc. -->
		<?php rum_post_cta_text() ?>
    </div>
	<div class="rum-cta-button">
        <!-- display the cta button -->
		<?php rum_post_cta_button() ?>
<!--		?php //$rum_post_cta_button_text = get_post_meta( $post => ID, '_rum_post_cta_button_text', true );
//			echo '__( '$rum_post_cta_button_text' )'; -->
    </div>
</div>
