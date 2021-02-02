<?php declare(strict_types=1);

/*
 * This file is part of the php-extended/php-simple-cache-filesystem library
 *
 * (c) Anastaszor
 * This source file is subject to the MIT license that
 * is bundled with this source code in the file LICENSE.
 */

namespace PhpExtended\SimpleCache;

use DateInterval;
use DateTimeImmutable;
use Exception;
use InvalidArgumentException;
use Psr\SimpleCache\CacheInterface;
use RecursiveDirectoryIterator;
use SplFileInfo;
use Stringable;

/**
 * SimpleCacheFilesystem class file.
 * 
 * This class makes a cache of any folder on a filesystem.
 * 
 * @author Anastaszor
 */
class SimpleCacheFilesystem implements CacheInterface, Stringable
{
	
	/**
	 * The real path of the folder for the base cache.
	 * 
	 * @var string
	 */
	protected $_basePath;
	
	/**
	 * Builds a new SimpleCacheFilesystem based on the given folder.
	 * 
	 * @param string $filePath
	 * @throws InvalidArgumentException if the file path does not point to a
	 *                                  writeable folder
	 */
	public function __construct(string $filePath)
	{
		$realPath = \realpath($filePath);
		if(false === $realPath)
			throw new SimpleCacheInvalidArgumentException(\strtr('The given path {path} cannot be resolved to a real path.', ['{path}' => $filePath]));
		if(!\is_dir($realPath))
			throw new SimpleCacheInvalidArgumentException(\strtr('The given path {path} is not a directory.', ['{path}' => $realPath]));
		if(!\is_writable($realPath))
			throw new SimpleCacheInvalidArgumentException(\strtr('The given directory at {path} is not writeable.', ['{path}' => $realPath]));
		$this->_basePath = $realPath;
	}
	
	/**
	 * {@inheritdoc}
	 * @see \Stringable::__toString()
	 */
	public function __toString() : string
	{
		return static::class.'@'.\spl_object_hash($this);
	}
	
	/**
	 * Gets the last error from the language.
	 * 
	 * @return string
	 */
	protected function getLastError() : string
	{
		$data = \error_get_last();
		if(null === $data)
			return '(no error)';
		
		return 'File : '.$data['file'].' ; Line : '.((string) $data['line']).' ; Message : '.$data['message'];
	}
	
	/**
	 * {@inheritdoc}
	 * @see \Psr\SimpleCache\CacheInterface::get()
	 * @return mixed
	 */
	public function get($key, $default = null)
	{
		$hash = new SimpleCacheKey($key);
		$path = $hash->getPath($this->_basePath);
		if(\is_file($path))
		{
			$data = \file_get_contents($path);
			if(false === $data)
				return $default;
			$unserialized = \unserialize($data);
			if(false === $unserialized)
				return $default;
			if(!($unserialized instanceof SimpleCacheItem))
				return $default;
			$now = new DateTimeImmutable();
			if(!($unserialized->expires instanceof DateTimeImmutable))
				return $default;
			$diff = $now->getTimestamp() - $unserialized->expires->getTimestamp();
			if(0 < $diff)	// now is after expires : cache miss
				return $default;
			
			// everything ok : cache hit
			return $unserialized->value;
		}
		
		return $default;
	}
	
	/**
	 * {@inheritdoc}
	 * @see \Psr\SimpleCache\CacheInterface::set()
	 */
	public function set($key, $value, $ttl = null) : bool
	{
		$hash = new SimpleCacheKey($key);
		$path = $hash->getPath($this->_basePath);
		
		$item = new SimpleCacheItem();
		$item->key = $key;
		$item->value = $value;
		if(null === $ttl)
			$ttl = 36000;	// 10 hours
		if(\is_int($ttl))
			$ttl = DateInterval::createFromDateString('+'.((string) $ttl).' seconds');
		
		$now = new DateTimeImmutable();
		$future = $now->add($ttl);
		$item->expires = $future;
		$serialized = \serialize($item);
		
		if(!$hash->ensureDirectoryLevelExists($this->_basePath))
			return false;
		
		$bytes = \file_put_contents($path, $serialized);
		if(false === $bytes)
			return false;
		
		return true;
	}
	
	/**
	 * {@inheritdoc}
	 * @see \Psr\SimpleCache\CacheInterface::delete()
	 */
	public function delete($key) : bool
	{
		$hash = new SimpleCacheKey($key);
		$path = $hash->getPath($this->_basePath);
		if(!\is_file($path) || !\is_writable($path))
			return true;
		
		return \unlink($path);
	}
	
	/**
	 * {@inheritdoc}
	 * @see \Psr\SimpleCache\CacheInterface::clear()
	 */
	public function clear() : bool
	{
		$success = true;
		
		try
		{
			$recursiveIterator = new RecursiveDirectoryIterator(
				$this->_basePath,
				RecursiveDirectoryIterator::CURRENT_AS_FILEINFO
				| RecursiveDirectoryIterator::KEY_AS_PATHNAME
				| RecursiveDirectoryIterator::SKIP_DOTS
				| RecursiveDirectoryIterator::UNIX_PATHS
			);
			
			foreach($recursiveIterator as $splFileInfo)
			{
				/** @var SplFileInfo $splFileInfo */
				if($splFileInfo->isFile() && $splFileInfo->isWritable())
				{
					$success = $success && \unlink($splFileInfo->getPathname());
				}
			}
		}
		catch(Exception $e)
		{
			return false;
		}
		
		return (bool) $success;
	}
	
	/**
	 * {@inheritdoc}
	 * @see \Psr\SimpleCache\CacheInterface::getMultiple()
	 * @param iterable<mixed> $keys
	 * @return mixed[]
	 */
	public function getMultiple($keys, $default = null)
	{
		$values = [];
		
		foreach($keys as $key)
		{
			$values[$key] = $this->get($key, $default);
		}
		
		return $values;
	}
	
	/**
	 * {@inheritdoc}
	 * @see \Psr\SimpleCache\CacheInterface::setMultiple()
	 * @param iterable<mixed> $values
	 */
	public function setMultiple($values, $ttl = null) : bool
	{
		$success = true;
		
		foreach($values as $key => $value)
		{
			$success = $success && $this->set($key, $value, $ttl);
		}
		
		return (bool) $success;
	}
	
	/**
	 * {@inheritdoc}
	 * @see \Psr\SimpleCache\CacheInterface::deleteMultiple()
	 * @param iterable<mixed> $keys
	 */
	public function deleteMultiple($keys) : bool
	{
		$success = true;
		
		foreach($keys as $key)
		{
			$success = $success && $this->delete($key);
		}
		
		return (bool) $success;
	}
	
	/**
	 * {@inheritdoc}
	 * @see \Psr\SimpleCache\CacheInterface::has()
	 */
	public function has($key) : bool
	{
		$hash = new SimpleCacheKey($key);
		
		return \is_file($hash->getPath($this->_basePath));
	}
	
}
