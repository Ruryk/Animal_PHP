<?php 
    $out = "<div class='list-group'>";
    for($i = 0; $i<count($cat);$i++){
        $out .= '<a href="/cat/'.$cat[$i]['id'].'" class="list-group-item list-group-item-action">'.$cat[$i]['description'].'</a>';
    }
    $out .= "</div>";
    echo $out;
?>