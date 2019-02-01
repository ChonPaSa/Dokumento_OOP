<?php

//######################################LABEL#################################################
class Label
{
	protected $ID;
	protected $name;
	
	public function __construct($ID = 0)
	{
		if($ID != 0)
		{
			$this->ID = $ID;
			$db = new Database();
			$data = $db->sqlSelect("SELECT name FROM labels WHERE labID = ?;",array($ID));
			$this->setName($data[0]["name"]);
		}
	}
	public function setID($ID)
	{
		$this->ID = $ID;
	}
	public function getID()
	{
		return $this->ID;
	}
	public function setName($name)
	{
		$this->name = $name;
	}
	public function getName()
	{
		return $this->name;
	}
	public function update($name)
	{
		$db = new Database();
		$parameters = array($name,$this->getID());
		$db->sqlUpdate("UPDATE labels SET name = ?	WHERE labID = ?", $parameters);
	}
	public function insert($name)
	{
		$db = new Database();
		$parameters = array($name);
		$insert_id = $db->sqlInsert("INSERT INTO labels (name) VALUES (?)", $parameters);
		$this->setID($insert_id);
	}
	public function delete($id)
	{
		$db = new Database();
		$parameters = array($id);
		$db->sqlDelete("DELETE FROM labels WHERE labID = ?", $parameters);
		$db->sqlDelete("DELETE FROM mapping_labels WHERE labID = ?", $parameters);
		
	}	
	public function findAll()
	{
		$db = new Database();
		$sql = "SELECT * FROM labels ORDER BY Name";
		$data = $db->sqlSelect($sql);
		$labels = array();
		foreach ($data as $key => $label)
		{
		    $labelObject = new Label($label["labID"]);
			array_push($labels, $labelObject);			
		}
		return $labels;
	}
	
}
//######################################CATEGORY#################################################
class Category
{
	protected $ID;
	protected $name;
		
	public function __construct($ID = 0)
	{
		if ($ID !=0)
		{
			$this->ID = $ID;
			$db = new Database();
			$data = $db->sqlSelect("SELECT name FROM categories WHERE catID = ?;",array($ID));
			$this->setName($data[0]["name"]);
		}
	}
	
	public function setID($ID)
	{
		$this->ID = $ID;
	}
	public function getID()
	{
		return $this->ID;
	}
	public function setName($name)
	{
		$this->name = $name;
	}
	public function getName()
	{
		return $this->name;
	}
	public function insert($name)
	{
		$db = new Database();
		$parameters = array($name);
		$insert_id = $db->sqlInsert("INSERT INTO categories (name) VALUES (?)", $parameters);
		$this->setID($insert_id);
	}	
	public function update($name)
	{
		$db = new Database();
		$parameters = array($name,$this->getID());
		$db->sqlUpdate("UPDATE categories SET name = ? WHERE catID = ?", $parameters);
	}
	public function delete($id)
	{
		$db = new Database();
		$parameters = array($id);
		$db->sqlDelete("DELETE FROM categories WHERE catID = ?", $parameters);
		$db->sqlUpdate("UPDATE documents SET category = 0 WHERE category = ?", $parameters);
	}
	public function findAll()
	{
		$db = new Database();
		$sql = "SELECT * FROM categories ORDER BY Name";
		$data = $db->sqlSelect($sql);
		$categories = array();
		foreach ($data as $key => $category)
		{
		    $categoryObject = new Category($category["catID"]);
			array_push($categories, $categoryObject);			
		}
		return $categories;
	}
}
//######################################DOCUMENT#################################################
class Document
{
	protected $ID;
	protected $name;
	protected $url;
	protected $timestamp;
	protected $location;
	protected $contact;
	public $category;
	protected $labels;

	public function __construct($attributes = array())
	{
		if (isset($attributes["docID"]))
		{
			$this->setID($attributes["docID"]);

		}
		if (isset($attributes["name"]))
		{
			$this->setName($attributes["name"]);
		}
		if (isset($attributes["url"]))
		{
			$this->setUrl($attributes["url"]);
		}
		if (isset($attributes["contact"]))
		{
			$this->setContact($attributes["contact"]);
		}
		if (isset($attributes["location"]))
		{
			$this->setLocation($attributes["location"]);
		}
		if (isset($attributes["timestamp"]))
		{
			$this->setTimestamp($attributes["timestamp"]);
		}
		if (isset($attributes["category"]))
		{
			$this->setCategory($attributes["category"]);
		}
		if (isset($attributes["labels"]))
		{
			$this->setLabels($attributes["labels"]);
		}
	}

	public function setID($ID)
	{
		$this->ID = $ID;
	}
	public function getID()
	{
		return $this->ID;
	}
	public function setName($name)
	{
		$this->name = $name;
	}
	public function getName()
	{
		return $this->name;
	}
	
	public function getUrl()
	{
		return $this->url;
	}
	public function setUrl($url)
	{
		$this->url = $url;
	}	
	public function setLocation($location)
	{
		$this->location = $location;
	}
	public function getLocation()
	{
		return $this->location;
	}
	
	public function setContact($contact)
	{
		$this->contact = $contact;
	}	
	
	public function getContact()
	{
		return $this->contact;
	}
	public function getTimestamp()
	{
		if (is_null($this->timestamp))
		{
			 $this->timestamp = date("Y-m-d");
		}
		return $this->timestamp;
	}
	
	public function setTimestamp($timestamp)
	{
		$this->timestamp = $timestamp;
	}	
	public function setCategory (Category $category)
	{
		$this->category = $category;
	}
	public function getCategory ()
	{
		if (!is_null($this->category))
		{
			return $this->category->getID();
		}
	}
	
	public function setLabels ($label = array())
	{
		$this->labels = $label;
	}
	
	public function getLabels()
	{
		return $this->labels;
	}
	
	public function insertDoc()
	{
		$db = new Database();
		if ($this->getCategory() != null)
		{
			$cat = $this->getCategory();
		}
		else
		{
			$cat = 0;
		}
		$parameters = array(
							$this->getName(),
							$this->getUrl(),
							$this->getContact(),
							$this->getLocation(),
							$this->getTimestamp(),
							$cat
							);
		$insert_id = $db->sqlInsert("INSERT INTO documents (name, url, contact, location, timestamp,category) values(?,?,?,?,?,?);", $parameters);
		$this->setID($insert_id);
	}
	public function updateDoc()
	{
		$db = new Database();
		if ($this->getCategory() != null)
		{
			$cat = $this->getCategory();
		}
		else
		{
			$cat = 0;
		}
		$parameters = array(
							$this->getName(),
							$this->getContact(),
							$this->getLocation(),
							$this->getTimestamp(),
							$cat,
							$this->getID()
							);
		 $db->sqlUpdate("UPDATE documents SET name = ?, 
									contact = ?, 
									location = ?, 
									timestamp = ?,
									category = ? 
									WHERE documents.docID = ?", $parameters);
	}

	public function deleteDoc()
	{
		$db = new Database();
		$parameters = array($this->getID());
		$db->sqlDelete("DELETE FROM documents WHERE docID = ?", $parameters);
		$db->sqlDelete("DELETE FROM mapping_labels WHERE docID = ?", $parameters);
	}
	
	
	public function linkLabel()
	{
		$db = new Database();
		$parameters[0] = $this->getID();
		$db->sqlDelete("DELETE FROM mapping_labels WHERE docID = ?", $parameters);
		if (isset($this->labels))
		{
			for($i=0; $i< count($this->labels); $i++)
				{
					$parameters[1] = $this->labels[$i]->getID();
					$insert_id = $db->sqlInsert("INSERT INTO mapping_labels (docID, labID) values(?,?);", $parameters);
				}
		}
	}
	
	public function find($doc)
	{
		$db = new Database();
		$sql = "SELECT * FROM documents WHERE docID = ".$doc->getID();
		$data = $db->sqlSelect($sql);
		$this->setID($doc->getID());
		$this->setName($data[0]["name"]);
		$this->setUrl($data[0]["url"]);
		$this->setContact($data[0]["contact"]);
		$this->setLocation($data[0]["location"]);
		$this->setTimestamp($data[0]["timestamp"]);
		
		$catObject = New Category($data[0]["category"]);
		$this->setCategory($catObject);
		$sqlLabels = "SELECT labID FROM mapping_labels 
						WHERE mapping_labels.docID = ".$this->getID();
		$labelsData = $db->sqlSelect($sqlLabels);
		$labels = array();
		foreach ($labelsData as $label)
		{
			$labelObject = new Label($label["labID"]);
			array_push($labels, $labelObject);
		}
		$this->setLabels($labels);
		return $this;
	}

	public function findUrl($doc)
	{
		$db = new Database();
		$sql = "SELECT url FROM documents WHERE docID = ".$doc->getID();
		$data = $db->sqlSelect($sql);
		$this->setUrl($data[0]["url"]);
		return $this;
	}
	
   public function findAll()
	{
		//create array of document objects
		$db = new Database();
		$sql = "SELECT * FROM documents";
		$data = $db->sqlSelect($sql);
		$docs = array();
		foreach ($data as $doc)
		{
			$sqlLabels = "SELECT labID FROM mapping_labels 
							WHERE mapping_labels.docID = ".$doc["docID"];
			$labelsData = $db->sqlSelect($sqlLabels);
			$labels = array();
			foreach ($labelsData as $label)
			{
				$labelObject = new Label($label["labID"]);
				array_push($labels, $labelObject);
			}
			$catObject = New Category($doc["category"]);
			$docObject = New Document($doc["name"], $doc["url"], 
									$doc["contact"], $doc["location"],
									$catObject, $labels);
			$docObject->setID($doc["docID"]);
			$docObject->setTimestamp($doc["timestamp"]);
			array_push($docs,$docObject);
		}
		return $docs;
	} 

}


//######################################USER#################################################
class User
{
	protected $ID;
	protected $name;
	protected $familyName;
	protected $email;
	protected $password;
	protected $userName;
	
	public function __construct($attributes = array())
	{
		if (isset($attributes["ID"]))
		{
			$this->setID($attributes["ID"]);
		}
		if (isset($attributes["name"]))
		{
			$this->setName($attributes["name"]);
		}
		if (isset($attributes["familyName"]))
		{
			$this->setFamilyName($attributes["familyName"]);
		}
		if (isset($attributes["email"]))
		{
			$this->setEmail($attributes["email"]);
		}
		if (isset($attributes["userName"]))
		{
			$this->setUserName($attributes["userName"]);
		}
		if (isset($attributes["password"]))
		{
			$this->setPassword($attributes["password"]);
		}
	}
	
	public function setID($ID)
	{
		$this->ID = $ID;
	}
	public function getID()
	{
		return $this->ID;
	}
	
	public function setName($name)
	{
		$this->name = $name;
	}
	public function getName()
	{
		return $this->name;
	}
	
	public function setFamilyName($familyName)
	{
		$this->familyName = $familyName;
	}
	public function getFamilyName()
	{
		return $this->familyName;
	}
	
	public function setUserName($userName)
	{
		$this->userName = $userName;
	}
	public function getUserName()
	{
		return $this->userName;
	}
	
	public function setEmail($email)
	{
		$this->email = $email;
	}
	public function getEmail()
	{
		return $this->email;
	}
	
	public function setPassword($password)
	{
		$this->password = $password;
	}
	public function getPassword()
	{
		return $this->password;
	}
}
?>