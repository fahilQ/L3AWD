<?php

$host='localhost';

$username='root';

$password='aymen2006';

$dbname='login_db';

$conn=new mysqli($host,$username,$password,$dbname);

if($conn->connect_error){

    die('connection failed :' . $conn->connect_error);

}
?>