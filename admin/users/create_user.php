<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();



    include "../layouts/nav_side.php";
    include "../../dbconnect.php";

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $profile_array = $_FILES['profile'];
        $role = $_POST['role'];

        if (isset($profile_array) && $profile_array['size']>0) {
            $dir = '../images/';
            $image_dir = $dir.$profile_array['name']; //../images/eg.jpg ဖိုင်တကယ်သိမ်းမည့်နေတာ
            $profile = 'images/'.$profile_array['name']; // databaseသိမ်းမည့် ပတ်လမ်း
            // echo $profile;
            $tmp_name = $profile_array['tmp_name'];
            move_uploaded_file($tmp_name,$image_dir);
        }


        // echo "$name <br> $email <br> $password <br> $profile <br> $role";
        
        $sql = "INSERT INTO users (name,email,password,profile,role) VALUE(:name,:email,:password,:profile,:role)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':name',$name);
        $stmt->bindParam(':email',$email);
        $stmt->bindParam(':password',$password);
        $stmt->bindParam(':profile',$profile);
        $stmt->bindParam(':role',$role);

        $stmt->execute();

        header("location: users.php");
    }

?>

<div class="container-fluid px-4">
            
            <div class="mt-3">
                <h3 class="mt-4 d-inline">Users</h3>
                <a href="users.php" class="btn btn-danger float-end">Cancel</a>
            </div>
            
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="users.php">Users</a></li>
                <li class="breadcrumb-item active">Users</li>

            </ol>
            
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Create Users
                </div>
                <div class="card-body">
                    <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="name" class="form-label">name</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">email</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">password</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        <div class="mb-3">
                            <label for="profile" class="form-label">profile</label>
                            <input type="file" class="form-control" id="profile" name="profile">
                        </div>

                        <div class="col-md-3 mb-3">
                            
                            <select class="form-select" id="validationDefault04" name="role" required>
                                <option>Admin</option>
                                <option>Author<option>
                            </select>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


<?php
    include "../layouts/footer.php";
?>