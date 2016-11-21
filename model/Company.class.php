<?php
include_once "DBObject.class.php";

class Company extends DBObject {
	
	/* Fields */
	protected $name;
	protected $website;
	protected $region;
	protected $province;
	
	/* Other configuration */
	const COLLECTION_NAME = "Companies";

	/* *** Getter & Setter *** */

	public function getName() {
		return $this->name;
	}
	
	public function getWebsite() {
		return $this->website;
	}
	
	public function getRegion() {
		return $this->region;
	}
	
	public function getProvince() {
		return $this->province;
	}
	
	public function setName($value) {
		$this->name = $value;
	}
	
	public function setWebsite($value) {
		$this->website = $value;
	}
	
	public function setRegion($value) {
		$this->region = $value;
	}

	public function setProvince($value) {
		$this->province = $value;
	}
	
	/* Virtual getters */
	
	public function getSomething() {
		throw new Exception('Not implemented yet.');
	}

	/* ***** Static Methods ***** */

	public static function findByPlaygroundID($id) {
		return static::findBySomething($id, "playground_id");
	}
	
	public static function findByPlaygroundIDAmount($id) {
		return static::findBySomethingAmount($id, "playground_id");
	} 
}
?>