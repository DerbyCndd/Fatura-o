<?php
include_once 'conexao.php';
require_once 'dbcon.php';
session_start();

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

 function registar($data) {
    
    $sql = 'INSERT INTO products (categoryid, name, description,price, quantity, status ) VALUES (?,?,?,?,?,?)';

    $stmt = Conexao::getConn()->prepare($sql);
    $stmt->bindValue(1, $data['category_id']);
    $stmt->bindValue(2, $data['name']);
    $stmt->bindValue(3, $data['description']);
    $stmt->bindValue(4, $data['price']);
    $stmt->bindValue(5, $data['quantity']);
    $stmt->bindValue(6, $data['status']);

    $stmt->execute();

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

function updateProduct($data, $id) {
    try {
        $sql = 'UPDATE products SET categoryid = :categoryid, name = :name, description = :description, price = :price, quantity = :quantity, status = :status WHERE id = :id';

        $conn = Conexao::getConn(); // Verifique se a conexão está sendo obtida corretamente
        $stmt = $conn->prepare($sql);

        // Verifique se os parâmetros estão sendo passados corretamente
        $stmt->bindParam(':categoryid', $data['categoryid']);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':price', $data['price']);
        $stmt->bindParam(':quantity', $data['quantity']);
        $stmt->bindParam(':status', $data['status']);
        $stmt->bindParam(':id', $id); 
        
        // Execute a query
        $stmt->execute();

        // Verifique se a atualização foi bem-sucedida
        if ($stmt->rowCount() > 0) {
            echo "Produto atualizado com sucesso!";
        } else {
            echo "Nenhum produto atualizado.";
        }
    } catch (PDOException $e) {
        echo "Erro ao atualizar produto: " . $e->getMessage();
    }
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


function jsonResponse($status, $status_type, $message){

    $response = [
        'status' => $status,
        'status_type '=> $status_type,
        'message' => $message
    ];
    echo json_encode($response);
    return;

}
?>