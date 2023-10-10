<?php
namespace App\Traits;
trait ProductValidation {
  public function validateNumber($num) {
$reqExp = '/^[0-9]{1,}$/';
return preg_match($reqExp, $num);
  }

public function validateName($fullName) {
  $reqExp = '/^(?:[A-Za-z0-9]{2,}\s*)+$/';
  return preg_match($reqExp, $fullName);
}

public function fileValidator($name, $type_arr, $size = '1', $max_size = '10'){
  $type = explode('.', $name);
  $type = strtolower(end($type));
  return in_array($type, $type_arr)? ($size < $max_size)? true: false : false;
}
} 