<?php

namespace App\Domain\Product;

use App\Domain\Database\DatabaseInstance;

class Reviews
{
    /**
     * Returns an array of reviews from a specific product
     *
     * @param int $id
     * @param string $order table column to order by
     * @param string $order asc | desc
     * @return array $reviews
     */
    public function getReviews($id, $order, $dir)
    {
        $db = new DatabaseInstance();
        $conn = $db->create();

        $asc = $dir ? "ASC" : "DESC";
        $stmt = $conn->prepare("SELECT R.Text, R.Rating, R.created_at, U.FirstName, U.LastName FROM Reviews AS R JOIN Users AS U ON U.UserID = R.UserID WHERE R.ProductID = :id ORDER BY $order $asc");

        $stmt->bindParam(':id', $id);

        // $stmt->bindParam(':order', $order);
        // $stmt->bindParam(':dir', $asc);
        $stmt->execute();
        $reviews = $stmt->fetchAll();
        return $reviews;
    }

    /**
     * Return average rating of a product
     *
     * @param int $id
     * @return array $rating
     */
    public function getRating($id)
    {
        $db = new DatabaseInstance();
        $conn = $db->create();

        $stmt = $conn->prepare("SELECT avg(Rating) as 'AvgRating', Rating FROM Reviews WHERE ProductID = :id");
        $stmt->bindParam(':id', $id);

        $stmt->execute();

        $rating = $stmt->fetch();
        return $rating;
    }

    /**
     * Toevoegen van revieuw
     *
     * @param int $id
     * @param int $rating
     * @param string $msg
     * @return void
     */
    public function addReview($id, $rating, $msg)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['User']) && !empty($_SESSION['User'])) {
            if (!$this->usersHasReviewed($id)) {
                $db = new DatabaseInstance();
                $conn = $db->create();

                $stmt = $conn->prepare("INSERT INTO `reviews`(`ProductID`,`UserID`,`Rating`,`Text`) VALUES( ? , ? , ? , ? )");

                $stmt->execute([$id, $_SESSION['User']['UserID'], $rating, $this->stripAllHtml($msg)]);

                $stmt->fetchAll();
            }
        }
    }

    /**
     * functie die de html weghaalt uit de sting
     *
     * @param string $msg
     * @return string
     */
    private function stripAllHtml($msg){
        $msg = strip_tags($msg);
        return $msg;
    }

    /**
     * Vragen of current user al een review heeft gedaan om het artikel
     *
     * @param int $id
     * @return bool
     */
    public function usersHasReviewed($id)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['User']) && !empty($_SESSION['User'])) {
            
            if (isset($all['Aantal']) && ($all['Aantal'] * 1) >= 1) {
                return true;
            }
            return false;
        }
        return true;
    }
}
