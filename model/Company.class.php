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
		$sql = "SELECT extract(epoch from age(min(\"startDate\")))/60/60/-24 FROM strikes WHERE \"companyId\" = ".$this->getId();
		$query = DB::getDB()->query($sql);
		$query->setFetchMode(PDO::FETCH_COLUMN, 0);
 		return $query->fetch();
	}

	/* ***** Static Methods ***** */

	public static function getRegions() {
		$arr = static::getListByColumn("region");
		return array_values(array_diff($arr, ["all", "-"]));
	}

	static function findByRegion($region) { //Find companies by region and order like in "findAllAndOrder"
		$sql = 'SELECT companies.* FROM strikes RIGHT JOIN companies ON "companyId"=companies.id WHERE companies.region = :region OR companies.region = \'all\' GROUP BY companies.id ORDER BY age(min("startDate"))*-1, count(strikes) DESC';
		$options["region"] = $region;
		$query = DB::getDB()->prepare($sql);
		$query->execute($options);
		$query->setFetchMode(PDO::FETCH_CLASS, get_class(new static()));
		return $query->fetchAll();
	}

	static function findAllAndOrder() {
		$sql = 'SELECT companies.* FROM strikes RIGHT JOIN companies ON "companyId"=companies.id WHERE companies.region NOT LIKE \'-\' GROUP BY companies.id ORDER BY age(min("startDate"))*-1, count(strikes) DESC';
		$query = DB::getDB()->query($sql);
		$query->setFetchMode(PDO::FETCH_CLASS, get_class(new static()));
		return $query->fetchAll();
	}

	static function findAllByTimeToNextStrike($days) {
		$sql = 'SELECT companies.* FROM strikes RIGHT JOIN companies ON "companyId"=companies.id  WHERE companies.region NOT LIKE \'-\' GROUP BY companies.id HAVING extract(epoch from age(min("startDate")))/60/60/-24 < '.$days.' ORDER BY age(min("startDate"))*-1, count(strikes) DESC';
		$query = DB::getDB()->query($sql);
		$query->setFetchMode(PDO::FETCH_CLASS, get_class(new static()));
		return $query->fetchAll();
	}
}
?>

