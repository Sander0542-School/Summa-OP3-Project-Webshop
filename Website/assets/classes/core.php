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

	public function isLoggedIn()
	{
		if(isset($_SESSION['userSession']))
		{
			$stmt = $this->conn->prepare("SELECT * FROM customers WHERE id=:id");
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
			$stmt = $this->conn->prepare("INSERT INTO customers (email, firstname, lastname, password, phoneNumber, city, zipcode, street, houseNumber) VALUES (:email, :firstname, :lastname, :password, :phoneNumber, :city, :zipcode, :street, :houseNumber);");
			$stmt->bindparam(":email",$email);
			$stmt->bindparam(":firstname",$firstname);
			$stmt->bindparam(":lastname",$lastname);
			$stmt->bindparam(":password",$password);
			$stmt->bindparam(":phoneNumber",$phoneNumber);
			$stmt->bindparam(":city",$city);
			$stmt->bindparam(":zipcode",$zipcode);
			$stmt->bindparam(":street",$street);
			$stmt->bindparam(":houseNumber",$houseNumber);
			$stmt->execute();

			$_SESSION['userSession'] = $this->lastID();

			return true;
		} catch (PDOException $ex) {
			return false;
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
		$stmt = $this->conn->prepare("SELECT *, IF(actionPrice IS NULL, false, true) as isAction FROM products WHERE id=:id");
		$stmt->execute(array(":id"=>$id));
		$PS = $stmt->fetchAll(PDO::FETCH_ASSOC);
		if ($stmt->rowCount() == 0) {
			return false;
		} else {
			return $PS[0];
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

	public function newReperation($name, $email, $subject, $message) {
		try {
			$stmt = $this->conn->prepare("INSERT INTO reperations (name, email, subject, message) VALUES (:name, :email, :subject, :message);");
			$stmt->bindparam(":name",$name);
			$stmt->bindparam(":email",$email);
			$stmt->bindparam(":subject",$subject);
			$stmt->bindparam(":message",$message);
			$stmt->execute();

			return true;
		} catch (PDOException $ex) {
			return false;
		}
	}

	public function updateShoppingCart($customerID, $productID) {
		try {
			$stmt = $this->conn->prepare("INSERT INTO shoppingcart (customerID, productID) VALUES (:customerID, :productID) ON DUPLICATE KEY UPDATE quantity = quantity + 1;");
			$stmt->bindparam(":customerID",$customerID);
			$stmt->bindparam(":productID",$productID);
			$stmt->execute();

			return true;
		} catch (PDOException $ex) {
			return false;
		}
	}

	public function orderShoppingCart() {
		try {
			$shoppingCart = $this->getShoppingCart();
			if ($shoppingCart) {
				$stmt = $this->conn->prepare("INSERT INTO orders (customerID) VALUES (:customerID)");
				$stmt->execute(array(":customerID"=>$_SESSION['userSession']));

				$orderID = $this->lastID();

				foreach ($shoppingCart as $bike) {
					$stmt = $this->conn->prepare("INSERT INTO orderdetails (orderID, productID, quantity, priceEach) VALUES (:orderID, :productID, :quantity, :priceEach)");
					$stmt->bindparam(":orderID",$orderID);
					$stmt->bindparam(":productID",$bike["productID"]);
					$stmt->bindparam(":quantity",$bike["quantity"]);
					if ($bike["isAction"]) {
						$stmt->bindparam(":priceEach",$bike["actionPrice"]);
					} else {
						$stmt->bindparam(":priceEach",$bike["price"]);
					}
					$stmt->execute();
				}
	
				return true;
			}
		} catch (PDOException $ex) {
			return false;
		}
	}

	public function getShoppingCart() {
		$stmt = $this->conn->prepare("SELECT shoppingcart.*, products.id as productID products.name, products.brand, products.price, products.actionPrice, products.description, products.colors, products.imagePath, products.model, products.modelYear, IF(actionPrice IS NULL, false, true) as isAction FROM shoppingcart INNER JOIN products ON shoppingcart.productID = products.id WHERE customerID=:customerID");
		$stmt->execute(array(":customerID"=>$_SESSION['userSession']));
		$PS = $stmt->fetchAll(PDO::FETCH_ASSOC);
		if ($stmt->rowCount() == 0) {
			return false;
		} else {
			return $PS;
		}
	}

	public function emptyShoppingCart() {
		$stmt = $this->conn->prepare("DELETE FROM shoppingcart WHERE customerID=:customerID");
		$stmt->execute(array(":customerID"=>$_SESSION['userSession']));
	}

	public function deleteItemFromShoppingCart($cartID) {
		try {
			$stmt = $this->conn->prepare("DELETE FROM shoppingcart WHERE customerID=:customerID AND id=:cartID");
			$stmt->bindparam(":customerID",$_SESSION['userSession']);
			$stmt->bindparam(":cartID",$cartID);
			$stmt->execute();

			return true;
		} catch (PDOException $ex) {
			return false;
		}
	}

	public function updateCustomerInfo($email, $firstname, $lastname, $phoneNumber, $city, $zipcode, $street, $houseNumber) {
		try {
			$stmt = $this->conn->prepare("UPDATE customers SET email=:email, firstname=:firstname, lastname=:lastname, phoneNumber=:phoneNumber, city=:city, zipcode=:zipcode, street=:street, houseNumber=:houseNumber WHERE id=:customerID;");
			$stmt->bindparam(":customerID",$_SESSION['userSession']);
			$stmt->bindparam(":email",$email);
			$stmt->bindparam(":firstname",$firstname);
			$stmt->bindparam(":lastname",$lastname);
			$stmt->bindparam(":phoneNumber",$phoneNumber);
			$stmt->bindparam(":city",$city);
			$stmt->bindparam(":zipcode",$zipcode);
			$stmt->bindparam(":street",$street);
			$stmt->bindparam(":houseNumber",$houseNumber);
			$stmt->execute();

			return true;
		} catch (PDOException $ex) {
			return false;
		}
	}

	public function getOrders() {
		$stmt = $this->conn->prepare("SELECT orderdetails.orderID, SUM(orderdetails.priceEach * orderdetails.quantity) as totalPrice, SUM(orderdetails.quantity) as totalBikes, orders.orderDate FROM orderdetails INNER JOIN orders ON orderdetails.orderID = orders.id WHERE customerID=:customerID GROUP BY orderdetails.orderID");
		$stmt->execute(array(":customerID"=>$_SESSION['userSession']));
		$PS = $stmt->fetchAll(PDO::FETCH_ASSOC);
		if ($stmt->rowCount() == 0) {
			return false;
		} else {
			return $PS;
		}
	}

	public function getOrderInfo($orderID) {
		$stmt = $this->conn->prepare("SELECT orderdetails.id, orderdetails.orderID, orders.customerID, orders.orderDate, orderdetails.productID, orderdetails.quantity, orderdetails.priceEach, products.name, products.brand, products.imagePath, customers.firstname, customers.lastname, customers.zipcode, customers.city, customers.phoneNumber, customers.street, customers.houseNumber, SUM(orderdetails.priceEach * orderdetails.quantity) as totalPrice, SUM(orderdetails.quantity) as totalBikes FROM orders INNER JOIN orderdetails ON orders.id = orderdetails.orderID INNER JOIN products ON orderdetails.productID = products.id INNER JOIN customers ON orders.customerID = customers.id WHERE orders.customerID = :customerID AND orders.id = :orderID GROUP BY orderdetails.id;");
		$stmt->bindparam(":customerID",$_SESSION['userSession']);
		$stmt->bindparam(":orderID",$orderID);
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
