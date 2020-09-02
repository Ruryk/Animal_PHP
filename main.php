<?php
    require_once ('template/header.php');
?>
<div class="jumbotron jumbotron-fluid">
    <div class="container">
        <h1 class="display-4">Мир животных</h1>
        <p class="lead">Узнай больше о нашем удивительном мире</p>
    </div>
</div>
<?php
    require_once "core/config.php";
    require_once "core/function.php";
    $conn = connect();
    $countPage = paginationCount($conn);
    $tag = getAllTags($conn);
    $data = selectMain($conn);
    $cat = getAllCatInfo($conn);
    close($conn);
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
            <div class="col-lg-12">
                <nav class="mt-4">
                    <ul class="pagination d-flex justify-content-center">
                        <?php
                                for($i=0;$i<$countPage;$i++){
                                    echo "<li class='page-item m-1'><a class='page-link' href='/page/{$i}'>".($i+1)."</a></li>";
                                }
                            ?>
                    </ul>
                </nav>
            </div>
            <div class="col-lg-12 text-center">
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