    <h1>メモの一覧</h1>
    <a href="new.php">メモ情報を登録する</a>
    <main>
        <?php foreach ($memos as $memo) : ?>
            <section>
                <h2>
                    <?php echo $memo['name']; ?>
                </h2>
                <div>
                    所属:<?php echo $memo['belongs']; ?>&nbsp;|&nbsp;特徴:<?php echo $memo['feature']; ?>
                </div>
            </section>
        <?php endforeach; ?>
    </main>
