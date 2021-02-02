<?php declare(strict_types=1);

/*
 * This file is part of the php-extended/php-simple-cache-filesystem library
 *
 * (c) Anastaszor
 * This source file is subject to the MIT license that
 * is bundled with this source code in the file LICENSE.
 */

use PhpExtended\SimpleCache\SimpleCacheItem;
use PHPUnit\Framework\TestCase;

/**
 * SimpleCacheItemTest test file.
 * 
 * @author Anastaszor
 * @covers \PhpExtended\SimpleCache\SimpleCacheItem
 */
class SimpleCacheItemTest extends TestCase
{
	
	/**
	 * The object to test.
	 * 
	 * @var SimpleCacheItem
	 */
	protected $_object;
	
	public function testToString() : void
	{
		$this->assertEquals(\get_class($this->_object).'@'.\spl_object_hash($this->_object), $this->_object->__toString());
	}
	
	/**
	 * {@inheritdoc}
	 * @see \PHPUnit\Framework\TestCase::setUp()
	 */
	protected function setUp() : void
	{
		$this->_object = new SimpleCacheItem();
	}
	
	/**
	 * {@inheritdoc}
	 * @see \PHPUnit\Framework\TestCase::tearDown()
	 */
	protected function tearDown() : void
	{
		$this->_object = null;
	}
	
}
