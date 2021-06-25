<?php 
  include 'header.php' ;
  $product = new Product();
  $product->getExpiredGoods();
  $product->checkQuantity();
  showMsg();
?>

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800">Dashboard</h1>

          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Goods in stock</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Name</th>
                      <th>Price</th>
                      <th>Quantity</th>
                      <th>Purchase Date</th>
                      <th>Expiry Date</th>
                      <th>Minumum Quantity</th>
                      <th>Barcode</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>#</th>
                      <th>Name</th>
                      <th>Price</th>
                      <th>Quantity</th>
                      <th>Purchase Date</th>
                      <th>Expiry Date</th>
                      <th>Minumum Quantity</th>
                      <th>Barcode</th>
                    </tr>
                  </tfoot>
                  <tbody>
                  <?php  
                    $i = 0;
                      $product = new Product();
                      $rows = $product->viewProduct();
                      foreach($rows as $row):
                        $i = $i + 1;
                    ?>
                    <tr>
                    <td><?php echo $i ?></td>
                      <td><?php echo $row['name'] ?></td>
                      <td><?php echo $row['price'] ?></td>
                      <td><?php echo $row['quantity'] ?></td>
                      <td><?php echo $row['purchase_date'] ?></td>
                      <td><?php echo $row['expiry_date'] ?></td>
                      <td><?php echo $row['minimum_quantity'] ?></td>
                      <td><img src="../images/barcode.png" alt="" style="width: 70px"></td>
                    </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

<?php include 'footer.php'  ?>