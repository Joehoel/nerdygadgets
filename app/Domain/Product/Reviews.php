<?php

namespace App\Domain\Reviews;

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

  /**
   * Return average rating of a product
   *
   * @param int $id
   * @return array $rating
   */
  public function getRating($id) {
    $db = new DatabaseInstance();
    $conn = $db->create();

    $stmt = $conn->prepare("SELECT avg(Rating) as 'AvgRating', Rating FROM Reviews WHERE ProductID = :id");
    $stmt->bindParam(':id', $id);

    $stmt->execute();

    $rating = $stmt->fetch();
    return $rating;
  }
}
