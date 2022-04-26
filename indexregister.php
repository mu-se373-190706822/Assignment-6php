<?php
header("Access-Control-Allow-Origin: *"); 
require_once 'connection.php';  
  $response = array();  
     
    if(isTheseParametersAvailable(array('username','email','password','gender'))){  
    $username = $_GET['username'];   
    $email = $_GET['email'];   
    $password = md5($_GET['password']);  
    $gender = $_GET['gender'];   
   
    $stmt = $mysqli->prepare("SELECT id FROM user WHERE username = ? OR email = ?"); //taple and the function 
    $stmt->bind_param("ss", $username, $email);  
    $stmt->execute();  
    $stmt->store_result();  
   
    if($stmt->num_rows > 0){  
        $response['error'] = true;  
        $response['message'] = 'User already registered';  
        $stmt->close();  
    }  
    else{  
        $stmt = $mysqli->prepare("INSERT INTO user (username, email, password, gender) VALUES (?, ?, ?, ?)"); //taple and the function  
        $stmt->bind_param("ssss", $username, $email, $password, $gender);  
   
        if($stmt->execute()){  
            $stmt = $mysqli->prepare("SELECT id, id, username, email, gender FROM user WHERE username = ?");   //taple and the function 
            $stmt->bind_param("s",$username);  
            $stmt->execute();  
            $stmt->bind_result($userid, $id, $username, $email, $gender);  
            $stmt->fetch();  
   
            $user = array(  
            'id'=>$id,   
            'username'=>$username,   
            'email'=>$email,  
            'gender'=>$gender  
            );  
   
            $stmt->close();  
            $response['error'] = false;   
            $response['message'] = 'User registered successfully';   
            $response['user'] = $user;   
        }  
    }   
}  
else{  
    $response['error'] = true;   
    $response['message'] = 'required parameters are not available';   
}  

echo json_encode($response);  
function isTheseParametersAvailable($params){  
foreach($params as $param){  
 if(!isset($_GET[$param])){  
     return false;   
  }  
}  
return true;   
}  
?>