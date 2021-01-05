<?php

require_once __DIR__ . '/lib/mysqli4.php';

function createReview($link, $review)
{
    $sql = <<<EOT
INSERT INTO reviews (
    title,
    author,
    status,
    score,
    summary
) VALUES (
    "{$review['title']}",
    "{$review['author']}",
    "{$review['status']}",
    "{$review['score']}",
    "{$review['summary']}"
)
EOT;
    $result = mysqli_query($link, $sql);
    if (!$result) {
        error_log('ERROR: fail to create review');
        error_log('Debugging Error: ' . mysqli_error($link)) . PHP_EOL;
    }
}

function validate($review)
{

    $errors = [];

    //タイトル
    if (!strlen($review['title'])) {
        $errors['title'] = 'タイトルを入力してください';
    } elseif (strlen($review['title']) > 100) {
        $errors['title'] = 'タイトルは100文字以内で入力してください';
    }
    //著者名
    if (!strlen($review['author'])) {
        $errors['author'] = 'タイトルを入力してください';
    } elseif (strlen($review['author']) > 100) {
        $errors['author'] = ' 著者名は100文字以内で入力してください';
    }

        //読書状況
        if (!in_array($review['status'], ['未読', '読んでる', '読了'])) {
            $errors['status'] = '読書状況は「未読」「読んでる」「読了」のいずれかを選択してください';
        }

        //評価
        if ($review['score'] < 1 || $review['score'] > 5) {
            $errors['score'] = '評価は1~5の整数を入力してください';
        }

        //感想
        if (!strlen($review['summary'])) {
            $errors['summary'] = 'タイトルを入力してください';
        } elseif (strlen($review['summary']) > 10000) {
            $errors['summary'] = '感想は10000文字以内で入力してください';
        }
        return $errors;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $status = '';
        if (array_key_exists('status', $_POST)) {
            $status = $_POST['status'];
        }

        $review = [
            'title' => $_POST['title'],
            'author' => $_POST['author'],
            'status' => $_POST['status'],
            'score' => $_POST['score'],
            'summary' => $_POST['summary']
        ];

        $errors = validate($review);

        if (!count($errors)) {
            $link = dbConnect();
            createReview($link, $review);
            mysqli_close($link);
            header("Location: index.php");
        }
    }

    include 'views/new.php';
