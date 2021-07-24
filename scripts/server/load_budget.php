<?php

$name = $_POST['name'];
$password = $_POST['password'];

require_once "config.php";

// check user details
$valid_user = false;
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
$sql = "SELECT id, username, password FROM users WHERE username='$name'";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_assoc($result);

if((mysqli_num_rows($result)>=1) && (password_verify($password, $row['password']))) { // user exists
  // Get BUDGET
  $budget = array();  
  // get income
  $sql = "SELECT income FROM budget WHERE username='$name'";
  $result = mysqli_query($link, $sql);
  $row = mysqli_fetch_assoc($result);
  $income = intval($row['income']);
  array_push($budget, "income:$income");
  // get n_buckets
  $sql = "SELECT n_buckets FROM budget WHERE username='$name'";
  $result = mysqli_query($link, $sql);
  $row = mysqli_fetch_assoc($result);
  $n_buckets = intval($row['n_buckets']);
  // get bucket/weight pairs
  for ($x = 0; $x < $n_buckets; $x++) {
    $b = "b".($x+1);
    $sql = "SELECT $b FROM budget WHERE username='$name'";
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_assoc($result);  
    array_push($budget, $row["$b"]);
  }
  $json_data = json_encode($budget);
  echo $json_data;
} else {
  echo "user does not exist";
}
mysqli_close($link);

?>