<?php

/**
 * @group groups
 * @group functions
 */
class BP_Tests_Groups_Functions extends BP_UnitTestCase {
	/**
	 * @group total_group_count
	 * @group groups_join_group
	 */
	public function test_total_group_count_groups_join_group() {
		$u1 = $this->create_user();
		$u2 = $this->create_user();
		$g = $this->factory->group->create( array( 'creator_id' => $u1 ) );

		groups_join_group( $g, $u2 );
		$this->assertEquals( 1, bp_get_user_meta( $u2, 'total_group_count', true ) );
	}

	/**
	 * @group total_group_count
	 * @group groups_leave_group
	 */
	public function test_total_group_count_groups_leave_group() {
		$u1 = $this->create_user();
		$u2 = $this->create_user();
		$g1 = $this->factory->group->create( array( 'creator_id' => $u1 ) );
		$g2 = $this->factory->group->create( array( 'creator_id' => $u1 ) );
		groups_join_group( $g1, $u2 );
		groups_join_group( $g2, $u2 );

		groups_leave_group( $g1, $u2 );
		$this->assertEquals( 1, bp_get_user_meta( $u2, 'total_group_count', true ) );
	}

	/**
	 * @group total_group_count
	 * @group groups_ban_member
	 */
	public function test_total_group_count_groups_ban_member() {
		$u1 = $this->create_user();
		$u2 = $this->create_user();
		$g1 = $this->factory->group->create( array( 'creator_id' => $u1 ) );
		$g2 = $this->factory->group->create( array( 'creator_id' => $u1 ) );
		groups_join_group( $g1, $u2 );
		groups_join_group( $g2, $u2 );

		// Fool the admin check
		$this->set_current_user( $u1 );
		buddypress()->is_item_admin = true;

		groups_ban_member( $u2, $g1 );

		$this->assertEquals( 1, bp_get_user_meta( $u2, 'total_group_count', true ) );
	}

	/**
	 * @group total_group_count
	 * @group groups_unban_member
	 */
	public function test_total_group_count_groups_unban_member() {
		$u1 = $this->create_user();
		$u2 = $this->create_user();
		$g1 = $this->factory->group->create( array( 'creator_id' => $u1 ) );
		$g2 = $this->factory->group->create( array( 'creator_id' => $u1 ) );
		groups_join_group( $g1, $u2 );
		groups_join_group( $g2, $u2 );

		// Fool the admin check
		$this->set_current_user( $u1 );
		buddypress()->is_item_admin = true;

		groups_ban_member( $u2, $g1 );

		groups_unban_member( $u2, $g1 );

		$this->assertEquals( 2, bp_get_user_meta( $u2, 'total_group_count', true ) );
	}

	/**
	 * @group total_group_count
	 * @group groups_accept_invite
	 */
	public function test_total_group_count_groups_accept_invite() {
		$u1 = $this->create_user();
		$u2 = $this->create_user();
		$g = $this->factory->group->create();
		groups_invite_user( array(
			'user_id' => $u1,
			'group_id' => $g,
			'inviter_id' => $u2,
		) );

		groups_accept_invite( $u2, $g );

		$this->assertEquals( 1, bp_get_user_meta( $u2, 'total_group_count', true ) );
	}

	/**
	 * @group total_group_count
	 * @group groups_accept_membership_request
	 */
	public function test_total_group_count_groups_accept_membership_request() {
		$u = $this->create_user();
		$g = $this->factory->group->create();
		groups_send_membership_request( $u, $g );

		groups_accept_membership_request( 0, $u, $g );

		$this->assertEquals( 1, bp_get_user_meta( $u, 'total_group_count', true ) );
	}

	/**
	 * @group total_group_count
	 * @group groups_remove_member
	 */
	public function test_total_group_count_groups_remove_member() {
		$u1 = $this->create_user();
		$u2 = $this->create_user();
		$g1 = $this->factory->group->create( array( 'creator_id' => $u1 ) );
		$g2 = $this->factory->group->create( array( 'creator_id' => $u1 ) );
		groups_join_group( $g1, $u2 );
		groups_join_group( $g2, $u2 );

		// Fool the admin check
		$this->set_current_user( $u1 );
		buddypress()->is_item_admin = true;

		groups_remove_member( $u2, $g1 );

		$this->assertEquals( 1, bp_get_user_meta( $u2, 'total_group_count', true ) );
	}

	/**
	 * @group total_member_count
	 * @group groups_join_group
	 */
	public function test_total_member_count_groups_join_group() {
		$u1 = $this->create_user();
		$u2 = $this->create_user();
		$g = $this->factory->group->create( array( 'creator_id' => $u1 ) );

		groups_join_group( $g, $u2 );
		$this->assertEquals( 2, groups_get_groupmeta( $g, 'total_member_count' ) );
	}

	/**
	 * @group total_member_count
	 * @group groups_leave_group
	 */
	public function test_total_member_count_groups_leave_group() {
		$u1 = $this->create_user();
		$g1 = $this->factory->group->create( array( 'creator_id' => $u1 ) );
		groups_join_group( $g1, $u1 );

		groups_leave_group( $g1, $u1 );
		$this->assertEquals( 1, groups_get_groupmeta( $g1, 'total_member_count' ) );
	}

	/**
	 * @group total_member_count
	 * @group groups_ban_member
	 */
	public function test_total_member_count_groups_ban_member() {
		$u1 = $this->create_user();
		$u2 = $this->create_user();
		$g1 = $this->factory->group->create( array( 'creator_id' => $u1 ) );
		groups_join_group( $g1, $u2 );

		// Fool the admin check
		$this->set_current_user( $u1 );
		buddypress()->is_item_admin = true;

		groups_ban_member( $u2, $g1 );

		$this->assertEquals( 1, groups_get_groupmeta( $g1, 'total_member_count' ) );
	}

	/**
	 * @group total_member_count
	 * @group groups_unban_member
	 */
	public function test_total_member_count_groups_unban_member() {
		$u1 = $this->create_user();
		$u2 = $this->create_user();
		$g1 = $this->factory->group->create( array( 'creator_id' => $u1 ) );
		groups_join_group( $g1, $u2 );

		// Fool the admin check
		$this->set_current_user( $u1 );
		buddypress()->is_item_admin = true;

		groups_ban_member( $u2, $g1 );

		groups_unban_member( $u2, $g1 );

		$this->assertEquals( 2, groups_get_groupmeta( $g1, 'total_member_count' ) );
	}

	/**
	 * @group total_member_count
	 * @group groups_accept_invite
	 */
	public function test_total_member_count_groups_accept_invite() {
		$u1 = $this->create_user();
		$u2 = $this->create_user();
		$g = $this->factory->group->create( array( 'creator_id' => $u1 ) );
		groups_invite_user( array(
			'user_id' => $u1,
			'group_id' => $g,
			'inviter_id' => $u2,
		) );

		groups_accept_invite( $u2, $g );

		$this->assertEquals( 2, groups_get_groupmeta( $g, 'total_member_count' ) );
	}

	/**
	 * @group total_member_count
	 * @group groups_accept_membership_request
	 */
	public function test_total_member_count_groups_accept_membership_request() {
		$u1 = $this->create_user();
		$u2 = $this->create_user();
		$g = $this->factory->group->create( array( 'creator_id' => $u1 ) );

		groups_send_membership_request( $u2, $g );
		groups_accept_membership_request( 0, $u2, $g );

		$this->assertEquals( 2, groups_get_groupmeta( $g, 'total_member_count' ) );
	}

	/**
	 * @group total_member_count
	 * @group groups_remove_member
	 */
	public function test_total_member_count_groups_remove_member() {
		$u1 = $this->create_user();
		$u2 = $this->create_user();
		$g1 = $this->factory->group->create( array( 'creator_id' => $u1 ) );
		groups_join_group( $g1, $u2 );

		// Fool the admin check
		$this->set_current_user( $u1 );
		buddypress()->is_item_admin = true;

		groups_remove_member( $u2, $g1 );

		$this->assertEquals( 1, groups_get_groupmeta( $g1, 'total_member_count' ) );
	}

	/**
	 * @group total_member_count
	 * @group groups_create_group
	 */
	public function test_total_member_count_groups_create_group() {
		$u1 = $this->create_user();
		$g = groups_create_group( array(
			'creator_id' => $u1,
			'name' => 'Boone Is Handsome',
			'description' => 'Yes',
			'slug' => 'boone-is-handsome',
			'status' => 'public',
			'enable_forum' => 0,
			'date_created' => bp_core_current_time(),
		) );

		$this->assertEquals( 1, groups_get_groupmeta( $g, 'total_member_count' ) );
	}

	/**
	 * @group groupmeta
	 * @ticket BP5180
	 */
	public function test_groups_update_groupmeta_with_line_breaks() {
		$g = $this->factory->group->create();
		$meta_value = 'Foo!

Bar!';
		groups_update_groupmeta( $g, 'linebreak_test', $meta_value );

		$this->assertEquals( $meta_value, groups_get_groupmeta( $g, 'linebreak_test' ) );
	}

	/**
	 * @group groupmeta
	 */
	public function test_groups_update_groupmeta_non_numeric_id() {
		$this->assertFalse( groups_update_groupmeta( 'foo', 'bar', 'baz' ) );
	}

	/**
	 * @group groupmeta
	 */
	public function test_groups_update_groupmeta_stripslashes() {
		$g = $this->factory->group->create();
		$value = "This string is totally slashin\'!";
		groups_update_groupmeta( $g, 'foo', $value );

		$this->assertSame( stripslashes( $value ), groups_get_groupmeta( $g, 'foo' ) );
	}

	/**
	 * @group groupmeta
	 */
	public function test_groups_update_groupmeta_new() {
		$g = $this->factory->group->create();
		$this->assertEquals( '', groups_get_groupmeta( $g, 'foo' ), '"foo" meta should be empty for this group.' );
		$this->assertTrue( groups_update_groupmeta( $g, 'foo', 'bar' ) );
		$this->assertSame( 'bar', groups_get_groupmeta( $g, 'foo' ) );
	}

	/**
	 * @group groupmeta
	 */
	public function test_groups_update_groupmeta_existing() {
		$g = $this->factory->group->create();
		groups_update_groupmeta( $g, 'foo', 'bar' );
		$this->assertSame( 'bar', groups_get_groupmeta( $g, 'foo' ), '"foo" meta should be set already for this group.' );
		$this->assertTrue( groups_update_groupmeta( $g, 'foo', 'baz' ) );
		$this->assertSame( 'baz', groups_get_groupmeta( $g, 'foo' ) );
	}

	/**
	 * @group groupmeta
	 */
	public function test_groups_update_groupmeta_existing_same_value() {
		$g = $this->factory->group->create();
		groups_update_groupmeta( $g, 'foo', 'bar' );
		$this->assertSame( 'bar', groups_get_groupmeta( $g, 'foo' ), '"foo" meta should be set already for this group.' );
		$this->assertFalse( groups_update_groupmeta( $g, 'foo', 'bar' ) );
		$this->assertSame( 'bar', groups_get_groupmeta( $g, 'foo' ) );
	}

	/**
	 * @group groupmeta
	 *
	 * @todo Why do we do this?
	 */
	public function test_groups_get_groupmeta_with_illegal_key_characters() {
		$g = $this->factory->group->create();
		groups_update_groupmeta( $g, 'foo', 'bar' );

		$krazy_key = ' f!@#$%^o *(){}o?+';
		$this->assertSame( groups_get_groupmeta( $g, 'foo' ), groups_get_groupmeta( $g, $krazy_key ) );
	}

	/**
	 * @group groupmeta
	 */
	public function test_groups_get_groupmeta_all_metas() {
		$g = $this->factory->group->create();
		groups_update_groupmeta( $g, 'foo', 'bar' );
		groups_update_groupmeta( $g, 'Boone', 'is cool' );

		// There's likely some other keys (total_member_count etc)
		// Just check to make sure both of ours are there
		$metas = groups_get_groupmeta( $g );
		$count = count( $metas );
		$this->assertSame( 'bar', $metas[ $count - 2 ] );
		$this->assertSame( 'is cool', $metas[ $count - 1 ] );
	}

	/**
	 * @group groupmeta
	 */
	public function test_groups_get_groupmeta_all_metas_empty() {
		$g = $this->factory->group->create();

		// Get rid of any auto-created values
		groups_delete_groupmeta( $g );

		$metas = groups_get_groupmeta( $g );
		$this->assertSame( array(), $metas );
	}

	/**
	 * @group groupmeta
	 */
	public function test_groups_get_groupmeta_empty() {
		$g = $this->factory->group->create();
		$this->assertSame( '', groups_get_groupmeta( $g, 'foo' ) );
	}

	/**
	 * @group groupmeta
	 */
	public function test_groups_delete_groupmeta_non_numeric_id() {
		$this->assertFalse( groups_delete_groupmeta( 'foo', 'bar' ) );
	}

	/**
	 * @group groupmeta
	 */
	public function test_groups_delete_groupmeta_with_illegal_key_characters() {
		$g = $this->factory->group->create();
		$this->assertTrue( groups_update_groupmeta( $g, 'foo', 'bar' ), 'Value of "foo" should be set at this point.' );

		$krazy_key = ' f!@#$%^o *(){}o?+';
		$this->assertTrue( groups_delete_groupmeta( $g, $krazy_key ) );
		$this->assertSame( '', groups_get_groupmeta( $g, 'foo' ) );
	}
}
