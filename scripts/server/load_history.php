<?php

$name = $_POST['name'];
$password = $_POST['password'];
$n_buckets = intval($_POST['n_buckets']);
$history = array();  
$error_msg = "";

require_once "config.php";

// check user details
$valid_user = false;
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
$sql = "SELECT id, username, password FROM users WHERE username='$name'";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_assoc($result);

if((mysqli_num_rows($result)>=1) && (password_verify($password, $row['password']))) { // user exists
  
  // get bucket/weight pairs
  for ($x = 0; $x < $n_buckets; $x++) {
    $b = "b".($x+1);
    $sql = "SELECT $b FROM track WHERE username='$name'";
    if (!mysqli_query($link, $sql)) {  
      $error_msg = "history not found";
      break;
    } else {
      $result = mysqli_query($link, $sql);
      $row = mysqli_fetch_assoc($result);  
      array_push($history, $row["$b"]);
    }
  }
  
  // get dates
  $sql = "SELECT dates FROM track WHERE username='$name'";
  if (!mysqli_query($link, $sql)) {  
    $error_msg = "history not found";
  } else {
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_assoc($result);  
    array_push($history, $row["dates"]);
  }
} else {
  $error_msg = "user does not exist";
}
if (empty($error_msg)) {
  $json_data = json_encode($history);
  echo $json_data;
} else {
  echo $table_err;
}
mysqli_close($link);

?>