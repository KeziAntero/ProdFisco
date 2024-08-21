<?php

class Prod
{
    private $host  = 'localhost';
    private $user  = 'root';
    private $password   = "";
    private $database  = "prod";
    private $prodUserTable = 'prod_user';
    private $prodOrderTable = 'prod_order';
    private $prodOrderItemTable = 'prod_order_item';
    private $serviceTypeTable = 'service_type';
    private $dbConnect = false;

    public function __construct()
    {
        if (!$this->dbConnect) {
            $conn = new mysqli($this->host, $this->user, $this->password, $this->database);
            if ($conn->connect_error) {
                die("Error failed to connect to MySQL: " . $conn->connect_error);
            } else {
                $this->dbConnect = $conn;
            }
        }
    }

    private function getData($sqlQuery)
    {
        $result = mysqli_query($this->dbConnect, $sqlQuery);
        if (!$result) {
            die('Error in query: ' . mysqli_error($this->dbConnect));
        }
        $data = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }

    public function getFiscais()
    {
        $sqlQuery = "SELECT nome, matricula FROM fiscais";
        return $this->getData($sqlQuery);
    }

    public function getServiceTypes()
    {
        $sqlQuery = "SELECT service_id, service_name, service_value FROM " . $this->serviceTypeTable;
        return $this->getData($sqlQuery);
    }

    public function loginUsers($email, $password)
    {
        $sqlQuery = "
            SELECT id, email, first_name
            FROM " . $this->prodUserTable . " 
            WHERE email='" . $email . "' AND password='" . $password . "'";
        return $this->getData($sqlQuery);
    }

    public function checkLoggedIn()
    {
        if (!$_SESSION['userid']) {
            header("Location:index.php");
        }
    }

    public function saveProd($POST)
    {
        $sqlInsert = "INSERT INTO " . $this->prodOrderTable . "(user_id, order_receiver_name, order_receiver_matricula, order_total_before_tax, order_total_tax, order_tax_per, order_total_after_tax, order_amount_paid, order_total_amount_due, note) VALUES ('" . $POST['userId'] . "', '" . $POST['fiscal'] . "', '" . $POST['matricula'] . "', '" . $POST['subTotal'] . "', '" . $POST['taxAmount'] . "', '" . $POST['taxRate'] . "', '" . $POST['totalAftertax'] . "', '" . $POST['amountPaid'] . "', '" . $POST['amountDue'] . "', '" . $POST['notes'] . "')";
        mysqli_query($this->dbConnect, $sqlInsert);
        $lastInsertId = mysqli_insert_id($this->dbConnect);
        for ($i = 0; $i < count($POST['productCode']); $i++) {
            $sqlInsertItem = "INSERT INTO " . $this->prodOrderItemTable . "(order_id, item_code, item_name, order_item_quantity, order_item_qtdfiscal, order_item_price, order_item_final_amount) VALUES ('" . $lastInsertId . "', '" . $POST['productCode'][$i] . "', '" . $POST['serviceName'][$i] . "', '".$POST['quantity'][$i]."', '" . $POST['qtdfiscal'][$i] . "', '" . $POST['price'][$i] . "', '" . $POST['total'][$i] . "')";
            mysqli_query($this->dbConnect, $sqlInsertItem);
        }
    }

    public function updateProd($POST)
    {
        if ($POST['prodId']) {
            $sqlInsert = "UPDATE " . $this->prodOrderTable . " 
                SET order_receiver_name = '" . $POST['fiscal'] . "', order_receiver_matricula= '" . $POST['matricula'] . "', order_total_before_tax = '" . $POST['subTotal'] . "', order_total_tax = '" . $POST['taxAmount'] . "', order_tax_per = '" . $POST['taxRate'] . "', order_total_after_tax = '" . $POST['totalAftertax'] . "', order_amount_paid = '" . $POST['amountPaid'] . "', order_total_amount_due = '" . $POST['amountDue'] . "', note = '" . $POST['notes'] . "' 
                WHERE user_id = '" . $POST['userId'] . "' AND order_id = '" . $POST['prodId'] . "'";
            mysqli_query($this->dbConnect, $sqlInsert);
        }
        $this->deleteProdItems($POST['prodId']);
        for ($i = 0; $i < count($POST['productCode']); $i++) {
            $sqlInsertItem = "INSERT INTO " . $this->prodOrderItemTable . "(order_id, item_code, item_name, order_item_quantity, order_item_qtdfiscal, order_item_price, order_item_final_amount) 
                VALUES ('" . $POST['prodId'] . "', '" . $POST['productCode'][$i] . "', '" . $POST['serviceName'][$i] . "', '".$POST['quantity'][$i]."', '" . $POST['qtdfiscal'][$i] . "', '" . $POST['price'][$i] . "', '" . $POST['total'][$i] . "')";
            mysqli_query($this->dbConnect, $sqlInsertItem);
        }
    }

    public function getProdList()
    {
        $sqlQuery = "SELECT * FROM " . $this->prodOrderTable . " 
            WHERE user_id = '" . $_SESSION['userid'] . "'";
        return $this->getData($sqlQuery);
    }

    public function getProd($prodId)
    {
        $sqlQuery = "SELECT * FROM " . $this->prodOrderTable . " 
            WHERE user_id = '" . $_SESSION['userid'] . "' AND order_id = '$prodId'";
        $result = mysqli_query($this->dbConnect, $sqlQuery);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        return $row;
    }

    public function getProdItems($prodId)
    {
        $sqlQuery = "SELECT * FROM " . $this->prodOrderItemTable . " 
            WHERE order_id = '$prodId'";
        return $this->getData($sqlQuery);
    }

    public function deleteProdItems($prodId)
    {
        $sqlQuery = "DELETE FROM " . $this->prodOrderItemTable . " 
            WHERE order_id = '" . $prodId . "'";
        mysqli_query($this->dbConnect, $sqlQuery);
    }

    public function deleteProd($prodId)
    {
        $sqlQuery = "DELETE FROM " . $this->prodOrderTable . " 
            WHERE order_id = '" . $prodId . "'";
        mysqli_query($this->dbConnect, $sqlQuery);
        $this->deleteProdItems($prodId);
        return 1;
    }
}
