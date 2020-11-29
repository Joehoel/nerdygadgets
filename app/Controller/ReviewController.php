<?php

namespace App\Controller;

use App\Domain\Product\Reviews;

class ReviewController
{
  /**
   * Create a review
   *
   * @param int $id
   * @return void
   */
  public function create($id)
  {
    if (!isset($_SESSION['User']['UserID'])) return header("Location: " . base_url . "product/" . $id . "?error= " . _("Je moet ingelogd zijn om een review te maken"));
    if (isset($_POST['rating']) && isset($_POST['review-text']) && !empty($_POST['review-text'])) {
      // print_r($_POST);
      // print("\n");
      // print_r($_SESSION);
      // $_SESSION['User']['UserID'] = 1;
      $rating = (int) $_POST['rating'];
      if ($rating < 1 || $rating > 5) {
        header("Location: " . base_url . "product/" . $id . "?error=" . _("Beoordeling moet tussen de 1 & 5 zijn"));
      }

      $text = trim($_POST['review-text']);

      $reviews = new Reviews();
      if (!$reviews->usersHasReviewed($id)) {
        $reviews->addReview($id, $rating, $text);

        return header("Location: " . base_url . "product/" . $id . "?success");
      } else if ($reviews->usersHasReviewed($id)) {
        return header("Location: " . base_url . "product/" . $id . "?error=" . _("Je mag maar 1 review per product geven"));
      } else {
        return header("Location: " . base_url . "product/" . $id . "?error=" . _("Je moet alle velden invullen"));
      }
    }
  }
}
