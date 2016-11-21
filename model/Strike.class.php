<?php
include_once "DBObject.class.php";

class Strike extends DBObject {
	
	/* Fields */
	protected $workersUnion;
	protected $startDate;
	protected $endDate;
	protected $region;
	protected $province;
	protected $description;
	protected $companyId;
	
	/* Other configuration */
	const COLLECTION_NAME = "Strikes";

	/* *** Getter & Setter *** */

	public function getWorkersUnion() {
		return $this->workersUnion;
	}
	
	public function getStartDate() {
		return $this->startDate;
	}
	
	public function getEndDate() {
		return $this->endDate;
	}
	
	public function getRegion() {
		return $this->region;
	}

	public function getProvince() {
		return $this->province;
	}
	
	public function getDescription() {
		return $this->description;
	}
	
	public function getCompanyId() {
		return $this->companyId;
	}
	
	public function setWorkersUnion($value) {
		$this->workersUnion = $value;
	}
	
	public function setStartDate($value) {
		$this->startDate = $value;
	}
	
	public function setEndDate($value) {
		$this->endDate = $value;
	}

	public function setRegion($value) {
		$this->region = $value;
	}
	
	public function setProvince($value) {
		$this->province = $value;
	}
	
	public function setDescription($value) {
		$this->description = $value;
	}
	
	public function setCompanyId($value) {
		$this->companyId = $value;
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