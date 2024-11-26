<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
if($_SESSION['user_id']){
    include "../layouts/nav_side.php";
    include "../../dbconnect.php";

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $name = $_POST['name'];
        // echo $category;
        $sql = "INSERT INTO categories (name) VALUE(:name)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':name',$name);
        $stmt->execute();

        header("location: categories.php");
    }

?>

<div class="container-fluid px-4">
            
            <div class="mt-3">
                <h3 class="mt-4 d-inline">Categories</h3>
                <a href="categories.php" class="btn btn-danger float-end">Cancel</a>
            </div>
            
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="categories.php">Categories</a></li>
                <li class="breadcrumb-item active">Categories</li>

            </ol>
            
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Create Categories
                </div>
                <div class="card-body">
                    <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="name" class="form-label">Category</label>
                            <input type="text" class="form-control" id="title" name="name">
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
}else{
    header("location:../login.php");
}
?>