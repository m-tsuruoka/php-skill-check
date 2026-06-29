<?php

require_once __DIR__ . '/../bootstrap.php';
// ※もし requireLogin() 関数が bootstrap.php 以外（authservice.phpなど）に書かれている場合は、
// そのファイルをここで require_once で読み込んでください。

/**
 * フロントコントローラ（簡易ルータ）
 */

$page = $_GET['page'] ?? 'index';

// コントローラ生成
$bookController = new \App\Controllers\BookController();
$authController = new \App\Controllers\AuthController();

// ==========================================
// 【追加】アクセス制限（未ログイン時のブロック）
// ==========================================
// ログインが必要なページ（ルーティング名）のリスト
$requireLoginPages = ['create', 'store', 'edit', 'update', 'delete'];

// 現在のページがリストに含まれている場合は、ログイン状態をチェックする
if (in_array($page, $requireLoginPages)) {
    requireLogin(); // 未ログインならログイン画面へリダイレクト（弾かれる）
}
// ==========================================

// ルーティング
switch ($page) {

    case 'login':
        $authController->loginForm();
        break;

    case 'login_post':
        $authController->login();
        break;

    case 'logout':
        $authController->logout();
        break;

    case 'index':
        $bookController->index();
        break;

    case 'create':
        $bookController->create();
        break;

    case 'store':
        $bookController->store();
        break;

    case 'edit':
        $bookController->edit();
        break;

    case 'update':
        $bookController->update();
        break;

    case 'delete':
        $bookController->delete();
        break;

    case 'register':
        $authController->registerForm();
        break;

    case 'register_post':
        $authController->register();
        break;

    default:
        $bookController->index();
        break;
}