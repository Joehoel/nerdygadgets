<?php

namespace App\Controller;

use App\Domain\Database\DatabaseInstance;
use App\Domain\Temperatuur\Temperatuur;

class TempController
{
    /**
     * Deze functie handeld het toevoegen van een temperatuur meting af
     *
     * @return void
     */
    public function voegmetingtoe()
    {
        $temp = new Temperatuur();
        if (!isset($_GET['guid']) || empty($_GET['guid'])) {
            echo '{"Error" : "Er is een fout opgetreden"}';
            exit;
        }
        if (isset($_GET['meting']) && !empty($_GET['meting']) && $temp->guidIsCorrect($_GET['guid'])) {
            $db = new DatabaseInstance();
            $conn = $db->create();

            $stmt = $conn->prepare("INSERT INTO temperatuurmeting (temperatuur) VALUES (?)");
            $stmt->execute([$_GET['meting']]);

            $guid = $temp->createGuid();

            $stmt = $conn->prepare("UPDATE `tempguid` SET `current_guid`= ?");
            $stmt->execute([$guid]);

            echo '{"guid" : "' . $guid . '"}';
        } else {
            echo '{"Error" : "Er is een fout opgetreden"}';
            exit;
        }
    }

    
}
