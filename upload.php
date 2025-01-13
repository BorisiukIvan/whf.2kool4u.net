<?php
   include "backend/logger.php";
   function sort_file($file_name, $reading, $writing, $placeholder) {
       if ($writing < $reading) $writing = $reading;
       $json = json_decode(file_get_contents("backend/catalog.json"), true);
       $content = str_replace("\n", "<br>", htmlspecialchars(file_get_contents($file_name))) . "<br><br>";
       $config = array("read" => $reading, "write" => $writing, "placeholder" => $placeholder);
       for ($i = $reading; $i < 11; $i++) {
           $json[strval($i)][] = explode("files/", $file_name)[1];
           $config[strval($i)] = $content;
       }
       file_put_contents($file_name, json_encode($config));
       file_put_contents("backend/catalog.json", json_encode($json));
       header("Location: /index.php?filename=" . explode("files/", $file_name)[1]);
   }
   $minlevel = intval($_POST['minlevel']);
   $minlevelallow = intval($_POST['minlevelallow']);
   if (($_POST['method'] == '2') and (isset($_FILES['uploaded_text']))){
      $errors= array();
      $file_name = "backend/files/" . $_POST['name'] . ".JSON";
      $file_size =$_FILES['uploaded_text']['size'];
      $file_tmp =$_FILES['uploaded_text']['tmp_name'];
      
 //     if($file_size > 209715){
 //        $errors[]='Файл слишком большой';
 //     }
      
      if(file_exists($file_name)){
         $errors[]='Файл с таким именем уже существует';
      }

      if(empty($errors)==true){
         move_uploaded_file($file_tmp,$file_name);
         sort_file($file_name, $minlevel, $minlevelallow, $_POST['placeholder']);
      }else{
         print_r($errors);
      }
   } else if ($_POST['method'] == '1') {
      $errors= array();
      $file_name = "backend/files/" . $_POST['name'] . ".JSON";
      $file_size = strlen($_POST['text']);

 //     if($file_size > 209715){
   //      $errors[]='Файл слишком большой';
   //   }
      
      if(file_exists($file_name)){
         $errors[]='Файл с таким именем уже существует';
      }

      if(empty($errors)==true){
         file_put_contents($file_name, $_POST['text']);
         sort_file($file_name, $minlevel, $minlevelallow, $_POST['placeholder']);
      }else{
         print_r($errors);
      }
   }
?>
