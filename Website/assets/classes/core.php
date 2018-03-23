<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'database.php';

class CORE
{

	private $conn;

	public function __construct()
	{
		$database = new Database();
		$db = $database->dbConnection();
		$this->conn = $db;
  }

	public function runQuery($sql)
	{
		$stmt = $this->conn->prepare($sql);
		return $stmt;
	}

	public function lastID()
	{
		$stmt = $this->conn->lastInsertId();
		return $stmt;
	}

	public function isIngelogd()
	{
		if(isset($_SESSION['userSession']))
		{
			$stmt = $this->conn->prepare("SELECT * FROM gebruikers WHERE id=:id");
			$stmt->execute(array(":id"=>$_SESSION['userSession']));
			$userRow = $stmt->fetch(PDO::FETCH_ASSOC);
			if ($stmt->rowCount() == 1) {
				return true;
			} else {
				$this->loguit();
				return false;
			}
		} else {
			return false;
		}
	}

	public function redirect($url)
	{
		header("Location: $url");
	}

	public function logout()
	{
		session_unset();
		session_destroy();
		$_SESSION['userSession'] = false;
  }
  
  public function register($email, $firstname, $lastname, $password, $phoneNumber, $city, $zipcode, $street, $houseNumber) 
  {
		try {
			$stmt = $this->conn->prepare("INSERT INTO users (email, firstname, lastname, password, phoneNumber, city, zipcode, street, houseNumber) VALUES(:email, :firstname, :lastname, :password, :phoneNumber, :city, :zipcode, :street, :houseNumber);");
			$stmt->bindparam(":email",$email);
			$stmt->bindparam(":firstname",$firstname);
			$stmt->bindparam(":lastname",$lastname);
			$stmt->bindparam(":password",$password);
			$stmt->bindparam(":phoneNumber",$phoneNumber);
			$stmt->bindparam(":city",$city);
			$stmt->bindparam(":zipcode",$zipcode);
			$stmt->bindparam(":street",$street);
			$stmt->bindparam(":houseNumber",$houseNumberme);
			$stmt->execute();

			$_SESSION['userSession'] = $this->lastID();

			return true;
		} catch (PDOException $ex) {
			return $ex->getMessage();
		}
  }

	public function login($email, $password)
	{
		$stmt = $this->conn->prepare("SELECT id FROM customers WHERE email=:email AND password=:password;");
		$stmt->bindparam(":email",$email);
		$stmt->bindparam(":password",$password);
		$stmt->execute();
		$PS = $stmt->fetchAll(PDO::FETCH_ASSOC);
		if ($stmt->rowCount() != 1) {
			return false;
		} else {
      $_SESSION['userSession'] = $PS[0]["id"];
			return true;
		}
	}

	public function getBikeInfo($id) {
		$stmt = $this->conn->prepare("SELECT * FROM products WHERE id=:id");
		$stmt->execute(array(":id"=>$id));
		$PS = $stmt->fetchAll(PDO::FETCH_ASSOC);
		if ($stmt->rowCount() == 0) {
			return false;
		} else {
			return $PS;
		}
	}

	public function getBikes($order = 1) {
    switch($order) {
      case 1:
        $orderBy = "name ASC";
        break;
      case 2:
        $orderBy = "name DESC";
        break;
      case 3:
        $orderBy = "price ASC";
        break;
      case 4:
        $orderBy = "price DESC";
        break;
      case 5:
        $orderBy = "modelYear ASC, name ASC";
        break;
      case 6:
        $orderBy = "modelYear DESC, name ASC";
        break;
      default:
        $orderBy = "name ASC";
        break;
    }
		$stmt = $this->conn->prepare("SELECT id, name, brand, colors, imagePath, model, price, actionPrice, IF(actionPrice IS NULL, false, true) as isAction FROM products ORDER BY ".$orderBy);
		$stmt->execute();
		$PS = $stmt->fetchAll(PDO::FETCH_ASSOC);
		if ($stmt->rowCount() == 0) {
			return false;
		} else {
			return $PS;
		}
	}
}

?>
