<?php


class Admin extends Pdocon {

    public function __construct(){
        parent::__construct();
        
    }

    public function register($name, $phone, $email, $password) {

        $rawName          =      cleanData($name);
        $rawphone          =      cleanData($phone);
        $rawEmail         =      cleanData($email);
        $rawPassword      =      cleanData($password);

        $cleanName        =      sanitizeStr($rawName);
        $cleanphone        =      sanitizeStr($rawphone);
        $cleanEmail       =      validateEmail($rawEmail);
        $cleanPassword    =      sanitizeStr($rawPassword);

        $hashPass         =      hashPassword($cleanPassword);

        $this->query("SELECT * FROM users WHERE email=:email");
        $this->bindvalue(':email', $cleanEmail, PDO::PARAM_STR);
        $run = $this->fetchSingle();
        if($run){
            keepMsg('<div class="alert alert-danger alert-dismissible text-center mt-5">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Error</strong>  User already exists
                    </div>');
                    redirectPage('register.php');

        }else {
            
                    $this->query("INSERT INTO users (name, phone, email, password) VALUES (:name, :phone, :email, :password)");
                    $this->bindvalue(':name', $cleanName, PDO::PARAM_STR);
                    $this->bindvalue(':phone', $cleanphone, PDO::PARAM_STR);
                    $this->bindvalue(':email', $cleanEmail , PDO::PARAM_STR);
                    $this->bindvalue(':password', $hashPass, PDO::PARAM_STR);
                    if($this->execute()) {
                        $this->query("SELECT * FROM users WHERE email=:email AND password=:password");
                        $this->bindvalue(':email', $cleanEmail, PDO::PARAM_STR);
                        $this->bindvalue(':password', $hashPass, PDO::PARAM_STR);
                        $row = $this->fetchSingle();
                        if ($row) {
                            $name        =    $row['name'];
                            $_SESSION['userdata'] = array(
                                'fullname'      =>   $name,
                                'id'            =>   $row['id']
                            );
                            $_SESSION['admin_is_logged'] = true;
                                keepMsg('<div class="alert alert-success alert-dismissible text-center mt-5">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <strong>Success</strong>  ' . $name . '" you are logged in"
                                    </div>');
                                redirectPage("admin/index.php");

                        } else{
                            keepMsg('<div class="alert alert-danger alert-dismissible text-center mt-5">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>Error</strong>  credentials not in our records
                                </div>'
                        );
                            redirectPage('login.php');
                        }
                    } else{
                            keepMsg('<div class="alert alert-danger alert-dismissible text-center mt-5">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>Error</strong>  registration not successful
                            </div>');
                            redirectPage('register.php');
                    }
                    
        }

    }


        

    

    public function login($email, $password) {
        $rawEmail         =      cleanData($email);
        $rawPassword      =      cleanData($password);

        $cleanEmail       =      validateEmail($rawEmail);
        $cleanPassword    =      sanitizeStr($rawPassword);

        $hashPass         =      hashPassword($cleanPassword);

        $this->query("SELECT * FROM users WHERE email=:email AND password=:password");
        $this->bindvalue(':email', $cleanEmail, PDO::PARAM_STR);
        $this->bindvalue(':password', $hashPass, PDO::PARAM_STR);
        $row = $this->fetchSingle();
        if ($row) {
            $name        =    $row['name'];
            $_SESSION['userdata'] = array(
                'fullname'      =>   $name,
                'id'            =>   $row['id']
            );
            $_SESSION['admin_is_logged'] = true;
                keepMsg('<div class="alert alert-success alert-dismissible text-center mt-5">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Success</strong>  ' . $name . '" you are logged in"
                    </div>');
                redirectPage("admin/index.php");

        } else{
            keepMsg('<div class="alert alert-danger alert-dismissible text-center mt-5">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Error</strong>  credentials not in our records
                </div>'
        );
            redirectPage('login.php');
        }
    }

    public function changePassword($oldpass, $password, $id) {
        $password = hashPassword($password);
        $oldpass = hashPassword($oldpass);
        $this->query("SELECT * FROM users WHERE id=:id");
        $this->bindvalue(':id', $id, PDO::PARAM_INT);
        $row = $this->fetchSingle();

        if($row['password'] == $oldpass) {
            $this->query("UPDATE users SET password=:password WHERE id=:id");
            $this->bindvalue(':password', $password, PDO::PARAM_STR);
            $this->bindvalue(':id', $id, PDO::PARAM_INT);
            if($this->execute()){
                keepMsg('<div class="alert alert-success alert-dismissible text-center mt-5">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Success</strong>  password changed successfully
                </div>');
            }

        }else {
            keepMsg('<div class="alert alert-danger alert-dismissible text-center mt-5">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Error</strong>  old password not correct
                </div>');
        }
        // redirectPage('profile.php');


        

    }

    public function uploadImage($user, $image){
        $errors= array();
        $file_name = $_FILES[$image]['name'];
        $file_size = $_FILES[$image]['size'];
        $file_tmp = $_FILES[$image]['tmp_name'];
        $file_type = $_FILES[$image]['type'];
        $file     =  explode('.', $file_name);
        $text     =  end($file);
        $file_ext = strtolower($text);
        
        $extensions= array("jpeg","jpg","png");
        
        if(in_array($file_ext,$extensions)=== false){
        $errors[0] =      '<div class="alert alert-danger alert-dismissible text-center mt-5">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>Error</strong>  Image extension must be "jpeg", "jpg" or"png"
                            </div>';
        keepMsg($errors[0]);
        }
        
        if($file_size > 2097152) {
        $errors[1]= '<div class="alert alert-danger alert-dismissible text-center mt-5">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Error</strong>  Image size must be 2mb or less
                        </div>';
        keepMsg($errors[1]);
        }
        
        if(empty($errors)==true) {
        move_uploaded_file($file_tmp,"../uploaded_image/".$file_name);
        

            $user = new User();
            $user->query("UPDATE users SET image=:image WHERE id=:id");
            $user->bindvalue(':image', $file_name, PDO::PARAM_STR);
            $user->bindvalue(':id', $user, PDO::PARAM_INT);
            $run = $user->execute();
            if($run) {
                keepMsg('<div class="alert alert-success alert-dismissible text-center mt-5">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Success</strong>  image upload successful
                    </div>');
            }

            redirectPage('profile.php');
    }

}


    public function addAdmin($name,$phone,$email,$password) {
        $rawName          =      cleanData($name);
        $rawphone          =      cleanData($phone);
        $rawEmail         =      cleanData($email);
        $rawPassword      =      cleanData($password);

        $cleanName        =      sanitizeStr($rawName);
        $cleanphone        =      sanitizeStr($rawphone);
        $cleanEmail       =      validateEmail($rawEmail);
        $cleanPassword    =      sanitizeStr($rawPassword);

        $hashPass         =      hashPassword($cleanPassword);

        $this->query("SELECT * FROM users WHERE email=:email");
        $this->bindvalue(':email', $cleanEmail, PDO::PARAM_STR);
        $run = $this->fetchSingle();
        if($run){
            keepMsg('<div class="alert alert-danger alert-dismissible text-center mt-5">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Error</strong>  User already exists
                    </div>');
                    redirectPage('register.php');

        }else {
            
                    $this->query("INSERT INTO users (name, phone, email, password) VALUES (:name, :phone, :email, :password)");
                    $this->bindvalue(':name', $cleanName, PDO::PARAM_STR);
                    $this->bindvalue(':phone', $cleanphone, PDO::PARAM_STR);
                    $this->bindvalue(':email', $cleanEmail , PDO::PARAM_STR);
                    $this->bindvalue(':password', $hashPass, PDO::PARAM_STR);
        
                    if($this->execute()) {
                            keepMsg('<div class="alert alert-success alert-dismissible text-center mt-5">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>Success</strong>  registration successfull
                                </div>');
                            redirectPage("addamin.php.");
                    }
        
                        else{
                            keepMsg('<div class="alert alert-danger alert-dismissible text-center mt-5">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>Error</strong>  registration not successful
                            </div>');
                            redirectPage("addadmin.php");
                        }
                        
                    
        }
    }



}
