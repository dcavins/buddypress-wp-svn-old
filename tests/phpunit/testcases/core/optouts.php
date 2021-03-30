<?php
/**
 * @group core
 * @group optouts
 */
 class BP_Tests_Optouts extends BP_UnitTestCase {
	public function test_bp_optouts_add_optout_vanilla() {
		$old_current_user = get_current_user_id();

		$u1 = $this->factory->user->create();
		$this->set_current_user( $u1 );

		// Create a couple of optouts.
		$args = array(
			'email_address'     => 'one@wp.org',
			'user_id'           => $u1,
			'email_type'        => 'annoyance'
		);
		$i1 = bp_add_optout( $args );
		$args['email_address'] = 'two@wp.org';
		$i2 = bp_add_optout( $args );

		$get_args = array(
			'user_id'        => $u1,
			'fields'         => 'ids',
		);
		$optouts = bp_get_optouts( $get_args );
		$this->assertEqualSets( array( $i1, $i2 ), $optouts );

		$this->set_current_user( $old_current_user );
	}

	public function test_bp_optouts_add_optout_avoid_duplicates() {
		$old_current_user = get_current_user_id();

		$u1 = $this->factory->user->create();
		$this->set_current_user( $u1 );

		// Create an optouts.
		$args = array(
			'email_address'     => 'one@wp.org',
			'user_id'           => $u1,
			'email_type'        => 'annoyance'
		);
		$i1 = bp_add_optout( $args );
		// Attempt to create a duplicate. Should return existing optout id.
		$i2 = bp_add_optout( $args );
		$this->assertEquals( $i1, $i2 );

		$this->set_current_user( $old_current_user );
	}

	public function test_bp_optouts_delete_optout() {
		$old_current_user = get_current_user_id();

		$u1 = $this->factory->user->create();
		$this->set_current_user( $u1 );

		$args = array(
			'email_address'     => 'one@wp.org',
			'user_id'           => $u1,
			'email_type'        => 'annoyance'
		);
		$i1 = bp_add_optout( $args );
		bp_delete_optout_by_id( $i1 );

		$get_args = array(
			'user_id'        => $u1,
			'fields'         => 'ids',
		);
		$optouts = bp_get_optouts( $get_args );
		$this->assertTrue( empty( $optouts ) );

		$this->set_current_user( $old_current_user );
	}

	public function test_bp_optouts_get_by_search_terms() {
		$old_current_user = get_current_user_id();

		$u1 = $this->factory->user->create();
		$this->set_current_user( $u1 );

		// Create a couple of optouts.
		$args = array(
			'email_address'     => 'one@wpfrost.org',
			'user_id'           => $u1,
			'email_type'        => 'annoyance'
		);
		$i1 = bp_add_optout( $args );
		$args['email_address'] = 'two@wp.org';
		$i2 = bp_add_optout( $args );

		$get_args = array(
			'search_terms'   => 'one@wpfrost.org',
			'fields'         => 'ids',
		);
		$optouts = bp_get_optouts( $get_args );
		$this->assertEqualSets( array( $i1 ), $optouts );

		$this->set_current_user( $old_current_user );
	}

}