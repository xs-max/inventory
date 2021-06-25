<?php include 'header.php' ?>
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
        <form class="text-center border border-light p-5" id="form" method="post" action="addadmin.php">

          <p class="h4 mb-4">Add New Admin</p>

          <div class="form-row mb-4">
            <div class="col">
              <!-- First name -->
              <input type="text" name="name" id="Name" class="form-control" placeholder=" name" required>
            </div>
            <div class="col">
              <!-- Last name -->
              <input type="text" name="phone" id="Phone" class="form-control" placeholder="Phone number" required>
            </div>
          </div>

          <!-- E-mail -->
          <input type="email" name="email" id="Email" class="form-control mb-4" placeholder="E-mail"  required>

          <!-- Password -->
          <input type="password" name="password" id="Password" class="form-control" placeholder="Password" aria-describedby="defaultRegisterFormPasswordHelpBlock" required>
          

        

          <!-- Sign up button -->
          <button id="but_sub" name="add_admin" class="btn btn-info my-4 btn-block" type="submit" href="#">Add Admin</button>

          

        </form>
        
      </div>
       <div class="col-md-3 col-sm-1"> </div>
    </div>
  </div>

        </div>
        <!-- /.container-fluid -->
      <?php
        if(isset($_POST['add_admin'])) {
          $user = new Admin();
          $user->addAdmin($_POST['name'], $_POST['phone'], $_POST['email'], $_POST['password']);
        }

      ?>
      </div>
      <!-- End of Main Content -->

<?php include 'footer.php'  ?>