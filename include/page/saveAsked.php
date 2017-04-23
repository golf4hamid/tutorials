<?php
	/* Here Goes The Area To Ask For a Tutorial */
require_once("../db/DB_login.php");
    if(isset($_REQUEST['f_name']) && isset($_REQUEST['email']) &&
        isset($_REQUEST['subject']) && isset($_REQUEST['message'])){

        $ip = getenv('HTTP_CLIENT_IP')?:
            getenv('HTTP_X_FORWARDED_FOR')?:
                getenv('HTTP_X_FORWARDED')?:
                    getenv('HTTP_FORWARDED_FOR')?:
                        getenv('HTTP_FORWARDED')?:
                            getenv('REMOTE_ADDR');
        $name = $_REQUEST['f_name'];
        $email = $_REQUEST['email'];
        $subject = $_REQUEST['subject'];
        $message = $_REQUEST['message'];
        try {
            $conn = new PDO("mysql:host=$db_host;dbname=$db_db", $db_user, $db_pass);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->beginTransaction();
            $stmt = $conn->prepare("SELECT * FROM active WHERE ip = :ip");
              $stmt->bindParam(':ip', $ip);
            $stmt->execute();
            while ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
              if(!isset($r)){
                $au_id = $rows['id'];
                $stmt = $conn->prepare("INSERT INTO request(type, details, au_id, status) VALUES(:type, :details, :au_id, 'Not Yeat')");
                $stmt->bindParam(':type', $subject);
                $stmt->bindParam(':details', $message);
                $stmt->bindParam(':au_id', $au_id);
                $stmt->execute();
                $conn->commit();
                echo json_encode($rows);
                die();
              }
            }
            $stmt = $conn->prepare("INSERT INTO active(name, email, ip) VALUES(:name, :email, :ip)");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':ip', $ip);
            $stmt->execute();
            $au_id = $conn->lastInsertId();
            $stmt = $conn->prepare("INSERT INTO request(type, details, au_id, status) VALUES(:type, :details, :au_id, 'Not Yeat')");
            $stmt->bindParam(':type', $subject);
            $stmt->bindParam(':details', $message);
            $stmt->bindParam(':au_id', $au_id);
            $stmt->execute();
            $conn->commit();
            echo "Successfuly Done!";
        }
        catch(PDOException $e)
        {
            $conn->rollBack();
            echo "Connection failed: " . $e->getMessage();
        }
    }
?>
