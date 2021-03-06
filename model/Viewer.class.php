<?php
include_once "DBObject.class.php";

class Viewer extends DBObject {
	
	/* Fields */
	protected $userAgent;
	protected $timestamp;
	protected $os;
	protected $osCode;
	protected $browser;
	protected $browserCode;
	protected $device;
	
	/* Other configuration */
	const COLLECTION_NAME = "Viewers";

	/* *** Getter & Setter *** */

	public function getUserAgent() {
		return $this->userAgent;
	}
	
	public function getTimestamp() {
		return $this->timestamp;
	}
	
	public function getOs() {
		return $this->os;
	}
	
	public function getOsCode() {
		return $this->osCode;
	}

	public function getBrowser() {
		return $this->browser;
	}
	
	public function getBrowserCode() {
		return $this->browserCode;
	}
	
	public function getDevice() {
		return $this->device;
	}
	
	public function setUserAgent($value) {
		$this->userAgent = $value;
	}
	
	public function setTimestamp($value) {
		$this->timestamp = $value;
	}
	
	public function setOs($value) {
		$this->os = $value;
	}

	public function setOsCode($value) {
		$this->osCode = $value;
	}
	
	public function setBrowser($value) {
		$this->browser = $value;
	}
	
	public function setBrowserCode($value) {
		$this->browserCode = $value;
	}
	
	public function setDevice($value) {
		$this->device = $value;
	}
	
	/* Virtual getters */
	
	public function getPrettyTimestamp() {
		$dt = new DateTime($this->getTimestamp());
		return $dt->format("d/m/y G:i:s");
	}
	
	public function getSomething() {
		throw new Exception('Not implemented yet.');
	}

	/* ***** Overridden Methods ***** */

	public function upsert() {
		$fields = '"userAgent", "os", "osCode", "browser", "browserCode", "device"';
		$fieldsPDO = ":userAgent, :os, :osCode, :browser, :browserCode, :device";
		
		if($this->getId() == 0) {
			$sql = "INSERT INTO ".static::COLLECTION_NAME
					."($fields) VALUES ($fieldsPDO)";
		} else {
			$sql = "";
			throw new Exception('Not implemented yet.');
		}
		
		$query = DB::getDB()->prepare($sql);
		$data = $this->toArray(false);
		unset($data["timestamp"]);
		$query->execute($data);
		
		// get ID from DB and set it
		$this->setId(DB::getDB()->lastInsertId(static::COLLECTION_NAME."_id_seq"));
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