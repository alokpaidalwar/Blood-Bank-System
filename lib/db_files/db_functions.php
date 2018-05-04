<?php
date_default_timezone_set('Asia/Kolkata');
error_reporting(E_ALL);
ini_set('display_errors', 1);

class db {
        private $conn;
        private $host;
        private $user;
        private $password;
        private $baseName;
        private $port;
        private $Debug;
    
     /** constructor to initialize vairables **/ 
    function __construct($params=array()) {
        $this->conn = false;
        $this->host = 'localhost'; //hostname
        $this->user = 'root'; //username
        $this->password = '1432'; //password
        $this->baseName ='bloodbank'; //name of your database
        $this->port = '3306';
        $this->debug = true;
        $this->connect();
    }
 
     /** destructor to disconnect **/ 
    function __destruct() {
        $this->disconnect();
    }
    
     /** connect to database **/
    function connect() {
        if (!$this->conn) {
            try {
                $this->conn = new PDO('mysql:host='.$this->host.';dbname='.$this->baseName.'', $this->user, $this->password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));  
            }
            catch (Exception $e) {
                die('Erreur : ' . $e->getMessage());
            }
 
            if (!$this->conn) {
                $this->status_fatal = true;
                echo 'Connection BDD failed';
                die();
            } 
            else {
                $this->status_fatal = false;
            }
        }
        return $this->conn;
    }
 
    /** disconnect the connection with database **/ 
    function disconnect() {
        if ($this->conn) {
            $this->conn = null;
        }
    }
    
     /** to execute Select query to get one values **/
    function getOne($query) {
        $result = $this->conn->prepare($query);
        $ret = $result->execute();
        if (!$ret) {
           echo 'PDO::errorInfo():';
           echo '<br />';
           echo 'error SQL: '.$query;
           die();
        }
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $reponse = $result->fetch();
        
        return $reponse;
    }

    /** to execute Select query to get more than one values **/
    function getAll($query) {
        $result = $this->conn->prepare($query);
        $ret = $result->execute();
        if (!$ret) {
           echo 'PDO::errorInfo():';
           echo '<br />';
           echo 'error SQL: '.$query;
           die();
        }
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $reponse = $result->fetchAll();
        
        return $reponse;
    }
    
    /** to execute any query other than SELECT**/
    function execute($query) {
        $response = $this->conn->exec($query);
        
        return $response;
    }

    /** Check Login values **/
    function check($value){
        $value = trim($value);
        if (get_magic_quotes_gpc()) {
            $value = stripslashes($value);
        }
        $value = strtr($value,array_flip(get_html_translation_table(HTML_ENTITIES)));
        $value = strip_tags($value);
        $value = htmlspecialchars ($value);
        return $value;
    } 

    /** Encrypting password @param password, returns salt and encrypted password **/
    function hashSSHA($password) {
        $salt = sha1(rand());
        $salt = substr($salt, 0, 10);
        $encrypted = base64_encode(sha1($password . $salt, true) . $salt);
        $hash = array("salt" => $salt, "encrypted" => $encrypted);
        return $hash;
    }   

    /** Decrypting password @param salt, password returns hash string **/
    function checkhashSSHA($salt, $password) {
        $hash = base64_encode(sha1($password . $salt, true) . $salt);
        return $hash;
    }

    /** Validate User Login details for hospital**/
    function validateHospital($username,$password){
        // checking for injection
        $username=$this->check($username);
        $query=$this->getOne("SELECT * FROM hospitals_info WHERE username='$username'");
        // verifying user password
        $salt = $query['salt'];
        $encrypted_password = $query['password'];
        $hash = $this->checkhashSSHA($salt, $password);
        // check for password equality
        if ($encrypted_password == $hash) {
            // user authentication details are correct
            $_SESSION['username']=$username;
            $_SESSION['user_type']="hospital";
            return true;
        } else {
            // user authentication details are wrong
            return null;
        }
    }

    /** Validate User Login details for receiver**/
    function validateReceiver($username,$password){
        // checking for injection
        $username=$this->check($username);
        $query=$this->getOne("SELECT * FROM receivers_info WHERE username='$username'");
        // verifying user password
        $salt = $query['salt'];
        $encrypted_password = $query['password'];
        $hash = $this->checkhashSSHA($salt, $password);
        // check for password equality
        if ($encrypted_password == $hash) {
            // user authentication details are correct
            $_SESSION['username']=$username;
            $_SESSION['user_type']="receiver";
            return true;
        } else {
            // user authentication details are wrong
            return null;
        }
    }

	/** New Hospital Registration **/
	function registerHospital($username,$password,$hospitalname,$mobile_no) {
        $alreadyExist=$this->getOne("SELECT hospital_id FROM hospitals_info WHERE username = '$username'");
        if($alreadyExist!=null){
            return null;
        }else {
            $uuid = uniqid('', true);
            $hash = $this->hashSSHA($password);
            $encrypted_password = $hash["encrypted"]; // encrypted password
            $salt = $hash["salt"]; // salt
     		$this->execute("INSERT INTO hospitals_info VALUES('','$username','$encrypted_password','$hospitalname','$mobile_no','$salt',NOW())");

            //Insert hospital Id and bloodgroup Id in available_samples
     		return $this->insertIdsinAvailableSamples($username); 
        }
	}

    /** New Receiver Registration **/
    function registerReceiver($username,$password,$receivername,$mobile_no,$blood_type) {
        $alreadyExist=$this->getOne("SELECT receiver_id FROM receivers_info WHERE username = '$username'");
        if($alreadyExist!=null){
            return null;
        }else{
            $uuid = uniqid('', true);
            $hash = $this->hashSSHA($password);
            $encrypted_password = $hash["encrypted"]; // encrypted password
            $salt = $hash["salt"]; // salt
            $this->execute("INSERT INTO receivers_info VALUES('','$username','$encrypted_password','$receivername','$mobile_no','$blood_type','$salt',NOW())");
            $result = $this->getOne("SELECT * FROM receivers_info WHERE username = '$username'");
            return $result;
        }
    }

    /** Insert hospital id when new hospital registered **/
    function insertIdsinAvailableSamples($hospital_username){
        $hospital_id = $this->getOne("SELECT hospital_id FROM hospitals_info WHERE username = '$hospital_username'");
        $bloodgroup_id_list = $this -> getAll("SELECT bloodgroup_id FROM blood_group ORDER BY bloodgroup_id");
        foreach ($bloodgroup_id_list as $bloodgroup_id) {
          $this->execute("INSERT INTO available_samples VALUES('','".$hospital_id['hospital_id']."',
                                            '".$bloodgroup_id['bloodgroup_id']."','0') ");
        }
        return true;
    }

    /** Get data of receiver who requested blood sample of a hospital **/
    function getRequestedSampleData($hospital_username,$bloodgroup_id){
        $data = array();
        $hospital_id= $this->getOne("SELECT hospital_id FROM hospitals_info WHERE username='$hospital_username'");
        $result= $this->getAll("SELECT * FROM requests WHERE hospital_id='".$hospital_id['hospital_id']."' 
                                        AND bloodgroup_id='$bloodgroup_id' ORDER BY datetime DESC");
        //push details into array
        foreach ($result as $key => $value) {
            $receiver = $this->getOne("SELECT * FROM receivers_info WHERE 
                                              receiver_id = '".$result[$key]['receiver_id']."' ");
            $request= array("receiver_name"=>$receiver['receiver_name'], "mobile_no" => $receiver['mobile_no'],
                    "datetime"=>$result[$key]['datetime']);
            array_push( $data, $request );
        }
        return $data;
    }

    /** Add new blood samples info of donor **/
    function addBloodInfo($hospital_username,$donor_name,$mobile_no,$blood_type){
       $hospital_id= $this->getOne("SELECT hospital_id FROM hospitals_info WHERE username='$hospital_username'"); 
       $result = $this->execute("INSERT into add_blood_info VALUES ('','".$hospital_id['hospital_id']."','$donor_name','$mobile_no','$blood_type',NOW())");
       return $result;
    }

    /** Get donors data added using add blood info method **/
    function getDonorsData($hospital_name,$bloodgroup_id){
        $data = array();
        $hospital_id= $this->getOne("SELECT hospital_id FROM hospitals_info WHERE username='$hospital_name'");
        $result= $this->getAll("SELECT * FROM add_blood_info WHERE hospital_id='".$hospital_id['hospital_id']."' 
                                        AND bloodgroup_id='$bloodgroup_id' ORDER BY datetime ASC");
        //push details into array
        foreach ($result as $key => $value) {
            $request= array("donor_name"=>$result[$key]['donor_name'], "mobile_no" => $result[$key]['mobile_no'],
                    "datetime"=>$result[$key]['datetime']);
            array_push( $data, $request );
        }
        return $data;
    }

    /** Get status of availability of blood sample data of a hosptial **/
    function getAvailableSamplesData($hospital_username){
        $data = array();
        $hospital_id = $this->getOne("SELECT hospital_id FROM hospitals_info WHERE username='$hospital_username'");
        $result= $this->getAll("SELECT * FROM available_samples WHERE hospital_id='".$hospital_id['hospital_id']."' 
                                        ORDER BY bloodgroup_id ASC");
        //push details into array
        foreach ($result as $key => $value) {
            $bloodgroup_name= $this->getOne("SELECT bloodgroup_name FROM blood_group 
                                                    WHERE bloodgroup_id='".$result[$key]['bloodgroup_id']."'");
            $request = array("bloodgroup_id" => $result[$key]['bloodgroup_id'], "bloodgroup_name" => 
                                $bloodgroup_name['bloodgroup_name'], "availability" => $result[$key]['availability']);
            array_push( $data, $request );
        }
        return $data;
    }

    /** Change status of availability of blood sample data of a hosptial  **/
    function changeAvailability($hospital_username,$checked_list){
        $hospital_id = $this->getOne("SELECT hospital_id FROM hospitals_info WHERE username='$hospital_username'");
        $this->execute("UPDATE available_samples SET availability = '0' WHERE hospital_id = '".$hospital_id['hospital_id']."' ");
        foreach ($checked_list as $check) {
            $this->execute("UPDATE available_samples SET availability = '1' WHERE hospital_id = '".$hospital_id['hospital_id']."' AND bloodgroup_id='$check' ");
        }
        return true;
    }

    /** Get status of availability of blood sample data of all hosptials  **/
    function getAllAvailableSamples($bloodgroup_id){
        $data = array();
        $result= $this->getAll("SELECT * FROM available_samples WHERE bloodgroup_id='$bloodgroup_id' 
                                        AND availability='1' ");
        //push details into array
        foreach ($result as $key => $value) {
          $hospital = $this->getOne("SELECT * FROM hospitals_info WHERE hospital_id='".$result[$key]['hospital_id']."'");
          $request = array("hospital_name" => $hospital['hospital_name'], "mobile_no" => $hospital['mobile_no']
                        ,"sample_id" => $result[$key]['sample_id']);
          array_push( $data, $request );
        }
        return $data;
    }

    /** Request available blood sample of particular hosptial  **/
    function requestBlood($receiver_username,$sample_id){
        $sample= $this->getOne("SELECT * FROM available_samples WHERE sample_id='$sample_id' ");
        $receiver_id = $this->getOne("SELECT receiver_id FROM receivers_info WHERE username='$receiver_username'");
        $result = $this->execute(" INSERT INTO requests VALUES('', ".$receiver_id['receiver_id'].", ".$sample['hospital_id'].", ".$sample['bloodgroup_id'].",NOW() ) ");
        if(is_null($result)){
            return null;
        }
        return true;
    }
}