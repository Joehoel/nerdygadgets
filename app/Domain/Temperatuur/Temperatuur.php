<?php

namespace App\Domain\Temperatuur;

use App\Domain\Database\DatabaseInstance;

class Temperatuur{
    /**
     * Deze functie kijkt of het opgegeven guid gelijk is aan die van de database
     *
     * @param strin $guid
     * @return bool
     */
    public function guidIsCorrect($guid)
    {
        $db = new DatabaseInstance();
        $conn = $db->create();

        $stmt = $conn->prepare("SELECT * FROM `tempguid`");
        $stmt->execute();
        $result = $stmt->fetchAll();

        if ($result[0]["current_guid"] == $guid) {
            return true;
        }
        return false;
    }

    /**
     * Hier word een sterke guid gemaakt en terug gestuurd
     *
     * @return sting $guid
     */ 
    public function createGuid()
    {
        if (function_exists('com_create_guid') === true) {
            return trim(com_create_guid(), '{}');
        }
        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }

    public function getLastTemp(){
        $db = new DatabaseInstance();
        $conn = $db->create();

        $stmt = $conn->prepare("SELECT * FROM `coldroomtemperatures` where ColdRoomSensorNumber = 1 ORDER BY RecordedWhen DESC LIMIT 1");
        $stmt->execute();
        $result = $stmt->fetchAll();
        if (isset($result) && !empty($result)){
            return $result[0]['Temperature'] . '°C ';
        }
        else {
            return "error";
        }
    }
}