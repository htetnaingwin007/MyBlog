<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if($_SESSION['user_id']){
    include "../layouts/nav_side.php";
    include "../../dbconnect.php";

    $sql = "SELECT * FROM categories";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $categories = $stmt->fetchAll();

    $id = $_GET['id'];
    $sql = "SELECT * FROM posts WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id',$id);
    $stmt->execute();
    $post = $stmt->fetch();
    // var_dump($post);


    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $post_id = $_POST['post_id'];
        $title = $_POST['title'];
        $category_id = $_POST ['category_id'];
        $description = $_POST ['description'];
        $user_id = $_SESSION['user_id'];
        $image_array = $_FILES['image'];
        if (isset($image_array) && $image_array['size']>0) {
            $dir = '../images/';
            $image_dir = $dir.$image_array['name']; //../images/eg.jpg ဖိုင်တကယ်သိမ်းမည့်နေတာ
            $image = 'images/'.$image_array['name']; // databaseသိမ်းမည့် ပတ်လမ်း
            // echo $image;
            $tmp_name = $image_array['tmp_name'];
            move_uploaded_file($tmp_name,$image_dir);
        }else {
            $image = $_POST['old_image'];
        }
        
        // echo "$title <br> $category_id <br> $description";
        $sql = "UPDATE posts SET title=:title, image=:image, description=:description, category_id=:category_id, user_id=:user_id WHERE id=:id";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id',$post_id);
        $stmt->bindParam(':title',$title);
        $stmt->bindParam(':image',$image);
        $stmt->bindParam(':description',$description);
        $stmt->bindParam(':category_id',$category_id);
        $stmt->bindParam(':user_id',$user_id);
        $stmt->execute();
        
        header("location: posts.php");
    }

?>
        <div class="container-fluid px-4">
            
            <div class="mt-3">
                <h3 class="mt-4 d-inline">Posts</h3>
                <a href="posts.php" class="btn btn-danger float-end">Cancel</a>
            </div>
            
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="posts.php">Posts</a></li>
                <li class="breadcrumb-item active">Edit Post</li>

            </ol>
            
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Edit Posts
                </div>
                <div class="card-body">
                    <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="post_id" id="" value="<?= $post['id'] ?>">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" value="<?= $post['title'] ?>">
                        </div>
                        <div class="mb-3">
                            <label for="category_id">Categories</label>
                            <select class="form-select" id="category_id" name="category_id" aria-label="Default select example">
                                <option selected>Choose....</option>
                                <?php 
                                    foreach($categories as $category){ 
                                ?>
                                    <option value="<?= $category['id'] ?>" <?php if($post['category_id'] == $category['id']){
                                        echo"selected";
                                    } ?>  ><?= $category['name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="image-tab" data-bs-toggle="tab" data-bs-target="#image-tab-pane" type="button" role="tab" aria-controls="image-tab-pane" aria-selected="true">Image</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="new_image-tab" data-bs-toggle="tab" data-bs-target="#new_image-tab-pane" type="button" role="tab" aria-controls="new_image-tab-pane" aria-selected="false">New Image</button>
                                </li>
                                
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="image-tab-pane" role="tabpanel" aria-labelledby="image-tab" tabindex="0">
                                    <img src="../<?= $post['image'] ?>" class="w-50 h-50 py-5">
                                    <input type="hidden" name="old_image" value="<?= $post['image'] ?>">
                                </div>

                                <div class="tab-pane fade" id="new_image-tab-pane" role="tabpanel" aria-labelledby="new_image-tab" tabindex="0">
                                <input type="file" class="form-control my-5" id="image" name="image">
                                </div>

                            </div>

                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" class="form-control" id="description"><?= $post['description'] ?></textarea>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Update</button>
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