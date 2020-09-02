<?php
$route = $_GET['route'];
if ($route == '' || $route == '/') {
    require_once 'main.php';
}
else if ($route == 'admin'){
    require_once 'admin.php';
}
else if ($route == 'admin_create'){
    require_once 'admin_create.php';
}
else if ($route == 'login'){
    require_once 'login.php';
}
else if ($route == 'logout'){
    require_once 'logout.php';
}
else {
    $route = explode("/", $route);
    if ($route[0] == 'admin_update') {
        $_GET['id'] = $route[1];
        require_once 'admin_update.php';
    }
    if ($route[0] == 'cat') {
        $_GET['id'] = $route[1];
        require_once 'category.php';
    }
    if ($route[0] == 'page') {
        $_GET['page'] = $route[1];
        require_once 'main.php';
    }
    if ($route[0] == 'tag') {
        $_GET['tag'] = $route[1];
        require_once 'tag.php';
    }
    else if ($route[0] == 'article'){
        $_GET['id'] = $route[1];
        require_once 'article.php';
    }
}

?>