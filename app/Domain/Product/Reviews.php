<?php

namespace App\Domain\Reviews;

use App\Domain\Database\DatabaseInstance;

class Reviews
{
  /**
   * Returns an array of reviews from a specific product
   *
   * @param int $id
   * @return array $reviews
   */
  public function getReviews($id) {
    $db = new DatabaseInstance();
    $conn = $db->create();

    $stmt = $conn->prepare("SELECT R.Text, R.Rating, U.FirstName, U.LastName
                                FROM Reviews AS R
                                JOIN Users AS U ON U.UserID = R.UserID
                                WHERE R.ProductID = :id");

    $stmt->bindParam(':id', $id);
    $stmt->execute();

    $reviews = $stmt->fetchAll();
    return $reviews;
  }
}
