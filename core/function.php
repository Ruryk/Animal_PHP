<?php 
function connect(){
    $conn = mysqli_connect(SERVERNAME, USERNAME, PASSWORD, DBNAME);
    mysqli_set_charset($conn, "utf8");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    return $conn;
};

function select($conn){
    $sql = "SELECT * FROM info";
    $result = mysqli_query($conn, $sql);

    $arr = array();

    if (mysqli_num_rows($result) > 0) {            
    while($row = mysqli_fetch_assoc($result)) {
        $arr[] = $row;
        }
    }
    return $arr;
};

function selectMain($conn){
    if(isset($_GET['page']) && trim($_GET['page'])!=""){
        $offset = trim($_GET['page']);
    }
    $sql = "SELECT * FROM info ORDER BY id DESC LIMIT 3 OFFSET ".($offset*3);
    $result = mysqli_query($conn, $sql);

    $arr = array();

    if (mysqli_num_rows($result) > 0) {            
    while($row = mysqli_fetch_assoc($result)) {
        $arr[] = $row;
        }
    }
    return $arr;
};

function selectArticle($conn){
    if(isset($_GET['id']) && trim($_GET['id'])!=""){
        $id = trim($_GET['id']);
    };
    $sql = "SELECT * FROM info WHERE id={$id}";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {    
        $row = mysqli_fetch_assoc($result);    
        return $row;    
    }
    return false;
};

function paginationCount($conn){
    $sql = "SELECT * FROM info";
    $result = mysqli_query($conn, $sql);
    $row_cnt = mysqli_num_rows($result);
    return ceil($row_cnt/3);
}

function close($conn){
    mysqli_close($conn);
};

function getAllTags($conn){
    $sql = "SELECT DISTINCT(tag) FROM tag";
    $result = mysqli_query($conn, $sql);

    $arr = array();

    if (mysqli_num_rows($result) > 0) {            
    while($row = mysqli_fetch_assoc($result)) {
        $arr[] = $row['tag'];
        }
    }
    return $arr;
}

function getPostFromTag($conn){
    $sql = "SELECT post FROM tag WHERE tag='{$_GET['tag']}'";
    $result = mysqli_query($conn, $sql);

    $arr = array();

    if (mysqli_num_rows($result) > 0) {            
    while($row = mysqli_fetch_assoc($result)) {
        $arr[] = $row['post'];
        }
    }

    $sql = "SELECT * FROM info WHERE id in (".(join(",",$arr)).")";
    $result = mysqli_query($conn, $sql);

    $arr = array();

    if (mysqli_num_rows($result) > 0) {            
    while($row = mysqli_fetch_assoc($result)) {
        $arr[] = $row;
        }
    }
    return $arr;
}

function getPostFromCategory($conn){
    $sql = "SELECT * FROM info WHERE category=".$_GET['id'];
    $result = mysqli_query($conn, $sql);

    $arr = array();

    if (mysqli_num_rows($result) > 0) {            
    while($row = mysqli_fetch_assoc($result)) {
        $arr[] = $row;
        }
    }
    return $arr;
}

function getCatInfo($conn){
    $sql = "SELECT * FROM category WHERE id='{$_GET['id']}'";
    $result = mysqli_query($conn, $sql);

    $arr = array();

    if (mysqli_num_rows($result) > 0) {            
    $row = mysqli_fetch_assoc($result);
    }
    return $row;
}

function getAllCatInfo($conn){
    $sql = "SELECT * FROM category";
    $result = mysqli_query($conn, $sql);

    $arr = array();

    if (mysqli_num_rows($result) > 0) {            
        while($row = mysqli_fetch_assoc($result)) {
            $arr[] = $row;
        }
    }
    return $arr;
}

function getArticleTags($conn){
    if(isset($_GET['id']) && trim($_GET['id'])!=""){
        $id = trim($_GET['id']);
    };
    $sql = "SELECT * FROM tag WHERE post=$id";
    $result = mysqli_query($conn, $sql);
    
    $arr = array();
    
    if (mysqli_num_rows($result) > 0) {            
    while($row = mysqli_fetch_assoc($result)) {
        $arr[] = $row['tag'];
        }
    }
    return $arr;
}

function deleteArticle($id){
    if(isset($_GET['id']) && trim($_GET['id'])!=""){
        $id = trim($_GET['id']);

        $conn = connect();

        $sql = "DELETE FROM info WHERE id=$id";
    
        if ($conn->query($sql) === TRUE) {
            $sql = "DELETE FROM tag WHERE post=$id";
            mysqli_query($conn, $sql);
            setcookie("db_create_succes",2,time()-10);
            header("Location: /admin");
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    
        close($conn);
        }
}