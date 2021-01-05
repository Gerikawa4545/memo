<?php
    /*function validate($reviews)
    {
        $errors = [];

    // 書籍名が正しく入力されているかチェック
    if (!strlen($reviews['title'])) {
        $errors['title'] = '書籍名を入力してください';
    } elseif (strlen($reviews['title']) > 255) {
        $errors['title'] = '書籍名は255文字以内で入力してください';
    }

    // 著者名が正しく入力されているかチェック
    if (!strlen($reviews['author'])) {
        $errors['author'] = '著者名を入力してください';
    } elseif (strlen($reviews['author']) > 100) {
        $errors['author'] = '著者名は100文字以内で入力してください';
    }

    // 読書状況が正しく入力されているかチェック
    if (!in_array($reviews['status'], ['未読', '読んでる', '読了'], true)) {
        $errors['status'] = '読書状況は「未読」「読んでる」「読了」のいずれかを入力してください';
    }

    // 評価が正しく入力されているかチェック
    if ($reviews['score'] < 1 || $reviews['score'] > 5) {
        $errors['score'] = '評価は1〜5の整数を入力してください';
    }

    // 感想が正しく入力されているかチェック
    if (!strlen($reviews['summary'])) {
        $errors['summary'] = '感想を入力してください';
    } elseif (strlen($reviews['summary']) > 1000) {
        $errors['summary'] = '感想は1,000文字以内で入力してください';
    }

        return $errors;
    }

    function createReview($link)
    {
        $reviews = [];

        echo '読書ログを登録してください' . PHP_EOL;
        echo '書籍名:';
        $reviews['title'] = trim(fgets(STDIN));

        echo '著者名:';
        $reviews['author'] = trim(fgets(STDIN));

        echo '読書状況 (未読,読んでる,読了):';
        $reviews['status'] = trim(fgets(STDIN));

        echo '評価 (5点満点の整数):';
        $reviews['score'] = (int)trim(fgets(STDIN));


        echo '感想:';
        $reviews['summary'] = trim(fgets(STDIN));

        $validated = validate($reviews);
        if (count($validated) > 0){
            foreach ($validated as $error) {
                echo $error . PHP_EOL;
            }
            return;
        }

        $sql = <<<EOT

    EOT;

        $results = mysqli_query($link, $sql);
        if ($results) {
            echo '登録が完了しました' . PHP_EOL . PHP_EOL;
        } else {
            echo 'Error: データの追加に失敗しました' . PHP_EOL;
            echo 'Debugging Error: ' .
    mysqli_error($link) . PHP_EOL . PHP_EOL;
        }
    }



    function listReviews($link)
    {
        echo '登録されている読書ログを表示します' . PHP_EOL;

        $sql =
    'SELECT id, title, author, status, score, summary FROM reviews';
        $results = mysqli_query($link, $sql);

        while ($reviews = mysqli_fetch_assoc($results)) {
            echo '書籍名：' . $reviews['title'] . PHP_EOL;
            echo '著者名：' . $reviews['author'] . PHP_EOL;
            echo '読書状況：' . $reviews['status'] . PHP_EOL;
            echo '評価：' . $reviews['score'] . PHP_EOL;
            echo '感想：' . $reviews['summary'] . PHP_EOL;
            echo '----------' . PHP_EOL;
        }

        mysqli_free_result($results);
    }

    function dbConnect()
    {
    $link = mysqli_connect('db', 'book_log', 'pass', 'book_log');
    if (!$link) {
        echo 'Error: データベースに接続できません' . PHP_EOL;
        echo 'Debugging error: ' . mysqli_connect_error() . PHP_EOL;
        exit;
    }

    return $link;
}

//$reviews = [];
$link = dbConnect();

while (true) {
    echo '1. 読書ログを登録' . PHP_EOL;
    echo '2. 読書ログを表示' . PHP_EOL;
    echo '9. アプリケーションを終了' . PHP_EOL;
    echo '番号を選択してください（1,2,9）：';
    $num = trim(fgets(STDIN));

    if ($num === '1') {
        createReview($link);
    } elseif ($num === '2') {
        listReviews($link);
    } elseif ($num === '9') {
        mysqli_close($link);
        break;
    }
}
