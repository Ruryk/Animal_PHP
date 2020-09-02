<?php
    require_once "check_login.php";
    require_once "core/config.php";
    require_once "core/function.php";

    if(isset($_POST['title']) && trim($_POST['title'])!=""){

    $title = trim($_POST['title']);
    $descrMin = trim($_POST['descr-min']);
    $description = trim($_POST['description']);
    $category = trim($_POST['category']);
    if($category === "Африка"){
        $category = 3;
    }else if($category === "Австралия"){
        $category = 2;
    }else if($category === "Евразия"){
        $category = 1;
    }else{
        $category = 4;
    }
    $tags = trim($_POST['tag']);
    $tags = explode(",",$tags);
    $newTags =[];
    
    for($i=0;$i<count($tags);$i++){
        if(trim($tags[$i]!="")){
            $newTags[]  = trim($tags[$i]);
        };
    }

    move_uploaded_file($_FILES['image']['tmp_name'], 'images/'.$_FILES['image']['name']);

    $conn = connect();

    $sql = "INSERT INTO info (title, category ,descr_min, description,image) VALUES ('$title','$category', '$descrMin', '$description','".$_FILES['image']['name']."')";

    if (mysqli_query($conn, $sql)) {
        $lastId = mysqli_insert_id($conn);
        for($i;$i<count($newTags);$i++){
            $sql = "INSERT INTO tag (tag, post) VALUES ('$newTags[$i]', '$lastId')";
            mysqli_query($conn, $sql);
        }
        setcookie("db_create_succes",1,time()-10);
        header("Location: /admin");
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    close($conn);
    }

?>
<?php
    require_once ('template/header.php');
?>
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h2 class="text-center m-3">Create Post</h2>
            <form action="" role="form" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="title">Title:</label>
                    <input type="text" class="form-control" name="title" placeholder="Title" id="title">
                </div>
                <div class="form-group">
                    <label for="min-description">Min Description:</label>
                    <textarea class="form-control" name="descr-min" placeholder="Min Description"
                        id="descr-min"></textarea>
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea class="form-control" name="description" placeholder="Description"
                        id="description"></textarea>
                </div>
                <div class="form-group">
                    <label for="сategories">Category:</label>
                    <select class="form-control" name="category" id="category" placeholder="Category">
                        <option>Австралия</option>
                        <option>Африка</option>
                        <option>Евразия</option>
                        <option>Моря и океаны</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="tags">Tags:</label>
                    <input type="text" class="form-control" name="tag" placeholder="one,two" id="tag">
                </div>
                <div class="form-group">
                    <label for="photo">Photo:</label>
                    <input type="file" class="form-control-file" name="image" id="image">
                </div>
                <input type="submit" class="btn btn-success float-right" value='Add new article'>
            </form>
        </div>
    </div>
</div>
<?php
    require_once ('template/footer.php');
?>