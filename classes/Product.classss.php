<?php

class Product extends Pdocon {

    public function viewProduct() {
        $this->query("SELECT * FROM products");
        $rows = $this->fetchMultiple();
        return $rows;
    }

    public function addProduct($name, $price, $quantity, $purchase_date, $expiryDate, $minimum_quantity, $expiry_duration) {
        $rawName             =      cleanData($name);
        $rawPrice            =      cleanData($price);
        $rawQuantity         =      cleanData($quantity);
        $rawPurchase_date    =      cleanData($purchase_date);
        $rawExpiry           =      cleanData($expiryDate);
        $rawMinimum          =      cleanData($minimum_quantity);

        $cleanName           =      sanitizeStr($rawName);
        
        $this->query("INSERT INTO products (name, price, quantity, purchase_date, expiry_date, minimum_quantity, expiry_duration) VALUES (:name, :price, :quantity, :purchase_date, :expiry_date, :minimum_quantity, :expiry_duration)");
        $this->bindValue(':name', $cleanName, PDO::PARAM_STR);
        $this->bindValue(':price', $rawPrice, PDO::PARAM_INT);
        $this->bindValue(':quantity', $rawQuantity, PDO::PARAM_INT);
        $this->bindValue(':purchase_date', $rawPurchase_date, PDO::PARAM_INT);
        $this->bindValue(':expiry_date', $rawExpiry, PDO::PARAM_STR);
        $this->bindValue(':minimum_quantity', $rawMinimum, PDO::PARAM_INT);
        $this->bindValue(':expiry_duration', $expiry_duration, PDO::PARAM_INT);

        if($this->execute()) {
            keepMsg('<div class="alert alert-success alert-dismissible text-center mt-5">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Success</strong>  Product added successfully
                </div>');
                redirectPage('addproduct.php');
        }else {
            keepMsg('<div class="alert alert-danger alert-dismissible text-center mt-5">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Error</strong>  An error occurred
                </div>');
        }
    }
    public function deleteProduct($product) {
        $this->query("DELETE FROM products WHERE id=:id");
        $this->bindValue(":id", $product, PDO::PARAM_INT);
        if($this->execute()) {
            keepMsg('<div class="alert alert-success alert-dismissible text-center mt-5">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Success</strong>  Product deleted successfully
                </div>');
        }else {
            keepMsg('<div class="alert alert-danger alert-dismissible text-center mt-5">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Error</strong>  An error occurred
                </div>');
        }
    }

    public function updateProduct($user, $name, $price, $quantity, $purchase_date, $expiryDate, $minimum_quantity, $expiry_duration) {
        $rawName             =      cleanData($name);
        $rawPrice            =      cleanData($price);
        $rawQuantity         =      cleanData($quantity);
        $rawPurchase_date    =      cleanData($purchase_date);
        $rawExpiry           =      cleanData($expiryDate);
        $rawMinimum          =      cleanData($minimum_quantity);

        $cleanName           =      validateStr($rawName);
        
        $this->query("UPDATE products SET name=:name, price=:price, quantity=:quantity, purchase_date=:purchase_date, expiry_date=:expiry_date, minimum_quantity=:minimum_quantity expiry_duration=:expiry_duration WHERE id=:id");
        $this.bindValue(':name', $cleanName, PDO::PARAM_STR);
        $this.bindValue(':price', $rawPrice, PDO::PARAM_INT);
        $this.bindValue(':quantity', $rawQuantity, PDO::PARAM_INT);
        $this.bindValue(':purchase_date', $rawPurchase_date, PDO::PARAM_INT);
        $this.bindValue(':expiry_date', $rawExpiry, PDO::PARAM_STR);
        $this.bindValue(':minimum_quantity', $rawMinimum, PDO::PARAM_INT);
        $this.bindValue(':expiry_duration', $expiry_duration, PDO::PARAM_INT);
        $this.bindValue(':id', $user, PDO::PARAM_INT);

        if($this->excute()) {
            keepMsg('<div class="alert alert-success alert-dismissible text-center mt-5">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Success</strong>  Product added successfully
                </div>');
        }else {
            keepMsg('<div class="alert alert-danger alert-dismissible text-center mt-5">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Error</strong>  An error occurred
                </div>');
        }
    }

    public function getExpiredGoods() {
        $this->query("SELECT * FROM products WHERE quantity > 0");
        $rows = $this->fetchMultiple();

        foreach ($rows as $row) {
            $ex = $row['expiry_duration'] * 24 * 60 * 60 * 1000;
            if (strtotime($row['expiry_date']) * 1000 > strtotime(date("y-m-d")) * 1000 + $ex ) {
                keepMsg('<div class="alert alert-danger alert-dismissible text-center mt-5">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Warning</strong>  Product ('.  $row['name'] .') is about to expire
                </div>');
                
            }
        }


    }

    public function checkQuantity() {
        $this->query("SELECT * FROM products WHERE quantity <= minimum_quantity");
        $rows = $this->fetchMultiple();
        if ($rows) {
            foreach($rows as $row) {
                keepMsg('<div class="alert alert-danger alert-dismissible text-center mt-5">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Warning</strong>  Product ('.  $row['name'] .') is running low
                </div>');
                
            }
            
        }

    }
}