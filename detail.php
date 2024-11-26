<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
    include "layouts/navbar.php";
    include "dbconnect.php";

    $post_id = $_GET ['id'];
    // echo $post_id;
    // $sql = "SELECT * FROM posts WHERE id = :postID";
    $sql = "SELECT posts.*,categories.name as category_name,users.name as user_name FROM posts INNER JOIN categories ON posts.category_id = categories.id INNER JOIN users ON posts.user_id = users.id WHERE posts.id = :postID";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':postID',$post_id);
    $stmt->execute();
    $post = $stmt->fetch();
    // var_dump($post);
    
?>
        <!-- Page content-->
        <div class="container mt-5">
            <div class="row">
                <div class="col-lg-8">
                    <!-- Post content-->
                    <article>
                        <!-- Post header-->
                        <header class="mb-4">
                            <!-- Post title-->
                            <h1 class="fw-bolder mb-1"><?= $post['title'] ?></h1>
                            <!-- Post meta content-->
                            <div class="text-muted fst-italic mb-2">Posted on <?= date('F d, Y',strtotime($post['create_at'])) ?> by <?= $post['user_name'] ?></div>
                            <!-- Post categories-->
                            <a class="badge bg-secondary text-decoration-none link-light" href="index.php?category_id=<?= $post['category_id'] ?>"><?= $post['category_name'] ?></a>
     
                        </header>
                        <!-- Preview image figure-->
                        <figure class="mb-4"><img class="img-fluid rounded" src="admin/<?= $post['image'] ?>" alt="..." /></figure>
                        <!-- Post content-->
                        <section class="mb-5">
                            <p> <?= $post['description'] ?> </p>
                        </section>
                    </article>
                    
                </div>


<?php
    include "layouts/footer.php"
?>