<?php

/**
 * ★基礎課題: 新規登録フォームのビュー
 *
 * ここに登録フォームを実装してください。要件は README.md の「基礎課題」を参照。
 * 用意されている変数（BookController::create() から渡す想定）:
 *   $categories : カテゴリ一覧（Category::all() の結果）
 *   $errors     : バリデーションエラーの配列（再表示用、任意）
 *   $old        : 直前の入力値の配列（入力値保持用、任意）
 *
 * ヒント:
 *   - <form method="post" action="/?page=store"> で送信する
 *   - <input name="title">, <textarea>, <select name="category_id"> など
 *   - 値の出力は必ず e(...) でエスケープする（XSS 対策）
 *   - エラーがあれば <p class="error"> で表示する
 */
$title = '新規登録';

/** @var array $categories */
/** @var array $errors */
/** @var array $old */

$errors = $errors ?? [];
$old = $old ?? [];

?>

<h2>新規書籍登録（このページを実装してください）</h2>

<p class="muted">README の「基礎課題」に従って登録フォームを作成してください。</p>
<p><a class="btn" href="/">← 一覧へ戻る</a></p>

<form method="post" action="/?page=store">
    <div>
        <label for="title">タイトル</label>
        <input type="text" id="title" name="title" value="<?= e($old['title'] ?? '') ?>">
        <?php if (!empty($errors['title'])): ?>
            <p class="error" style="color: red;"><?= e($errors['title']) ?></p>
        <?php endif; ?>
    </div>

    <div>
        <label for="author">著者</label>
        <input type="text" id="author" name="author" value="<?= e($old['author'] ?? '') ?>">
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
                $selected = (isset($old['category_id']) && $old['category_id'] == $category['id'])
                    ? 'selected'
                    : '';
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
        <input type="number" id="price" name="price" value="<?= e($old['price'] ?? '') ?>">
        <?php if (!empty($errors['price'])): ?>
            <p class="error" style="color: red;"><?= e($errors['price']) ?></p>
        <?php endif; ?>
    </div>

    <button type="submit" class="btn">登録</button>
</form>