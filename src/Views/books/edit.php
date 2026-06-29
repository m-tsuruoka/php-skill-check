<?php
/**
 * ★応用課題: 編集フォームのビュー
 *
 * 既存の値をフォームに初期表示し、/?page=update へ送信して更新します。
 * 用意されている変数（BookController::edit() から渡す想定）:
 * $book       : 編集対象の書籍（Book::find($id) の結果）
 * $categories : カテゴリ一覧
 * $errors     : バリデーションエラー（任意）
 *
 * ヒント:
 * - <form method="post" action="/?page=update"> に <input type="hidden" name="id" value="...">
 * - 既存値を value= に入れて初期表示（必ず e(...) でエスケープ）
 */
$title = '編集';
/** @var array $book */
/** @var array $categories */
/** @var array $errors */
?>

<h2>書籍の編集</h2>

<p class="muted">README の「応用課題」に従って編集フォームを作成してください。</p>
<p><a class="btn" href="/">← 一覧へ戻る</a></p>

<form method="post" action="/?page=update">
    <input type="hidden" name="id" value="<?= e($book['id']) ?>">

    <div>
        <label for="title">タイトル</label>
        <input type="text" id="title" name="title" value="<?= e($book['title']) ?>">
        <?php if (!empty($errors['title'])): ?>
            <p class="error" style="color: red;"><?= e($errors['title']) ?> </p>
        <?php endif; ?>
    </div>

    <div>
        <label for="author">著者</label>
        <input type="text" id="author" name="author" value="<?= e($book['author']) ?>">
        <?php if (!empty($errors['author'])): ?>
            <p class="error" style="color: red;"><?= e($errors['author']) ?></p>
        <?php endif; ?>
    </div>

    <div>
        <label for="category_id">カテゴリ</label>
        <select id="category_id" name="category_id">
            <option value="">-- カテゴリを選択してください --</option>
            <?php foreach ($categories as $category): ?>
                <?php
                // $book['category_id'] と一致するか判定
                $selected = ($book['category_id'] == $category['id']) ? 'selected' : '';
                ?>
                <option value="<?= e($category['id']) ?>" <?= $selected ?>>
                    <?= e($category['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php if (!empty($errors['category_id'])): ?>
            <p class="error" style="color: red;"><?= e($errors['category_id']) ?></p>
        <?php endif; ?>
    </div>

    <div>
        <label for="price">価格</label>
        <input type="number" id="price" name="price" value="<?= e($book['price']) ?>">
        <?php if (!empty($errors['price'])): ?>
            <p class="error" style="color: red;"><?= e($errors['price']) ?></p>
        <?php endif; ?>
    </div>

    <button type="submit" class="btn">保存</button>
</form>