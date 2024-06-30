<?php
session_start();

require 'dbcon.php';
function validate($inputData)
{
    global $conn;
    $validatedData = mysqli_real_escape_string($conn, $inputData);
    return trim($validatedData);
}


function redirect($url, $status)
{
    $_SESSION['status'] = $status;
    header('Location: ' . $url);
    exit(0);
}

function alertMessage()
{
    if (isset($_SESSION['status'])) {
        echo ' <div class="alert alert-warning alert-dismissible fade show" role="alert">
            ' . $_SESSION['status'] . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        unset($_SESSION['status']);
    }
}

function insert($tableName, $data)
{

    global $conn;
    $table = validate($tableName);
    $columns = array_keys($data);
    $values = array_values($data);

    $finalColumn = implode(',', $columns);
    $finalValues = "'" . implode("', '", $values) . "'";

    $query = "INSERT INTO $table ($finalColumn) VALUES ($finalValues) ";
    $result = mysqli_query($conn,$query) ;
    return $result;
}

function update($tableName, $id,$data){
    
    global $conn;
    $table = validate($tableName);
    $id = validate($id);

    $updateDataString = "";
    
    foreach($data as $column => $value){
        $updateDataString .= $column. '='."'$value',";
    }

    $finalUpdateData = substr(trim($updateDataString),0,-1);

    $query = "UPDATE $table SET $finalUpdateData WHERE id='$id'";
    $result = mysqli_query($conn,$query);
    return $result;
}


function getAll($tableName, $status = NULL){

    global $conn;

    $table = validate($tableName);
    $status = validate($status);

    if($status == 'status'){
        $query = "SELECT * FROM $table WHERE $status = '0'";
    }
    else{
        $query = "SELECT * FROM $table ";
    }
    return mysqli_query($conn,$query);
}

function GetById($tableName, $id) {

    global $conn;

    $table = validate($tableName);
    $id = validate($id);

    if (!$table || !$id) {
        return [
            'status' => 400,
            'message' => 'Invalid request parameters'
        ];
    }

    $query = "SELECT * FROM $table WHERE id = '$id' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        return [
            'status' => 500,
            'message' => 'Database error'
        ];
    }

    $num_rows = mysqli_num_rows($result);
    if ($num_rows === 0) {
        return [
            'status' => 404,
            'message' => 'No record found'
        ];
    }

    $row = mysqli_fetch_assoc($result);
    mysqli_free_result($result);

    return [
        'status' => 200,
        'data' => $row,
        'message' => 'Record retrieved successfully'
    ];
}



function delete($tableName, $id){

    global $conn;

    $table = validate($tableName);
    $id = validate($id);

    $query = "DELETE FROM $table WHERE  id = '$id' LIMIT 1";
    $result = mysqli_query($conn,$query);
    return $result;

}


function checkParamId($type){

    if(isset($_GET[$type])){
        if($_GET[$type] != ''){
            return $_GET[$type];
        }else{
            return '<h5>No Id Found</h5>';
        }
    }else{
        return '<h5>No Id At Url</h5>';
    }

}

function logoutSession(){
    unset($_SESSION['loggedIn']);
    unset($_SESSION['loggedInUser']);
}

?>