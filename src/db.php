<?php
class db {
    // Configuración para XAMPP
    //private $dbHost = 'localhost';
    //private $dbUser = 'root';
    //private $dbPass = '';
    //private $dbName = 'parcial3_ch13006_clearwrite';

    //public function connect() {
    //    $mysql_connect_str = "mysql:host=$this->dbHost;dbname=$this->dbName;charset=utf8";
    //    $dbConnection = new PDO($mysql_connect_str, $this->dbUser, $this->dbPass);
        // Configurar PDO para que mande excepciones si hay errores
    //    $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //    return $dbConnection;
    //}

    //Configuración para filess.io
    private $dbHost = 's9smfy.h.filess.io';
    private $dbUser = 'parcial3_ch13006_clearwrite';
    private $dbPass = 'fe52115952ea1a8c5263d15d0be2aa09ce4270f6';
    private $dbName = 'parcial3_ch13006_clearwrite';
    private $dbPort = '61001';

    // Conexión usando PDO
    public function connect() {
        $mysql_connect_str = "mysql:host=$this->dbHost;port=$this->dbPort;dbname=$this->dbName;charset=utf8";
        $dbConnection = new PDO($mysql_connect_str, $this->dbUser, $this->dbPass);
        // Configurar PDO para que mande excepciones si hay errores
        $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $dbConnection;
    }
}
?>