<?php


//  spl_autoload_register('myAutoLoader');

  /*function myAutoLoader($className)
  {
    $url = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

    if(strpos($url, 'includes') !== false)
    {
      $path = '../classes/';
    }
    else
    {
      $path = "classes/";
    }
    $extension = ".php";

    include_once $path . $className . $extension;
  }*/

/*  spl_autoload_register(function($className) {
    $file = __DIR__ . '\\' . $className . '.php';
    $file = str_replace('\\', DIRECTORY_SEPARATOR, $file);
    if (file_exists($file)) {
      include $file;
    }
  });*/

  spl_autoload_register(function($className)
  {
    $namespace=str_replace("\\","/",__NAMESPACE__);
    $className=str_replace("\\","/",$className);
    $class=__DIR__."/classes/".(empty($namespace)?"":$namespace."/")."{$className}.php";
    include_once($class);
  });