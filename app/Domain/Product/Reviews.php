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
  public function getReviews($id, $order, $dir)
  {
    $db = new DatabaseInstance();
    $conn = $db->create();

    $asc = $dir ? "ASC" : "DESC";
    $stmt = $conn->prepare("SELECT R.Text, R.Rating, R.created_at, U.FirstName, U.LastName
                                FROM Reviews AS R
                                JOIN Users AS U ON U.UserID = R.UserID
                                WHERE R.ProductID = :id
                                ORDER BY $order $asc
                                ");

    $stmt->bindParam(':id', $id);
    // $stmt->bindParam(':order', $order);
    // $stmt->bindParam(':dir', $asc);
    $stmt->execute();

    $reviews = $stmt->fetchAll();
    return $reviews;
  }
}
