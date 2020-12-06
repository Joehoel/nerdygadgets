<?php

namespace App\Controller;

use App\Domain\Database\DatabaseInstance;

class TempController
{
    /**
     * Deze functie handeld het toevoegen van een temperatuur meting af
     *
     * @return void
     */
    public function voegmetingtoe()
    {
        if (!isset($_GET['guid']) || empty($_GET['guid'])) {
            exit;
        }
        if (isset($_GET['meting']) && !empty($_GET['meting']) && $this->guidIsCorrect($_GET['guid'])) {
            $db = new DatabaseInstance();
            $conn = $db->create();

            $stmt = $conn->prepare("INSERT INTO temperatuurmeting (temperatuur) VALUES (?)");
            $stmt->execute([$_GET['meting']]);

            $guid = $this->createGuid();

            $stmt = $conn->prepare("UPDATE `tempguid` SET `current_guid`= ?");
            $stmt->execute([$guid]);

            echo '{"guid" : "' . $guid . '"}';
        } else {
            exit;
        }
    }

    /**
     * Deze functie kijkt of het opgegeven guid gelijk is aan die van de database
     *
     * @param strin $guid
     * @return bool
     */
    private function guidIsCorrect($guid)
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
    private function createGuid()
    {
        if (function_exists('com_create_guid') === true) {
            return trim(com_create_guid(), '{}');
        }
        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }
}
