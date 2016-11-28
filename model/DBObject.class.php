<?php
	include_once "DB.class.php";
	
abstract class DBObject {
	
	/* === Fields === */
	protected $id = 0;
	
	/* === Collection (a.k.a. table) name === */
	const COLLECTION_NAME = "generic";

	public function __construct($data = array()) {
		// if $data is not empty, call the respective setter
		if ($data) {
			foreach ($data as $key => $value) {
				$setterName = 'set' . ucfirst($key);
				// if Argument is invalid, ignore it
				if (method_exists($this, $setterName)) {
					$this->$setterName($value);
				}
			}
		}
	}

	public function  __toString() {
		return "Not implemented yet.";
	}

	/* === Getter & Setter === */

	public function getId() {
		return $this->id;
	}
	
	public function setId($value) {
		$this->id = intval($value);
	}

	/* === Virtual getters === */
        
	public function toArray($withID = true) {
		$attribute = get_object_vars($this);
		if ($withID === false) {
			// if $withID is false, remove primary key
			unset($attribute['id']);
		}
		/*$attribute["collection"] = static::COLLECTION_NAME;
		$attribute["_id"] = $this->getId();*/
		return $attribute;
	}
	
	/* === Persistence-Methods === */

	public function upsert() {
		$fields = "";
		$fieldsPDO = "";
		$farray = $this->toArray(false);
		foreach($farray as $key => $val) {
			$fields .= ", ";
			$fields .= $key;
		}
		foreach($farray as $key => $val) {
			$fieldsPDO .= ", :";
			$fieldsPDO .= $key;
		}
		$fields = substr($fields, 1);
		$fieldsPDO = substr($fieldsPDO, 2);
		
		if($this->getId() == 0) {
			$sql = "INSERT INTO ".static::COLLECTION_NAME
					."VALUES (default, $fields)";
			$sql = "INSERT INTO ".static::COLLECTION_NAME
					."($fields) VALUES ($fieldsPDO)";
		} else {
			$sql = "";
			throw new Exception('Not implemented yet.');
		}
		
		$query = DB::getDB()->prepare($sql);
		$query->execute($this->toArray(false));
		
		// get ID from DB and set it
		$this->setId(DB::getDB()->lastInsertId(static::COLLECTION_NAME."_id_seq"));
	}

	public function delete() {
		throw new Exception('Not implemented yet.');
		$bucket = DB::getDB();
		var_dump(static::COLLECTION_NAME.":".$this->getId());
		$result = $bucket->remove(static::COLLECTION_NAME.":".$this->getId());
		var_dump($result);
		// Object does not exist in the DB anymore: resetting the ID
		$this->id = 0;
		if (!$id){
			return false;
		}
		return $result;
	}

	/* === Static Methods === */

	public static function find($id) {
		$sql = "SELECT * FROM ".static::COLLECTION_NAME." WHERE id=?";
		$query = DB::getDB()->prepare($sql);
		$query->execute(array($id));
		$query->setFetchMode(PDO::FETCH_CLASS, get_class(new static()));
		return $query->fetch();
	}

	public static function findAll() {
		$sql = "SELECT * FROM ".static::COLLECTION_NAME." ORDER BY id";
		$query = DB::getDB()->query($sql);
		$query->setFetchMode(PDO::FETCH_CLASS, get_class(new static()));
		return $query->fetchAll();
	}
	
	public static function getAmount() {
		$sql = "SELECT count(*) FROM ".static::COLLECTION_NAME;
		$query = DB::getDB()->query($sql);
      $query->setFetchMode(PDO::FETCH_COLUMN, 0);
      return $query->fetch();
	}

	static function findBySomething($something, $fieldName) {
		$sql = "SELECT * FROM ".static::COLLECTION_NAME." WHERE \"$fieldName\" = :something";
		$options["something"] = $something;
		$query = DB::getDB()->prepare($sql);
		$query->execute($options);
		$query->setFetchMode(PDO::FETCH_CLASS, get_class(new static()));
		return $query->fetchAll();
	}
	
	static function findBySomethingAmount($something, $fieldName) {
		$sql = "SELECT count(*) FROM ".static::COLLECTION_NAME." WHERE \"$fieldName\" = :something";
		$options["something"] = $something;
		$query = DB::getDB()->prepare($sql);
		$query->execute($options);
		$query->setFetchMode(PDO::FETCH_COLUMN, 0);
		return $query->fetch();
	}
	
	public static function getStats($field) {
		$sql = "SELECT $field AS value, COUNT(*) AS amount FROM ".static::COLLECTION_NAME."
				  --WHERE Date >= DATE_SUB(now(), INTERVAL 14 DAY)
				  WHERE $field <> ''
				  --AND IsBot = 0 
				  GROUP BY $field";
		$query = DB::getDB()->prepare($sql);
		$query->execute();
		$query->setFetchMode(PDO::FETCH_ASSOC);
		return $query->fetchAll();
	}
	
	/* === Pagination === */
	public static function findByPage($recordsPerPage, $page) {
		$sql = "SELECT * FROM ".static::COLLECTION_NAME
				." ORDER BY id limit :limit offset :offset";
		$query = DB::getDB()->prepare($sql);
		$options['limit'] = $recordsPerPage;		
		$options['offset'] = $recordsPerPage*($page-1);	
		$query->execute($options);
		$query->setFetchMode(PDO::FETCH_CLASS, get_class(new static()));
		return $query->fetchAll();
	}
	
	public static function findByPageAndField($recordsPerPage, $page, $field, $searchterm, $action) {
		$field = str_replace([";", "'", '"', "´", "`"], "", $field);
		//var_dump($field);
		
		$options['limit'] = $recordsPerPage;
		$options['offset'] = $recordsPerPage*($page-1);
		
		switch($action) {
			case 1:
				$options['searchterm'] = $searchterm;
				$comparator = "=";
				break;
			case 2:
				$options['searchterm'] = '%'.$searchterm.'%';
				$comparator = "LIKE";
				break;
			case 3:
				$options['searchterm'] = '%'.$searchterm.'%';
				$comparator = "NOT LIKE";
				break;
			default:
				return false;
		}
		$sql = "SELECT * FROM ".static::COLLECTION_NAME." WHERE lower(cast ($field as text)) $comparator lower(:searchterm) ORDER BY id limit :limit offset :offset";
		$query = DB::getDB()->prepare($sql);
		$query->execute($options);
		$query->setFetchMode(PDO::FETCH_CLASS, get_class(new static()));
		return $query->fetchAll();
	}
	
	public static function getAmountForField($field, $searchterm, $action) {
		//$field = addslashes(str_replace(";", "", $field));
		$field = str_replace([";", "'", '"', "´", "`"], "", $field);

		switch($action) {
			case 1:
				$options['searchterm'] = $searchterm;
				$comparator = "=";
				break;
			case 2:
				$options['searchterm'] = '%'.$searchterm.'%';
				$comparator = "LIKE";
				break;
			case 3:
				$options['searchterm'] = '%'.$searchterm.'%';
				$comparator = "NOT LIKE";
				break;
			default:
				return false;
		}
		$sql = "SELECT count(*) FROM ".static::COLLECTION_NAME." WHERE lower(cast ($field as text)) $comparator lower(:searchterm)";
		$query = DB::getDB()->prepare($sql);
		$query->execute($options);
		$query->setFetchMode(PDO::FETCH_COLUMN, 0);
		return $query->fetch();
		
	}
}
?>