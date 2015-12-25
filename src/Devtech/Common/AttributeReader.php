<?php
namespace Devtech\Common;
/**
 * @author Jaco Ruit
 */
class AttributeReader {

	public $reflectionClass;

	/**
	 * @param mixed $paramClass the class name or object
	 * @param string $paramThing field name or method name
	 * @throws \InvalidArgumentException
	 */
	public function __construct($paramClass, $paramThing = null) {
		$class = new \ReflectionClass($paramClass);
		if (!is_string($paramThing)) $this->reflectionClass = $class;
		else {
			if ($class->hasProperty($paramThing)) $this->reflectionClass = $class->getProperty($paramThing);
			else if ($class->hasMethod($paramThing)) $this->reflectionClass = $class->getMethod($paramThing);
			else throw new \InvalidArgumentException("Can't reflect " . $paramThing);
		}
	}

	/**
	 * @return array array with attributes
	 */
	public function getAttributes() {
		$docComment = trim($this->reflectionClass->getDocComment());
		if (empty($docComment)) return array();
		$docComment[strlen($docComment) - 1] = "";
		$docComment[0] = "";
		$docComment = trim(str_replace("*", "", $docComment));
		if (!stristr($docComment, "[") || !stristr($docComment, "]") || stristr($docComment, "]") < stristr($docComment, "[")) return array();
		$docComment = explode("[", $docComment, 2);
		$docComment = explode("]", $docComment[1]);
		$docComment = $docComment[0];
		$attrs = explode(",", $docComment);
		$attributes = array();
		foreach ($attrs as $attribute) {
			if (!stristr($attribute, "=")) {
				$attributes[count($attributes)] = trim($attribute);
				continue;
			}
			$attribute = explode("=", $attribute, 2);
			$attributes[trim($attribute[0])] = trim($attribute[1]);
		}
		return $attributes;
	}

	/**
	 * @return object reflection class
	 */
	public function getReflectionClass() {
		return $this->reflectionClass;
	}
}