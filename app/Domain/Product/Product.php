<?php

namespace App\Domain\Product;

use App\Domain\Database\DatabaseInstance;

class Product
{

  /**
   * Get a single product
   *
   * @param int $id
   * @return array product
   */
  public function getProduct($id)
  {
    $result = array();

    $db = new DatabaseInstance();
    $conn = $db->create();

    $stmt = $conn->prepare("SELECT StockItemID, StockItemName, SearchDetails, (RecommendedRetailPrice*(1+(TaxRate/100))) AS SellPrice FROM stockitems WHERE StockItemID = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    $result = $stmt->fetch();

    return $result;
  }

  public function getProducts() {
    // Nog maken
  }
}
