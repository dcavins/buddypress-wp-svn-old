<div class="content-header">
</div>

<div id="content">
	<h2>Create a Blog</h2>
	<?php do_action( 'template_notices' ) // (error/success feedback) ?>

	<?php if ( bp_blog_signup_enabled() ) : ?>
		
		<?php bp_show_blog_signup_form() ?>
	
	<?php else: ?>

		<div id="message" class="info">
			<p><?php _e( 'Blog registration is currently disabled', 'buddypress' ); ?></p>
		</div>

	<?php endif; ?>

</div>