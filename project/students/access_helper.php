<?php

/**
 * @param array $arr 
 * @param string $key 
 * @return string|mixed
 */
function maybe_get($arr, $key)
{
  if (isset($arr)) $arr[$key];
  return '';
}

function empty_to_null($val)
{
  if (empty($val)) return null;
  return $val;
}