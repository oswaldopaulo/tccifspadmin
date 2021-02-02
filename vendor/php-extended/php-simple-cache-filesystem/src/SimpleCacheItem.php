<?php declare(strict_types=1);

/*
 * This file is part of the php-extended/php-simple-cache-filesystem library
 *
 * (c) Anastaszor
 * This source file is subject to the MIT license that
 * is bundled with this source code in the file LICENSE.
 */

namespace PhpExtended\SimpleCache;

use DateTimeInterface;
use Stringable;

/**
 * SimpleCacheItem class file.
 * 
 * This class is a simple container for any value when the cache item is
 * registered.
 * 
 * @author Anastaszor
 */
class SimpleCacheItem implements Stringable
{
	
	/**
	 * The value of the key.
	 * 
	 * @var ?string
	 */
	public $key;
	
	/**
	 * The value of the item.
	 * 
	 * @var ?mixed
	 */
	public $value;
	
	/**
	 * The time when this expires.
	 * 
	 * @var ?DateTimeInterface
	 */
	public $expires;
	
	/**
	 * {@inheritdoc}
	 * @see \Stringable::__toString()
	 */
	public function __toString() : string
	{
		return static::class.'@'.\spl_object_hash($this);
	}
	
}
