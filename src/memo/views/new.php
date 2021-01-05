        <h1 class="h2 text-dark mt-4 mb-4">メモの作成</h1>
        <form action="create.php" method="POST">
            <?php if (count($errors)) : ?>
                <ul class="text-danger">
                    <?php foreach ($errors as $error) : ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            <div class="form-group">
                <label for="name">名前</label>
                <input type="text" id="name" name="name" class="form-control" value="<?php echo $memo['name'] ?>">
            </div>
            <div class="form-group">
                <label for="belongs">所属</label>
                <input type="text" id="belongs" name="belongs" class="form-control" value="<?php echo $memo['belongs'] ?>">
            </div>
            <div class="form-group">
                <label for="feature">特徴</label>
                <textarea type="text" name="feature" id="feature" rows="10" class="form-control"><?php echo $memo['feature'] ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">登録する</button>
        </form>
