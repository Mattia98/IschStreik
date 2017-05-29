<?php
include_once "DBObject.class.php";

class PushSubscription extends DBObject {
	
	/* Fields */
	protected $url;
	protected $date;
	
	/* Other configuration */
	const COLLECTION_NAME = "push_subscriptions";

	/* *** Getter & Setter *** */

	public function getUrl() {
		return $this->url;
	}
	
	public function getDate() {
		return $this->date;
	}
	
	public function setUrl($value) {
		$this->url = $value;
	}
	
	public function setDate($value) {
		$this->date = $value;
	}
	
	/* Virtual getters */
	
	public function getPrettyDate() {
		$dt = new DateTime($this->getDate());
		return $dt->format("d/m/y");
	}
}
?>