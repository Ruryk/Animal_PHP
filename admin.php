<?php
    if(isset($_COOKIE['db_create_succes']) && trim($_COOKIE['db_create_succes'])!=""){
        if($_COOKIE['db_create_succes']==1){
           $message = "New record created successfully";
        }else if($_COOKIE['db_create_succes']==2){
            echo "Record deleted successfully";
        }
    }
    require_once "check_login.php";
    require_once "core/config.php";
    require_once "core/function.php";
    

    $conn = connect();
    $data = select($conn);
    close($conn);
    
    require_once ('template/header.php');
?>
<div class="container">
    <div class="row">
        <div class="col-lg-12 text-center">
            <?php

                echo "<h2>Admin panel</h2>";
                echo $message;

                echo "<div class='mt-2 mb-2 text-right'><a class='ml-2' href='/admin_create'><button class='btn btn-success'>Add new</button></a></div>";

                $out = "<table class='table table-striped'>";
                $out .= "<tr><th>ID</th><th>Title</th><th>Description Min</th><th>Image</th><th>Update</th><th>Delete</th></tr>";
                for($i =0; $i<count($data);$i++){
                    $out .= "<tr><td>{$data[$i]['id']}</td><td>{$data[$i]['title']}</td><td>{$data[$i]['descr_min']}</td><td><img src='/images/{$data[$i]['image']}' width='80'></td><td><a href='/admin_update/{$data[$i]['id']}'><button class='btn btn-warning update-Article' data='{$data[$i]['id']}' >Update</button></a></td><td><button class='btn btn-danger delete-Article' data='{$data[$i]['id']}' >Delete</button></td></tr>"; 
                }
                $out .= "</table>";
                    
                echo $out;
            ?>
        </div>
    </div>
</div>

<script>
window.onload = function() {
    let delArticle = document.querySelectorAll('.delete-Article');
    delArticle.forEach(elem => {
        elem.addEventListener('click', () => {
            let con = confirm("Delete article?");
            if (con == true) {
                location.href = `/admin_delete.php?id=${elem.getAttribute('data')}`;
            } else {
                return false;
            }
        })
    });
}
</script>

<?php
    require_once ('template/footer.php');
?>