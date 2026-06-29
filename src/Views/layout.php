<?php /** @var string $title */ /** @var string $content */ ?>
<!doctype html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($title ?? '書籍管理') ?></title>
  <style>
    body { font-family: sans-serif; max-width: 880px; margin: 24px auto; padding: 0 16px; color: #222; }
    h1 { font-size: 1.4rem; }
    table { border-collapse: collapse; width: 100%; }
    th, td { border: 1px solid #ddd; padding: 8px 10px; text-align: left; font-size: .9rem; }
    th { background: #f5f5f5; }
    a.btn, button { display: inline-block; padding: 6px 12px; border: 1px solid #2563eb; color: #2563eb; background: #fff; border-radius: 6px; text-decoration: none; cursor: pointer; font-size: .85rem; }
    a.btn-primary { background: #2563eb; color: #fff; }
    .error { color: #c00; font-size: .85rem; }
    .flash { background: #e7f5e7; border: 1px solid #8c8; padding: 8px 12px; border-radius: 6px; }
    .muted { color: #888; }
  </style>
</head>
<body>
  <header style="display:flex;justify-content:space-between;align-items:center;">
    <h1><a href="/" style="text-decoration:none;color:inherit;">📚 書籍管理</a></h1>
    <nav>
      <a class="btn btn-primary" href="/?page=create">+ 新規登録</a>
<?php if (isset($_SESSION['user_id'])): ?>
        <a class="btn" href="/?page=logout" onclick="return confirm('ログアウトしますか？');" style="border-color: #dc3545; color: #dc3545;">ログアウト</a>
      
      <?php else: ?>
        <a class="btn" href="/?page=register">ユーザー登録</a>
        <a class="btn btn-primary" href="/?page=login">ログイン</a>
      
      <?php endif; ?>
    </nav>
  </header>
  <main>
    <?= $content ?>
  </main>
</body>
</html>
