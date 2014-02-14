<?php

/**
 * @group blogs
 */
class BP_Tests_Blogs_Functions extends BP_UnitTestCase {
	/**
	 * @group blogmeta
	 * @group bp_blogs_delete_blogmeta
	 */
	public function test_bp_blogs_delete_blogmeta_non_numeric_blog_id() {
		$this->assertFalse( bp_blogs_delete_blogmeta( 'foo' ) );
	}

	/**
	 * @group blogmeta
	 * @group bp_blogs_delete_blogmeta
	 */
	public function test_bp_blogs_delete_blogmeta_illegal_characters() {
		$this->assertTrue( bp_blogs_update_blogmeta( 1, 'foo', 'bar' ) );
		$this->assertSame( 'bar', bp_blogs_get_blogmeta( 1, 'foo' ) );
		$krazy_key = ' f!@#$%^o *(){}o?+';
		$this->assertTrue( bp_blogs_delete_blogmeta( 1, $krazy_key ) );
		$this->assertSame( '', bp_blogs_get_blogmeta( 1, 'foo' ) );
	}

	/**
	 * @group blogmeta
	 * @group bp_blogs_delete_blogmeta
	 */
	public function test_bp_blogs_delete_blogmeta_trim_meta_value() {
		$this->assertTrue( bp_blogs_update_blogmeta( 1, 'foo', 'bar' ) );
		$this->assertSame( 'bar', bp_blogs_get_blogmeta( 1, 'foo' ) );
		$this->assertTrue( bp_blogs_delete_blogmeta( 1, 'foo', '   bar  ') );
		$this->assertSame( '', bp_blogs_get_blogmeta( 1, 'foo' ) );
	}

	/**
	 * @group blogmeta
	 * @group bp_blogs_delete_blogmeta
	 */
	public function test_bp_blogs_delete_blogmeta_no_meta_key() {
		bp_blogs_update_blogmeta( 1, 'foo', 'bar' );
		bp_blogs_update_blogmeta( 1, 'foo2', 'bar2' );
		$this->assertNotEmpty( bp_blogs_get_blogmeta( 1 ) );
		$this->assertTrue( bp_blogs_delete_blogmeta( 1 ) );
		$this->assertSame( array(), bp_blogs_get_blogmeta( 1 ) );
	}

	/**
	 * @group blogmeta
	 * @group bp_blogs_delete_blogmeta
	 */
	public function test_bp_blogs_delete_blogmeta_with_meta_value() {
		bp_blogs_update_blogmeta( 1, 'foo', 'bar' );
		$this->assertSame( 'bar', bp_blogs_get_blogmeta( 1, 'foo' ) );
		bp_blogs_delete_blogmeta( 1, 'foo', 'baz' );
		$this->assertSame( 'bar', bp_blogs_get_blogmeta( 1, 'foo' ) );
		$this->assertTrue( bp_blogs_delete_blogmeta( 1, 'foo', 'bar' ) );
		$this->assertSame( '', bp_blogs_get_blogmeta( 1, 'foo' ) );
	}

	/**
	 * @group blogmeta
	 * @group bp_blogs_delete_blogmeta
	 */
	public function test_bp_blogs_delete_blogmeta_with_delete_all_but_no_meta_key() {
		// With no meta key, don't delete for all items - just delete
		// all for a single item
		bp_blogs_add_blogmeta( 1, 'foo', 'bar' );
		bp_blogs_add_blogmeta( 1, 'foo1', 'bar1' );
		bp_blogs_add_blogmeta( 2, 'foo', 'bar' );
		bp_blogs_add_blogmeta( 2, 'foo1', 'bar1' );

		$this->assertTrue( bp_blogs_delete_blogmeta( 1, '', '', true ) );
		$this->assertEmpty( bp_blogs_get_blogmeta( 1 ) );
		$this->assertSame( 'bar', bp_blogs_get_blogmeta( 2, 'foo' ) );
		$this->assertSame( 'bar1', bp_blogs_get_blogmeta( 2, 'foo1' ) );
	}

	/**
	 * @group blogmeta
	 * @group bp_blogs_delete_blogmeta
	 */
	public function test_bp_blogs_delete_blogmeta_with_delete_all() {
		// With no meta key, don't delete for all items - just delete
		// all for a single item
		bp_blogs_add_blogmeta( 1, 'foo', 'bar' );
		bp_blogs_add_blogmeta( 1, 'foo1', 'bar1' );
		bp_blogs_add_blogmeta( 2, 'foo', 'bar' );
		bp_blogs_add_blogmeta( 2, 'foo1', 'bar1' );

		$this->assertTrue( bp_blogs_delete_blogmeta( 1, 'foo', '', true ) );
		$this->assertEmpty( '', bp_blogs_get_blogmeta( 1, 'foo' ) );
		$this->assertEmpty( '', bp_blogs_get_blogmeta( 2, 'foo' ) );
		$this->assertSame( 'bar1', bp_blogs_get_blogmeta( 1, 'foo1' ) );
		$this->assertSame( 'bar1', bp_blogs_get_blogmeta( 2, 'foo1' ) );
	}

	/**
	 * @group blogmeta
	 * @group bp_blogs_get_blogmeta
	 */
	public function test_bp_blogs_get_blogmeta_empty_blog_id() {
		$this->assertFalse( bp_blogs_get_blogmeta( 0 ) );
		$this->assertFalse( bp_blogs_get_blogmeta( '' ) );
	}

	/**
	 * @group blogmeta
	 * @group bp_blogs_get_blogmeta
	 */
	public function test_bp_blogs_get_blogmeta_illegal_characters() {
		bp_blogs_update_blogmeta( 1, 'foo', 'bar' );
		$krazy_key = ' f!@#$%^o *(){}o?+';
		$this->assertSame( 'bar', bp_blogs_get_blogmeta( 1, $krazy_key ) );
	}

	/**
	 * @group blogmeta
	 * @group bp_blogs_get_blogmeta
	 */
	public function test_bp_blogs_get_blogmeta_no_meta_key() {
		bp_blogs_update_blogmeta( 1, 'foo', 'bar' );
		bp_blogs_update_blogmeta( 1, 'foo2', 'bar2' );

		$this->assertSame( array( 'bar', 'bar2', ), bp_blogs_get_blogmeta( 1 ) );
	}

	/**
	 * @group blogmeta
	 * @group bp_blogs_get_blogmeta
	 */
	public function test_bp_blogs_get_blogmeta_no_meta_key_empty() {
		$this->assertSame( array(), bp_blogs_get_blogmeta( 1 ) );
	}

	/**
	 * @group blogmeta
	 * @group bp_blogs_get_blogmeta
	 */
	public function test_bp_blogs_get_blogmeta_single_true() {
		bp_blogs_add_blogmeta( 1, 'foo', 'bar' );
		bp_blogs_add_blogmeta( 1, 'foo', 'baz' );
		$this->assertSame( 'bar', bp_blogs_get_blogmeta( 1, 'foo' ) ); // default is true
		$this->assertSame( 'bar', bp_blogs_get_blogmeta( 1, 'foo', true ) );
	}

	/**
	 * @group blogmeta
	 * @group bp_blogs_get_blogmeta
	 */
	public function test_bp_blogs_get_blogmeta_single_false() {
		bp_blogs_add_blogmeta( 1, 'foo', 'bar' );
		bp_blogs_add_blogmeta( 1, 'foo', 'baz' );
		$this->assertSame( array( 'bar', 'baz' ), bp_blogs_get_blogmeta( 1, 'foo', false ) );
	}
	/**
	 * @group blogmeta
	 * @group bp_blogs_update_blogmeta
	 */
	public function test_bp_blogs_update_blogmeta_non_numeric_blog_id() {
		$this->assertFalse( bp_blogs_update_blogmeta( 'foo', 'foo', 'bar' ) );
	}

	/**
	 * @group blogmeta
	 * @group bp_blogs_update_blogmeta
	 */
	public function test_bp_blogs_update_blogmeta_illegal_characters() {
		$krazy_key = ' f!@#$%^o *(){}o?+';
		bp_blogs_update_blogmeta( 1, $krazy_key, 'bar' );
		$this->assertSame( 'bar', bp_blogs_get_blogmeta( 1, 'foo' ) );
	}

	/**
	 * @group blogmeta
	 * @group bp_blogs_update_blogmeta
	 */
	public function test_bp_blogs_update_blogmeta_stripslashes() {
		$slashed = 'This \"string\" is cool';
		bp_blogs_update_blogmeta( 1, 'foo', $slashed );
		$this->assertSame( 'This "string" is cool', bp_blogs_get_blogmeta( 1, 'foo' ) );
	}

	/**
	 * @group blogmeta
	 * @group bp_blogs_update_blogmeta
	 */
	public function test_bp_blogs_update_blogmeta_new() {
		$this->assertTrue( bp_blogs_update_blogmeta( 1, 'foo', 'bar' ) );
		$this->assertSame( 'bar', bp_blogs_get_blogmeta( 1, 'foo' ) );
	}

	/**
	 * @group blogmeta
	 * @group bp_blogs_update_blogmeta
	 */
	public function test_bp_blogs_update_blogmeta_existing() {
		bp_blogs_update_blogmeta( 1, 'foo', 'bar' );
		$this->assertSame( 'bar', bp_blogs_get_blogmeta( 1, 'foo' ) );
		$this->assertTrue( bp_blogs_update_blogmeta( 1, 'foo', 'baz' ) );
		$this->assertSame( 'baz', bp_blogs_get_blogmeta( 1, 'foo' ) );
	}

	/**
	 * @group blogmeta
	 * @group bp_blogs_update_blogmeta
	 */
	public function test_bp_blogs_update_blogmeta_existing_no_change() {
		bp_blogs_update_blogmeta( 1, 'foo', 'bar' );
		$this->assertSame( 'bar', bp_blogs_get_blogmeta( 1, 'foo' ) );
		$this->assertFalse( bp_blogs_update_blogmeta( 1, 'foo', 'bar' ) );
	}

	/**
	 * @group blogmeta
	 * @group bp_blogs_update_blogmeta
	 */
	public function test_bp_blogs_update_meta_prev_value() {
		bp_blogs_add_blogmeta( 1, 'foo', 'bar' );
		$this->assertFalse( bp_blogs_update_blogmeta( 1, 'foo', 'bar2', 'baz' ) );
		$this->assertTrue( bp_blogs_update_blogmeta( 1, 'foo', 'bar2', 'bar' ) );
	}

	/**
	 * @group blogmeta
	 * @group bp_blogs_add_blogmeta
	 */
	public function test_bp_blogs_add_blogmeta_no_meta_key() {
		$this->assertFalse( bp_blogs_add_blogmeta( 1, '', 'bar' ) );
	}

	/**
	 * @group blogmeta
	 * @group bp_blogs_add_blogmeta
	 */
	public function test_bp_blogs_add_blogmeta_empty_object_id() {
		$this->assertFalse( bp_blogs_add_blogmeta( 0, 'foo', 'bar' ) );
	}

	/**
	 * @group blogmeta
	 * @group bp_blogs_add_blogmeta
	 */
	public function test_bp_blogs_add_blogmeta_existing_unique() {
		bp_blogs_add_blogmeta( 1, 'foo', 'bar' );
		$this->assertFalse( bp_blogs_add_blogmeta( 1, 'foo', 'baz', true ) );
	}

	/**
	 * @group blogmeta
	 * @group bp_blogs_add_blogmeta
	 */
	public function test_bp_blogs_add_blogmeta_existing_not_unique() {
		bp_blogs_add_blogmeta( 1, 'foo', 'bar' );
		$this->assertNotEmpty( bp_blogs_add_blogmeta( 1, 'foo', 'baz' ) );
	}
}
