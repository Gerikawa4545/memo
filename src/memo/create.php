<?php

require_once __DIR__ . '/lib/mysqli.php';

function createMemo($link, $memo)
{
    $sql = <<<EOT
INSERT INTO memos (
    name,
    belongs,
    feature
) VALUES (
    "{$memo['name']}",
    "{$memo['belongs']}",
    "{$memo['feature']}"
)
EOT;
    $result = mysqli_query($link, $sql);
    if (!$result) {
        error_log('Error: fail to create memo');
        error_log('Debugging Error: ' . mysqli_error($link));
    }
}

function validate($memo)
{
    $errors = [];

    if (!strlen($memo['name'])) {
        $errors['name'] = '名前を入力してください';
    } elseif (strlen($memo['name']) > 255) {
        $errors['name'] = '名前は255文字以内で入力してください';
    }

    if (!strlen($memo['belongs'])) {
        $errors['belongs'] = '所属を入力してください';
    } elseif (strlen($memo['belongs']) > 255) {
        $errors['belongs'] = '所属は255文字以内で入力してください';
    }

    if (!strlen($memo['feature'])) {
        $errors['feature'] = '特徴を入力してください';
    } elseif (strlen($memo['feature']) > 1000) {
        $errors['feature'] = '特徴は1000文字以内で入力しください';
    }
    return $errors;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $memo = [
        'name' => $_POST['name'],
        'belongs' => $_POST['belongs'],
        'feature' => $_POST['feature']
    ];

    $errors = validate($memo);

    if (!count($errors)) {
        $link = dbConnect();
        createMemo($link, $memo);
        mysqli_close($link);
        header("Location: index.php");
    }
}

include 'views/new.php';
