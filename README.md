# PHP スキルチェック課題 📚 書籍管理アプリ

素の PHP（フレームワークなし）で、**書籍管理アプリ**を作りながらこれまでの学習内容を確認するスキルチェックです。
`公開コース` で学んだ範囲（PHP 構文・オブジェクト指向・簡易 MVC・フォーム処理・PDO での CRUD・SQL）で解けるように作られています。

- **想定時間**: 約 3〜4 時間（半日）
- **採点**: 各課題末尾の「✅ 自己採点チェックリスト」と「動作確認」で自分で確認します
- **進め方**: 課題ごとにブランチを切って実装 → Pull Request（PR の説明に画面スクショや確認結果を貼る）

---

## 1. 環境構築（最小手順）

PHP 8.3 以上が入っていれば、追加インストールは不要です（DB は SQLite。初回アクセス時に自動作成＆サンプルデータ投入）。
※ Laravel トラック（laravel-skill-check）と同じ PHP 8.3 系で動作確認しています。

```bash
# このリポジトリのルートで
php -S localhost:8000 -t public
```

ブラウザで <http://localhost:8000> を開き、**書籍一覧（16 件）** が表示されれば準備完了です。

> SQLite の DB ファイルは `database/app.sqlite` に自動生成されます。データを初期状態に戻したいときは、このファイルを削除して再アクセスしてください（`schema.sql` から作り直されます）。

### ディレクトリ構成

```
php-skill-check/
├── public/index.php          ← フロントコントローラ（簡易ルータ）
├── bootstrap.php             ← オートローダ・共通ヘルパー（view(), e()）
├── config/db.php             ← PDO(SQLite) 接続＋初期化
├── schema.sql                ← テーブル定義＋サンプルデータ
├── src/
│   ├── Models/Book.php       ← 書籍モデル（all() は実装済み。find/create/update/delete を実装）
│   ├── Models/Category.php   ← カテゴリモデル（実装済み）
│   ├── Controllers/BookController.php ← index() は実装済み。他を実装
│   └── Views/                ← layout.php / books/index.php は実装済み。create/edit を実装
├── SQL.md                    ← SQL 課題
└── README.md
```

`view('books/index', ['books' => $books])` のように、コントローラから View にデータを渡します。
出力は必ず `e($value)`（`htmlspecialchars` のラッパー）でエスケープしてください。

---

## 2. 基礎課題 ⭐ — 書籍登録フォーム（フォーム処理・バリデーション）

`/?page=create` の登録フォームと `/?page=store` の登録処理を実装します（この時点では DB 保存はダミーでも可、`Book::create()` を呼べれば尚良し）。

**要件**
- フォーム項目: タイトル（title）・著者（author）・カテゴリ（category_id：`Category::all()` を `<select>` で）・価格（price）
- バリデーション:
  - タイトル・著者・カテゴリ・価格は**必須**
  - タイトルは **100 文字以内**、価格は**数値（0 以上）**
- エラー時はフォームに**エラーメッセージを表示**し、**入力値を保持**する
- 出力は `e()` でエスケープ（XSS 対策）
- 登録成功後は一覧へ**リダイレクト**（PRG パターン: `header('Location: /?page=index&created=1'); exit;`）

**ヒント**
- `BookController::create()` で `Category::all()` を取得し `view('books/create', [...])`
- `BookController::store()` で `$_POST` を `trim()` → バリデーション → エラーなら `create` に戻す
- 入力値・エラーの受け渡しはセッションでも `$_GET`（`http_build_query()`）でも可（セッションは発展課題で本格的に扱います）

**✅ 自己採点チェックリスト**
- [x] 空のまま送信すると、各項目のエラーが表示される
- [x] エラー時に、入力済みの値がフォームに残っている
- [x] `<` や `"` を含む入力をしても画面が壊れない（エスケープできている）
- [x] 正常に送信すると一覧へ戻り、「登録しました」と表示される

**動作確認**: ブラウザで `/?page=create` を開き、空送信・不正値・正常値の 3 パターンを試す。

---

## 3. 応用課題 ⭐⭐ — 書籍 CRUD を MVC + PDO で完成させる

`Book` モデルの `find()` / `create()` / `update()` / `delete()`、および `BookController` の `edit()` / `update()` / `delete()` を実装し、**一覧・登録・編集・削除**が一通り動く状態にします。

**要件**
- 登録（Create）: 基礎課題のフォームから実際に DB へ INSERT する
- 編集（Update）: `/?page=edit&id=◯` で既存値をフォームに表示 →`/?page=update` で UPDATE
- 削除（Delete）: 一覧の「削除」から該当書籍を DELETE（削除後は一覧へリダイレクト）
- すべて **PDO の prepare()/execute()**（プレースホルダ）で SQL インジェクションを防ぐ
- Model（DB 処理）・Controller（振り分け）・View（表示）の**責務分離**を保つ

**ヒント**
- `find()`: `SELECT * FROM books WHERE id = ?` を `prepare()`→`execute([$id])`→`fetch()`
- `create()`: `INSERT INTO books (title, author, category_id, price, published_at) VALUES (?,?,?,?,?)`
- `update()`: `UPDATE books SET ... WHERE id = ?`
- `delete()`: `DELETE FROM books WHERE id = ?`
- ID は `ctype_digit()` で数値チェックしてから使う

**✅ 自己採点チェックリスト**
- [x] 登録した書籍が一覧に表示される
- [x] 編集フォームに既存の値が初期表示され、更新が反映される
- [x] 削除すると一覧から消える
- [x] SQL はすべて prepare()/execute() を使っている（文字列連結で値を埋め込んでいない）
- [x] DB 処理は Model、振り分けは Controller、表示は View に分かれている

**動作確認**: 登録→一覧確認→編集→削除 の一連を画面で実施。`sqlite3 database/app.sqlite "SELECT * FROM books;"` でも確認できる。

> SQL の練習問題は **[SQL.md](./SQL.md)** にあります（応用課題と並行して解いてください）。

---

## 4. 発展課題 ⭐⭐⭐ — OOP 設計 ＋ セッションで簡易ログイン

> これは CRUD/フォームの「一歩先」の挑戦です。余裕がある人向け。ヒントを参考に調べながら進めてください。

### 4-1. OOP で設計を改善する（どちらか一方でOK）
- **(a) バリデータを抽象化**: バリデーションルールを `interface Validator`（例: `validate(array $input): array`）として定義し、`RequiredValidator` / `MaxLengthValidator` などの実装クラスに分ける。`BookController::store()` から使う。
- **(b) Model を継承で整理**: 共通の DB 操作を持つ `abstract class Model`（`protected static function table()` など）を作り、`Book` / `Category` がそれを継承する。

### 4-2. セッションを使った簡易ログイン
- `users` テーブルは用意済み（最初は空）。次を実装する:
  - **登録**: メール・パスワードでユーザー作成（パスワードは `password_hash($pw, PASSWORD_DEFAULT)` で保存）
  - **ログイン**: `password_verify()` で照合し、成功したら `$_SESSION['user_id']` を保存
  - **アクセス制限**: 「登録・編集・削除」ページは**未ログインなら**ログイン画面へリダイレクト
  - **ログアウト**: セッションを破棄（`session_destroy()`）

**ヒント**
- 各エントリポイントの先頭で `session_start()` を呼ぶ（`bootstrap.php` に置いてもよい）
- ログイン状態の判定は `isset($_SESSION['user_id'])`
- パスワードは**絶対に平文で保存しない**（`password_hash` / `password_verify`）

**✅ 自己採点チェックリスト**
- [ ] (OOP) バリデータ or Model がクラス/インターフェース/抽象クラスで設計されている
- [ ] パスワードがハッシュ化されて保存されている（DB を見ても平文でない）
- [ ] 未ログインで `/?page=create` 等にアクセスするとログイン画面に飛ぶ
- [ ] ログイン→登録→ログアウトの一連が動く

---

## 5. 追加課題（早く終わった人向け）

- **A. SQL 強化**: [SQL.md](./SQL.md) の「発展」（サブクエリ・ビュー・複数 JOIN 集計）を解く
- **B. 削除を安全に**: 削除を **POST** に変え、確認（JS の `confirm()` か確認画面）を挟む
- **C. レビュー表示**: 書籍詳細ページ（`/?page=show&id=◯`）を作り、`reviews` を一覧表示＋平均評価を計算
- **D. リファクタ**: バリデーションや DB 取得の重複を共通化し、読みやすく整理する

---

## 6. 提出方法

1. 課題ごとに作業ブランチを作成（例: `git switch -c kadai/basic`）
2. 実装してコミット
3. Pull Request を作成し、説明欄に **動作画面のスクショ** と **自己採点チェックリストの結果** を貼る

---

## 7. 出題範囲について

この課題は **学習済みの範囲だけ**で解けます（PHP 構文／クラス・継承・インターフェース・抽象クラス／namespace・オートロード／PDO での CRUD／フォーム処理・バリデーション／SQL）。
フレームワーク（Laravel 等）や REST API は使いません。発展課題のセッション・ログインのみ、学習内容の一歩先の挑戦です（ヒント付き）。
