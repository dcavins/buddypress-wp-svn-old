<?php
/**
 * BuddyPress - Members Settings ( Delete Account )
 *
 * @since 1.0.0
 */

bp_nouveau_member_hook( 'before', 'settings_template' ); ?>

<h2 class="screen-heading delete-account-screen warn">
	<?php _e( 'Delete Account', 'buddypress' ); ?>
</h2>

<?php bp_nouveau_user_feedback( 'member-delete-account' ); ?>

<form action="<?php echo esc_url( bp_displayed_user_domain() . bp_get_settings_slug() . '/delete-account' ); ?>" name="account-delete-form" id="#account-delete-form" class="standard-form" method="post">

	<label id="delete-account-understand" class="warn" for="delete-account-understand">
		<input class="disabled" type="checkbox" name="delete-account-understand" value="1" data-bp-disable-input="#delete-account-button" />
		<?php _e( 'I understand the consequences.', 'buddypress' ); ?>
	</label>

	<?php bp_nouveau_submit_button( 'member-delete-account' ); ?>

</form>

<?php
bp_nouveau_member_hook( 'after', 'settings_template' );
