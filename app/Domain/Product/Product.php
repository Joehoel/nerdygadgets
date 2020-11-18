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

  /**
   * Get all products
   *
   * @return array products
   */
  public function getProducts()
  {
    // ! Werkt nog niet
    $result = array();

    $db = new DatabaseInstance();
    $conn = $db->create();

    $stmt = $conn->prepare("SELECT StockItemID, StockItemName, SearchDetails, CONCAT('Voorraad: ',QuantityOnHand)
                          AS QuantityOnHand(RecommendedRetailPrice*(1+(TaxRate/100))) AS SellPrice FROM stockitems");
    $stmt->execute();

    $result = $stmt->fetchAll();

    return $result;
  }
}
