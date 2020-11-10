<?php

namespace NerdyGadgests\Classes {
    class DataBase
    {
        public $connection = null;

        public function MakeConnection()
        {
            $Connection = mysqli_connect("localhost", "root", "", "nerdygadgets");
            mysqli_set_charset($Connection, 'latin1');
            $this->connection = $Connection;
            return $this->connection;
        }

        public function CloseConnection()
        {
            mysqli_close($this->connection);
            $this->connection = null;
        }
    }
}
