<?php
    // Set headers to allow cross-origin requests
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Content-Type');
    header('Content-Type: application/json');

    $con = mysqli_connect("localhost","root","","dbstudents");

    if(!$con){
        die("Error");
    }

    $query = "select * from tbl_students";
    $result = mysqli_query($con,$query);
    $method = $_SERVER['REQUEST_METHOD'];

    if(mysqli_num_rows($result) > 0){
        while($show = mysqli_fetch_assoc($result)){
            $data[] = $show;
        }
    }else{
        echo "Record Error!";
    }
    if($method == "GET") {        
        if(isset($_GET['id'])) {
            if(isset($data[$_GET['id']]))
                echo json_encode($data[$_GET['id']]);
            else
                echo json_encode('Record Error!');
        }
        else
        if(isset($data)){
            echo json_encode($data);
        }
    }

    if($method == "POST") {
        $temp = urldecode(file_get_contents('php://input'));
        parse_str($temp, $value);


        $firstname = $value['firstname'];
        $lastname = $value['lastname'];
        $gender = $value['gender'];
        $course = $value['course'];
        
        $query = "INSERT INTO tbl_students(firstname,lastname,gender,course) VALUES ('$firstname','$lastname','$gender','$course')";
        $add = mysqli_query($con,$query);
        $response = [
            "message" => "Post Successfully added",
            "data" => $data
        ];
        echo json_encode($response);
    }

?>