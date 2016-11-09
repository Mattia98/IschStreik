<?php
include_once "model/DBObject.class.php";

class Site extends DBObject {
	
	/* Fields */
	protected $pretty_name;
	protected $name;
	protected $description;
	protected $visible;
	
	/* Other configuration */
	const COLLECTION_NAME = "Sites";

	/* *** Getter & Setter *** */

	public function getPretty_name() {
		return $this->pretty_name;
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function getDescription() {
		return $this->description;
	}

	public function getVisible() {
		return $this->visible;
	}

	public function setPretty_name($value) {
		$this->pretty_name = $value;
	}
	
	public function setName($value) {
		$this->name = $value;
	}
	
	public function setDescription($value) {
		$this->description = $value;
	}
	
	public function setVisible($value) {
		$this->visible = $value;
	}
	
	/* Virtual getters */
	
	public function getSomething() {
		throw new Exception('Not implemented yet.');
	}

	/* ***** Static Methods ***** */

	public static function findByName($name) {
		return static::findBySomething($name, "name")[0];
	}
	
	public static function findByNameAmount($name) {
		return static::findBySomethingAmount($name, "name");
	} 
}
?>