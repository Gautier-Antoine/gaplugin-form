<?php
spl_autoload_register('myAutoLoader2');

function myAutoLoader2($class) {
  $path = "";
  $extension = ".php";
  $fullPath = $path . $class . $extension;

  if (!file_exists(plugin_dir_path( __FILE__ ) . $fullPath)){
    return false;
  }

  include_once $fullPath;
}
