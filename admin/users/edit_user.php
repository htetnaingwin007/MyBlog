<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

session_start();
    if($_SESSION['user_id'] && $_SESSION['user_role'] == 'admin'){

    include "../layouts/nav_side.php";
    include "../../dbconnect.php";

    $id = $_GET['id'];
    $sql = "SELECT * FROM users WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id',$id);
    $stmt->execute();
    $user = $stmt->fetch();
    // var_dump($user);
    

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $user_id = $_POST['user_id'];
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
        }else {
            $image = $_POST['old_image'];
        }


        // echo "$name <br> $email <br> $password <br> $profile <br> $role";
        
        $sql = "UPDATE users set name=:name,email=:email,password=:password,profile=:profile,role=:role where id=:id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id',$user_id);
        $stmt->bindParam(':name',$name);
        $stmt->bindParam(':email',$email);
        $stmt->bindParam(':password',$password);
        $stmt->bindParam(':profile',$profile);
        $stmt->bindParam(':role',$role);

        $stmt->execute();

        // header("location: users.php");
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
                        <input type="hidden" name="user_id" id="" value="<?= $user['id'] ?>">
                        <div class="mb-3">
                            <label for="name" class="form-label">name</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= $user['name'] ?>">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= $user['email'] ?>">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">password</label>
                            <input type="password" class="form-control" id="password" name="password" value="<?= $user['password'] ?>">
                        </div>
                        
                        <div class="mb-3">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="image-tab" data-bs-toggle="tab" data-bs-target="#image-tab-pane" type="button" role="tab" aria-controls="image-tab-pane" aria-selected="true">Profile</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="new_image-tab" data-bs-toggle="tab" data-bs-target="#new_image-tab-pane" type="button" role="tab" aria-controls="new_image-tab-pane" aria-selected="false">New Profile</button>
                                </li>
                                
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="image-tab-pane" role="tabpanel" aria-labelledby="image-tab" tabindex="0">
                                    <img src="../<?= $user['profile'] ?>" class="w-50 h-50 py-5">
                                    <input type="hidden" name="old_image" value="<?= $user['profile'] ?>">
                                </div>

                                <div class="tab-pane fade" id="new_image-tab-pane" role="tabpanel" aria-labelledby="new_image-tab" tabindex="0">
                                
                                <input type="file" class="form-control my-5" id="profile" name="profile">
                                </div>

                            </div>

                        </div>

                        <div class="col-md-3 mb-3">
                            
                            <select class="form-select" id="validationDefault04" name="role" required>
                                <option value="admin">Admin</option>
                                <option value="author">Author<option>
                            </select>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">UPDATE</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


<?php
    include "../layouts/footer.php";
}else{
    header("location:../login.php");
}
?>