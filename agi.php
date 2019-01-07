#!/usr/bin/php7.0
<?php

require_once('phpagi.php');

$agi = new AGI();

$option = 0;
//menu ura
while ($option < 4) {
  $agi->verbose("entrou no while .'$option'.");
  $retorno = $agi->get_data('ura1',3000,10);
  if ($retorno["result"]){
    if ($retorno["result"] == 1) {
      //Liga para ramal 1002
      $agi->exec("Dial", "SIP/1002");
      $option = 5;
    } elseif ($retorno["result"] == 2) {
      //Liga para fila 3000
      $agi->exec("Dial", "SIP/3000");
      $option = 5;
    } elseif ($retorno["result"] == 3){
      $cpf_digitado = $agi->get_data('cpf',8000,11);
      $cpf_data = $cpf_digitado["result"];
      //Connectando no banco
      $server='127.0.0.1';
      $username='root';
      $password='root';
      $db='asterisk';
      $conn = mysqli_connect($server,$username,$password,$db);
        if (!$conn) {
          $agi->verbose("Error Mysql connect");
        }
          $agi->verbose("Mysql connected ok");
        //connectando no banco e buscando copyleft
        $cpf = $conn->query("SELECT cpf FROM clientes WHERE cpf = $cpf_data");
        if ($cpf) {
          $agi->exec("Playback","cpf_ok");
          foreach ($cpf as $c) {
            $agi->verbose($c["cpf"]);
          }
            $agi->set_variable("RETORNO", $c["cpf"]);
          //se cliente possui cadastro encaminha para recepção
          $agi->exec("DIAL","SIP/1002");
          $option = 5;
        } else {
          //se cliente não possui cadastro encaminha para fila de atendimento
          $agi->exec("Playback","cpf_old");
          $agi->exec("DIAL","SIP/3000");
        }

    } else {
      $agi->exec("Playback","error");
    }
  }
  $option ++;
}

$agi->verbose('AGI END');

?>
