
<?php

//add_comment.php

$connect = new PDO('mysql:host=sql212.epizy.com;dbname=epiz_29873328_XXX ', 'epiz_29873328', 'lHGSSjrPPLT');

$error = '';
$comment_name = '';
$comment_email = '';
$comment_content = '';

if (empty($_POST["comment_email"])) {
    $error .= '<p class="text-danger">Email yra būtinas</p>';
} else {
    $comment_email = $_POST["comment_email"];
    if (!filter_var($comment_email, FILTER_VALIDATE_EMAIL)) {
        $error = '<p class="text-danger">Email netinkamai įvestas</p>';
    }
}

if (empty($_POST["comment_name"])) {
    $error .= '<p class="text-danger">Vardas privalomas</p>';
} else {
    $comment_name = $_POST["comment_name"];
}

if (empty($_POST["comment_content"])) {
    $error .= '<p class="text-danger">Komentaras privalomas</p>';
} else {
    $comment_content = $_POST["comment_content"];
}

if ($error == '') {
    $query = "
 INSERT INTO tbl_comment 
 (parent_comment_id, comment, comment_sender_name) 
 VALUES (:parent_comment_id, :comment, :comment_sender_name)
 ";
    $statement = $connect->prepare($query);
    $statement->execute(
        array(
            ':parent_comment_id' => $_POST["comment_id"],
            ':comment'    => $comment_content,
            ':comment_sender_name' => $comment_name
        )
    );
    $error = '<label class="text-success">Komentaras pridėtas</label>';
}

$data = array(
    'error'  => $error
);

echo json_encode($data);

?>
