<?php

/** @var array $books */ ?>
<?php $title = '書籍一覧'; ?>

<?php if (!empty($_GET['created'])): ?>
  <p class="flash">書籍を登録しました。</p>
<?php endif; ?>

<h2>書籍一覧（<?= count($books) ?> 件）</h2>

<table>
  <thead>
    <tr>
      <th>ID</th>
      <th>タイトル</th>
      <th>著者</th>
      <th>カテゴリ</th>
      <th>価格</th>
      <th>操作</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($books as $book): ?>
      <tr>
        <td><?= e($book['id']) ?></td>
        <td><?= e($book['title']) ?></td>
        <td><?= e($book['author']) ?></td>
        <td><?= e($book['category_name']) ?></td>
        <td>¥<?= number_format((int) $book['price']) ?></td>
        <td>
          <!--           
            ★応用課題: 編集・削除を実装したら、下記を有効化してください。
            （edit()/update()/delete() を実装する前に置くと操作後に白画面になるため、
              最初はコメントアウトしています。実装後にこのコメントを外して使ってください） -->

          <a class="btn" href="/?page=edit&id={id}">編集</a>
          <form method="post" action="/?page=delete" style="display:inline"
            onsubmit="return confirm('削除しますか？');">
            <input type="hidden" name="id" value="<?= e($book['id']) ?>">
            <button type="submit">削除</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<p class="muted">※ この一覧は実装済みの見本です。新規登録・編集・削除を課題で実装してください。</p>