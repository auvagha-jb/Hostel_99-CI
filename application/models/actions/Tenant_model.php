<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tenant_Model extends CI_Model{
    
 //$hostel_no = $_SESSION['hostel_no'];

function addTenant($data){
    
    /*
     * Turn off autocommit
     */
    $con->autocommit(false);
    
    //Form data
    $email = $_POST['email'];
    $room_assigned = $_POST['room_assigned'];
    $no_sharing = $_POST['no_sharing'];
    
    //Get the user data from the db
    $get = $user->getData($con,$email); 
    $user_id = $get['user_id'];
    $name = $get['first_name']." ".$get['last_name'];
    
    $error = array();

    //Change user_status from NULL to Tenant
    changeStatus($con, $email, $room_assigned, $no_sharing,$error);

    //Insert data into respective tables: tenants_history and 
    insertQueries($con, $user_id, $hostel_no, $error);

    //Commit the queries if there were no errors encountered
    if(count($error)==0){
        $con->commit();
        echo $name.' has been added';
    }else{
        echo var_dump($error);
        exit();
        //$con->rollback();
    }
}

function insertQueries($con, $user_id, $hostel_no, &$error){
    
    /*
     * TENANT_HISTORY 
     */
    $record_id = get_id($con);
    date_default_timezone_set('Africa/Nairobi');
    $date_checked_in = date('Y-m-d H:i:s');
    
    $insert_1 = "INSERT INTO `tenant_history`(`record_id`, `hostel_no`, `date_checked_in`) VALUES (?,?,?)";
    $stmt_1 = $con->prepare($insert_1);
    $stmt_1->bind_param("sss", $record_id, $hostel_no, $date_checked_in);
    $bool_1 = $stmt_1->execute();
    
    if($bool_1 == false){
        array_push($error, $con->error);
    }
    
    /*
     * TENANT_HISTORY_BRIDGE table
     * INSERT user_id, hostel_no AND record_id  
     */
    
    $insert_2 = "INSERT INTO tenant_history_bridge (user_id, record_id) VALUES(?,?)";
    $stmt_2 = $con->prepare($insert_2);
    $stmt_2->bind_param("ss", $user_id,$record_id);
    $bool_2 = $stmt_2->execute();
   
    if($bool_2 == false){
        array_push($error, $con->error);
    }
    
    /*
     * USER_HOSTEL_BRIDGE table
     * INSERT user_id, hostel_no AND record_id  
     */
    
    $insert_3 = "INSERT INTO user_hostel_bridge (hostel_no, user_id, record_id) VALUES(?,?,?)";
    $stmt_3 = $con->prepare($insert_3);
    $stmt_3->bind_param("sss", $hostel_no, $user_id, $record_id);
    $bool_3 = $stmt_3->execute();
   
    if($bool_3 == false){
        array_push($error, $con->error);
    }
    
    
}

function changeStatus($con, $email, $room_assigned, $no_sharing,&$error){
    
    $query  = 'UPDATE users SET user_status = "Tenant", room_assigned = ?, no_sharing = ? WHERE email = ?';
    
    $stmt = $con->prepare($query);
    $stmt->bind_param("sss", $room_assigned,$no_sharing,$email);
    $bool = $stmt->execute();
    
    if($bool == false){
        array_push($error, $con->error);
    }
}

function get_id($con){
     $record_id = mt_rand();
    
    do{        
        $select = "SELECT * FROM `tenant_history` WHERE record_id = ?";
        $stmt = $con->prepare($select);
        $stmt->bind_param("s", $record_id);
        $stmt->execute();
        
        $result = $stmt->get_result();
       
        $row_count = mysqli_num_rows($result);
        
    }while($row_count>0);
    
    return $record_id;
}
    
}