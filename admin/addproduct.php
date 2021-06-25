<?php 
include 'header.php';
  showMsg();
?>
        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800"></h1>
          <div class="container">
    <div class="row">
      
      <div class="col-md-3 col-sm-1 "> </div>
      
      <div class="col-md-6 col-sm-10">
        <!-- Default form login -->
        <!-- Default form register -->
        <form class="text-center border border-light p-5" id="form" method="post" action="addproduct.php">

          <p class="h4 mb-4">Add New Product</p>

          <div class="form-row mb-4">
            <div class="col">
              <!-- First name -->
              <input type="text" name="name" id="Name" class="form-control" placeholder=" name" required>
            </div>
            <div class="col">
              <!-- Last name -->
              <input type="Number" name="price" id="Price" class="form-control" placeholder="Price" required>
            </div>
          </div>

          <!-- E-mail -->
          <input type="text" name="quantity" id="Email" class="form-control mb-4" placeholder="Quantity"  required>

          <!-- Password -->
          <input type="text" name="purchase_date" id="Password" class="form-control" placeholder="Purchase date ex: 01-01-2020" aria-describedby="defaultRegisterFormPasswordHelpBlock" required>
          <br>
          <input type="text" name="expiry_date" id="Password" class="form-control" placeholder="Expiry date ex: 01-01-2020" aria-describedby="defaultRegisterFormPasswordHelpBlock" required>
          <br>
          <div class="form-row mb-4">
            <div class="col">
              <!-- First name -->
              <input type="Number" name="minimum" id="Name" class="form-control" placeholder="Minimum Quantity" required>
            </div>
            <div class="col">
              <!-- Last name -->
              <input type="Number" name="duration" id="Price" class="form-control" placeholder="Expiration Duration" required>
            </div>
          </div>
          

        

          <!-- Sign up button -->
          <button id="but_sub" name="add" class="btn btn-info my-4 btn-block" type="submit" href="#">Add Product</button>

          

        </form>
        
      </div>
       <div class="col-md-3 col-sm-1"> </div>
    </div>
  </div>
        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->
      <?php 
        if(isset($_POST['add'])) {
          $product = new Product();
          $product->addProduct($_POST['name'], $_POST['price'], $_POST['quantity'], $_POST['purchase_date'], $_POST['expiry_date'], $_POST['minimum'], $_POST['duration']);
        }
        



      ?>

<?php include 'footer.php'  ?>