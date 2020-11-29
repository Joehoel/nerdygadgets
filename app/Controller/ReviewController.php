<?php

namespace App\Controller;

use App\Domain\Product\Reviews;

class ReviewController
{
  public function create($id)
  {
    if(isset($_POST['rating']) && isset($_POST['review-text'])) {
      print_r($_POST);
      print("\n");
      print_r($_SESSION);
      // $_SESSION['User']['UserID'] = 1;

      // $reviews = new Reviews();
      // $reviews->addReview($id, $_POST['rating'], $_POST['review-text']);
      // return header("Location: " . base_url . "product/" . $id);
    }
  }
}
