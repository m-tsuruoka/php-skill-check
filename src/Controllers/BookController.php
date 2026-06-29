<?php

namespace App\Controllers;

use App\Models\Book;
use App\Models\Category;

/**
 * 書籍コントローラ。リクエストを受けて Model を呼び、View を描画します。
 * index() は実装済みの見本です。残りのメソッドを課題で実装してください。
 */
class BookController
{
    /** 一覧表示（実装済みの見本） */
     public function index(): void
    {
        $books = Book::all();
        view('books/index', ['books' => $books]);
    }

    /**
     * ★基礎課題: 新規登録フォームの表示
     * ヒント: Category::all() を取得して view('books/create', [...]) を描画する。
     *        バリデーションエラーや入力値を ?page=store からのリダイレクトで
     *        受け取り、フォームに再表示できるようにする（$_GET 経由など）。
     */
    public function create(): void
    {
        // TODO: ここを実装する（下の仮表示を本実装に置き換える）
        //   $categories = Category::all();
        //   view('books/create', ['categories' => $categories, 'errors' => [], 'old' => []]);る）
        // データベースからすべてのカテゴリを取得
        $categories = Category::all();
        $errors = $_GET['errors'] ?? [];
        $old = $_GET['old'] ?? [];

        // ビューにカテゴリデータ、およびビューの初期化に必要な空のデータを渡して表示
        view('books/create', [
            'categories' => $categories,
            'errors' => $errors,
            'old' => $old,
        ]);
    }

    /**
     * ★基礎/応用課題: 登録処理（POST）
     * ヒント:
     *   - $_POST から値を受け取り trim()
     *   - 必須・文字数などをバリデーション（エラーは配列に貯める）
     *   - エラーがあれば create に戻す（PRG パターン: header('Location: ...'); exit;）
     *   - OK なら Book::create() して一覧へリダイレクト
     */
    public function store(): void
    {
        $title = isset($_POST['title']) ? trim($_POST['title']) : '';
        $author = isset($_POST['author']) ? trim($_POST['author']) : '';
        $category_id = isset($_POST['category_id']) ? trim($_POST['category_id']) : '';
        $price = isset($_POST['price']) ? trim($_POST['price']) : '';
        $errors = [];

        if ($title == '') {
            $errors['title'] = 'タイトルは必須です';
        } elseif (mb_strlen($title) > 100) {
            $errors['title'] = 'タイトルは100字以内で入力してください';
        }
        if ($author === '') {
            $errors['author'] = '著者は必須です。';
        }

        if ($category_id === '') {
            $errors['category_id'] = 'カテゴリは必須です。';
        }

        if ($price === '') {
            $errors['price'] = '価格は必須です。';
        } elseif (!is_numeric($price) || (int)$price < 0) {
            $errors['price'] = '価格は0以上の数値で入力してください。';
        }

        if (!empty($errors)) {
            $query = http_build_query([
                'errors' => $errors,
                'old' => [
                    'title' => $title,
                    'author' => $author,
                    'category_id' => $category_id,
                    'price' => $price,
                    'errors' => $errors
                ]
            ]);
            header('Location: /?page=create&' . $query);
            exit;
        }
        Book::create([
            'title'       => $title,
            'author'      => $author,
            'category_id' => $category_id,
            'price'       => $price,
        ]);

        header('Location: /?page=index&created=1');
        exit;
    }

    /** ★応用課題: 編集フォームの表示（?page=edit&id=...） */
    public function edit(): void
    {
        // TODO: ここを実装する（下の仮表示を本実装に置き換える）
        //   $book = Book::find($_GET['id'] ?? null);
        //   view('books/edit', ['book' => $book, 'categories' => Category::all(), 'errors' => []]);
        view('books/edit'); // 仮表示（実装前の白画面防止。実装時に上記へ置き換える）
    }

    /** ★応用課題: 更新処理（POST） */
    public function update(): void
    {
        // TODO: ここを実装する
    }

    /** ★応用課題: 削除処理 */
    public function delete(): void
    {
        // TODO: ここを実装する
    }
}
