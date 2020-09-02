<?php
    require_once ('template/header.php');
    require_once "core/config.php";
    require_once "core/function.php";
    $conn = connect();
    $tag = getAllTags($conn);
    $data = getPostFromTag($conn);
    $cat = getAllCatInfo($conn);
?>
<div class="container">
    <div class="row">
        <div class="col-lg-9">
            <div class="row">
                <?php
                    $out = "";
                    for($i =0; $i<count($data);$i++){
                        $out .= "<div class='col-lg-4 col-md-6'>";
                        $out .= "<div class='card'>";
                        $out .= "<img src='/images/{$data[$i]['image']}' class='card-img-top'>";
                        $out .= "<div class='card-body'>";
                        $out .= "<h5 class='card-title'>{$data[$i]['title']}</h5>";
                        $out .= "<p class='card-text'>{$data[$i]['descr_min']}</p>";
                        $out .= '<p class="text-right"><a href="/article/'.$data[$i]['id'].'" class="btn btn-primary">Read more...</a></p>';
                        $out .= "</div>";
                        $out .= "</div>";
                        $out .= "</div>";
                    }
                    close($conn);

                    echo $out;
                ?>
            </div>
        </div>
        <div class="col-lg-3">
            <?php
                    require_once ('template/nav.php');
                ?>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center mt-5">
                <?php
                        for($i=0;$i<count($tag);$i++){
                            echo "<a  class='badge badge-info p-2 m-1' href='/tag/{$tag[$i]}'>{$tag[$i]}</a>";
                        }
                    ?>
            </div>
        </div>
    </div>
</div>
<?php
    require_once ('template/footer.php');
?>