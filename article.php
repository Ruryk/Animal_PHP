<?php
    require_once ('template/header.php');
    require_once "core/config.php";
    require_once "core/function.php";

    $conn = connect();
    $data = selectArticle($conn);
    $tag = getArticleTags($conn);
    $cat = getAllCatInfo($conn);
    close($conn);
?>
<div class="container ">
    <div class="row">
        <div class="col-lg-9">
            <div class="row">
                <div class="col-lg-12">
                    <?php
                       $out = "";
                       $out .= "<h1 class='text-center'>{$data['title']}</h1>";
                       $out .= "<img class='img-fluid rounded mx-auto d-block mt-5 mb-5' src='/images/{$data['image']}'>";
                       $out .= "<div>{$data['descr_min']}</div>";
                       $out .= "<div>{$data['description']}</div>";
                       $out .= "<hr>";
                       echo $out;
                    ?>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <?php
                require_once ('template/nav.php');
            ?>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-lg-12 text-center">
            <?php
                        for($i=0;$i<count($tag);$i++){
                            echo "<a  class='badge badge-info p-2 m-1' href='/tag/{$tag[$i]}'>{$tag[$i]}</a>";
                        }
                    ?>
        </div>
    </div>
</div>
<?php
    require_once ('template/footer.php');
?>