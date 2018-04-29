<?php
/**
 * Created by PhpStorm.
 * User: Belal
 * Date: 04/02/17
 * Time: 7:51 PM
 */
class DbOperation
{
    private $conn;

    function __construct()
    {
        require_once dirname(__FILE__) . '/Config.php';
        require_once dirname(__FILE__) . '/DbConnect.php';
        // opening db connection
        $db = new DbConnect();
        $this->conn = $db->connect();
    }

    /*
     * This method is added
     * We are taking username and password
     * and then verifying it from the database
     * */

    public function userLogin($username, $pass)
    {
        $password = md5($pass);
        $stmt = $this->conn->prepare("SELECT id FROM users WHERE username = ? AND password = ?");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }

    /*
     * After the successful login we will call this method
     * this method will return the user data in an array
     * */

    public function getUserByUsername($username)
    {
        $stmt = $this->conn->prepare("SELECT id, username, email, phone FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($id, $uname, $email, $phone);
        $stmt->fetch();
        $user = array();
        $user['id'] = $id;
        $user['username'] = $uname;
        $user['email'] = $email;
        $user['phone'] = $phone;
        return $user;
    }

    public function getUser(){
        $stmt = $this->conn->prepare("SELECT id, username from user");
            //$stmt->bind_param("ssss", $library, $gym, $activitycenter, $id);
        $stmt->execute();
        $stmt->bind_result($id, $uname);
        $stmt->fetch_object();
        
        return $stmt;
    }


    public function createUser($username, $pass, $email, $name, $phone)
    {
        if (!$this->isUserExist($username, $email, $phone)) {
            $password = md5($pass);
            $stmt = $this->conn->prepare("INSERT INTO users (username, password, email, name, phone) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $username, $password, $email, $name, $phone);
            if ($stmt->execute()) {
                return USER_CREATED;
            } else {
                return USER_NOT_CREATED;
            }
        } else {
            return USER_ALREADY_EXIST;
        }
    }


    private function isUserExist($username, $email, $phone)
    {
        $stmt = $this->conn->prepare("SELECT id FROM users WHERE username = ? OR email = ? OR phone = ?");
        $stmt->bind_param("sss", $username, $email, $phone);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }

    public function createLocation($id, $library, $gym, $activitycenter)
    {
        if(!$this->isDataExist($id)){
            $stmt = $this->conn->prepare("INSERT INTO personlocation(person_id, library, gym, activitycenter) values('$id', '$library', '$gym', '$activitycenter')");
            ///$stmt->bind_param("ssss", $id, $library, $gym, $activitycenter);
            $result = $stmt->execute();
            
            if ($result) {
                return DATA_ADDED;
            } else {
                return DATA_NOT_ADDED;
            }
        
        } else {

            $stmt = $this->conn->prepare("UPDATE personlocation SET library = '$library', gym = '$gym', activitycenter = '$activitycenter' WHERE person_id = '$id'");
            //$stmt->bind_param("ssss", $library, $gym, $activitycenter, $id);
            $result = $stmt->execute();
            
            if ($result) {
                return DATA_CREATED;
            } else {
                return DATA_NOT_CREATED;
            }

        }
    }

    private function isDataExist($id)
    {
        $stmt = $this->conn->prepare("SELECT person_id FROM personlocation WHERE person_id = '$id'");
        //$stmt->bind_param("s", $id);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }

    public function getLocationById($username)
    {
        
        $stmt = $this->conn->prepare("SELECT personlocation.person_id, personlocation.library, personlocation.gym, personlocation.activitycenter FROM users INNER JOIN personlocation ON users.id = personlocation.person_id WHERE users.username = '$username'");
        //$stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($id, $library, $gym, $activitycenter);
        $stmt->fetch();
        $user = array();
        $user['id'] = $id;
        $user['library'] = $library;
        $user['gym'] = $gym;
        $user['activitycenter'] = $activitycenter;
        return $user;
    }


}
?>