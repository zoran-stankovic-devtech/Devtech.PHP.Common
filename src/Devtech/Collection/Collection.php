<?php

namespace Devtech\Collection;
/**
 * Created by PhpStorm.
 * User: nemanja.tomic
 * Date: 26.12.2014
 * Time: 15:26
 */
class Collection implements \Iterator {

	private $items = array();
	private $index = 0;
	private $listType;
	private $totalItems = 0;

	public $capacity;

	public function __construct($capacity = null) {
		$this->capacity = $capacity;
	}

	public function add($item) {
		if ($this->capacity !== null && $this->count() >= $this->capacity) {
			throw new CollectionException('Maximum capacity reached.');
		}
		if ($this->count() === 0) {
			$this->listType = get_class($item);
		}
		if (!is_a($item, $this->listType)) {
			throw new CollectionException('Wrong item type for current collection instance, please provide type of ' . $this->listType);
		}
		$this->items[] = $item;
		$this->totalItems++;
	}

	public function addMany($array) {
		if (!is_array($array)) {
			throw new \InvalidArgumentException('Passed argument must be an array.');
		}
		$newArrayItemCount = count($array);
		if ($this->capacity !== null && ($this->count() + $newArrayItemCount) >= $this->capacity) {
			throw new CollectionException('Maximum capacity reached.');
		}
		array_merge($this->items, $array);
		$this->totalItems += $newArrayItemCount;
	}

	public function remove($index) {
		if (!$this->containsIndex($index)) {
			throw new CollectionException("Element with index [$index] does not exist.");
    	}
		unset($this->items[$index]);
		$this->totalItems--;
	}

	public function get($index) {
		if (!$this->containsIndex($index)) {
			throw new CollectionException("Element with index [$index] does not exist.");
		}
		return $this->items[$index];
	}

	public function getIndex($value) {
		$searchResult = array_search($value, $this->items, true);
		return $searchResult ?: null;
	}

	public function count() {
		return $this->totalItems;
	}

	public function first() {
		return reset($this->items);
	}

	public function last() {
		return end($this->items);
	}

	public function containsIndex($index) {
		return array_key_exists($index, $this->items);
	}

	public function contains($value) {
		return in_array($value, $this->items, true);
	}

	public function clear() {
		$this->items = array();
		$this->totalItems = 0;
	}

	public function any($delegate = '') {
		if ($delegate === null || $delegate === '') {
			return $this->count() > 0;
		}
		foreach ($this->items as $item) {
			if ($delegate($item)) {
				return true;
			}
		}
		return false;
	}

	/**
	 * When a caller of this method needs to compare with another parameter from outer scope, "use" keyword should be used -
	 * e.g. $collection->where(function(User $x) use($someUser) { return $x->firstName == $someUser->firstName })
	 *
	 * @param $delegate string Anonymous function which must return bool and accept collection item as an argument.
	 * @return Collection
	 */
	public function where($delegate) {

		$foundItems = new Collection();
		foreach ($this->items as $item) {
			if ($delegate($item)) {
				$foundItems->add($item);
			}
		}
		return $foundItems;
	}

	#region Iterator implementation
	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Return the current element
	 * @link http://php.net/manual/en/iterator.current.php
	 * @return mixed Can return any type.
	 */
	public function current() {
		return $this->items[$this->index];
	}

	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Move forward to next element
	 * @link http://php.net/manual/en/iterator.next.php
	 * @return void Any returned value is ignored.
	 */
	public function next() {
		$this->index++;
	}

	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Return the key of the current element
	 * @link http://php.net/manual/en/iterator.key.php
	 * @return mixed scalar on success, or null on failure.
	 */
	public function key() {
		return $this->index;
	}

	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Checks if current position is valid
	 * @link http://php.net/manual/en/iterator.valid.php
	 * @return boolean The return value will be casted to boolean and then evaluated.
	 * Returns true on success or false on failure.
	 */
	public function valid() {
		return array_key_exists($this->key(), $this->items);
	}

	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Rewind the Iterator to the first element
	 * @link http://php.net/manual/en/iterator.rewind.php
	 * @return void Any returned value is ignored.
	 */
	public function rewind() {
		$this->index = 0;
	}
	#endregion
}