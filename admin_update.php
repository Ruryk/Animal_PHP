<?php
    require_once "check_login.php";
    require_once "core/config.php";
    require_once "core/function.php";

    if(isset($_POST['title']) && trim($_POST['title'])!=""){

        $title = trim($_POST['title']);
        $descrMin = trim($_POST['descr-min']);
        $description = trim($_POST['description']);
        $category = trim($_POST['category']);
        $tags = trim($_POST['tag']);
        $tags = explode(",",$tags);
        $newTags =[];
        
        for($i=0;$i<count($tags);$i++){
            if(trim($tags[$i]!="")){
                $newTags[]  = trim($tags[$i]);
            };
        }
        $conn = connect();
        if ($_FILES['image']['name']!='') {
            move_uploaded_file($_FILES['image']['tmp_name'], 'images/'.$_FILES['image']['name']);
            $sql = "UPDATE info set title = '".$title."', descr_min = '".$descrMin."', description = '".$description."', image = '".$_FILES['image']['name']."' WHERE id=".$_GET['id'];
        }
        else {
            $sql = "UPDATE info set title = '".$title."', descr_min = '".$descrMin."', description = '".$description."' WHERE id=".$_GET['id'];
        }

        if (mysqli_query($conn, $sql)) {
            $sql = "DELETE FROM tag WHERE post=".$_GET['id'];
            mysqli_query($conn, $sql);

            for ($i = 0; $i < count($newTags); $i++){
                $sql = "INSERT INTO tag (tag, post) VALUES ('".$newTags[$i]."', ".$_GET['id'].")";
                mysqli_query($conn, $sql);
            }

            setcookie('bd_create_success', 1, time()+10);
            header('Location: /admin');
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
        close($conn);
    }

?>
<?php
    $conn = connect();
    $sql = 'SELECT * FROM info WHERE id='.$_GET['id'];
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $sql = 'SELECT tag FROM tag WHERE post='.$_GET['id'];
    $result = mysqli_query($conn, $sql);
    $t = array();
    while($tag = mysqli_fetch_assoc($result)) {
        $t[] = $tag['tag'];
    }
    close($conn);
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
                    <input type="text" class="form-control" name="title" placeholder="Title" id="title"
                        value="<?php echo $row['title'];?>">
                </div>
                <div class="form-group">
                    <label for="min-description">Min Description:</label>
                    <textarea class="form-control" name="descr-min" placeholder="Min Description"
                        id="descr-min"><?php echo $row['descr_min'];?></textarea>
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea class="form-control" name="description" placeholder="Description" id="description">
                        <?php echo $row['description'];?></textarea>
                </div>
                <div class="form-group">
                    <label for="tags">Category:</label>
                    <input type="text" class="form-control" name="category" placeholder="Category" id="category"
                        value="<?php echo $row['category'];?>">
                </div>
                <div class=" form-group">
                    <label for="tags">Tags:</label>
                    <input type="text" class="form-control" name="tag" placeholder="one,two" id="tag"
                        value="<?php echo join(',',$t);?>">
                </div>
                <div class="form-group">
                    <img src="/images/<?php echo $row['image'];?>" alt="">
                </div>
                <div class=" form-group">
                    <label for="photo">Photo:</label>
                    <input type="file" class="form-control-file" name="image" id="image">
                </div>
                <input type="submit" class="btn btn-success float-right" value='Update article'>
            </form>
        </div>
    </div>
</div>
<?php
    require_once ('template/footer.php');
?>