<?php
include_once "DBObject.class.php";

class Company extends DBObject {
	
	/* Fields */
	protected $name;
	protected $nameCode;
	protected $website;
	protected $region;
	protected $province;
	protected $guaranteedRoutesUrl;
	
	/* Other configuration */
	const COLLECTION_NAME = "Companies";

	/* *** Getter & Setter *** */

	public function getName() {
		return $this->name;
	}
	
	public function getNameCode() {
		return $this->nameCode;
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
	
	public function getGuaranteedRoutesUrl() {
		return $this->guaranteedRoutesUrl;
	}

	public function setName($value) {
		$this->name = $value;
	}

	public function setNameCode($value) {
		$this->nameCode = $value;
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
	
	public function setGuaranteedRoutesUrl($value) {
		$this->guaranteedRoutesUrl = $value;
	}

	/* Virtual getters */
	
	public function getTimeToNextStrike() {
		$sql = "SELECT age(min(\"startDate\")) FROM strikes WHERE \"companyId\" = ".$this->getId();
		$query = DB::getDB()->query($sql);
		$query->setFetchMode(PDO::FETCH_COLUMN, 0);
 		return $query->fetch();
	}

	/* ***** Static Methods ***** */

	public static function getRegions() {
		$arr = static::getListByColumn("region");
		return array_values(array_diff($arr, ["all"]));
	}

	/*public static function findByRegion($region) {
		return static::findBySomething($region, "region");
	}
	Old code. Need custom query for including companies with region "all"
	*/

	static function findByRegion($region) {
		$sql = "SELECT * FROM ".static::COLLECTION_NAME." WHERE region = :region OR region = 'all'";
		$options["region"] = $region;
		$query = DB::getDB()->prepare($sql);
		$query->execute($options);
		$query->setFetchMode(PDO::FETCH_CLASS, get_class(new static()));
		return $query->fetchAll();
	}
}
?>