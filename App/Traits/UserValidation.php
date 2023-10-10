<?php
namespace App\Traits;
trait userValidation {
  public function validateNumber($num) {
$reqExp = '/^[0-9]{1,}$/';
return preg_match($reqExp, $num);
  }
//   public function validateDate($date) {
// $reqExp = '/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/';
// return preg_match($reqExp, $date);
//   }
public function validateFullName($fullName) {
  $reqExp = '/^(?:[A-Za-z]{2,}\s*)+$/';
  return preg_match($reqExp, $fullName);
}
public function validateEmail($email) {
  $reqExp = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
  return preg_match($reqExp, $email);
}
public function validatePass($pass) {
  $reqExp = '/^[a-zA-Z0-9]{8,}$/';
  return preg_match($reqExp, $pass);
}
public function fileValidator($name, $type_arr, $size = '1', $max_size = '10'){
  $type = explode('.', $name);
  $type = strtolower(end($type));
  return in_array($type, $type_arr)? ($size < $max_size)? true: false : false;
}
} 