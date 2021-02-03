<?php
spl_autoload_register('GAP_Form_AutoLoader');

function GAP_Form_AutoLoader($class) {
  if ( false  !== strpos( $class, 'FormGAP' ) ) {
    $search = '\\';
    $replace = '/';
    $class = str_replace($search, $replace, $class);
    $path = "";
    $extension = ".php";
    $fullPath = $path . $class . $extension;

    if (!file_exists(plugin_dir_path( __FILE__ ) . $fullPath)){
      return false;
    }
    include_once $fullPath;
  }
}
