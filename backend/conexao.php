<?php

class Conexao {

private  $server = "mysql:host=localhost;dbname=db_pessoa";
private  $user = "root";
private  $pass = "1221";
private $options  = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,);
protected $con;
 
  public function abreConexao() {
    try {
      $this->con = new PDO($this->server, $this->user,$this->pass,$this->options);
      return $this->con;
    } catch (PDOException $e) {
      echo "There is some problem in connection: " . $e->getMessage();
    }
  }

  public function fechaConexao() {
    $this->con = null;
  }
}
?>