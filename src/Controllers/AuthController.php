<?php

namespace App\Controllers;

use App\Models\User;

class AuthController
{
    
    public function loginForm()
    {
        view('auth/login');
    }

    public function login()
    {
        
        
        // 送信された値の前後の空白（スペース）を取り除く
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $password = isset($_POST['password']) ? trim($_POST['password']) : '';

        // トリムした $email で検索する
        $user = User::findByEmail($email);

        // トリムした $password で照合する
        if (!$user || !password_verify($password, $user['password'])) {
            echo "ログイン失敗";
            return;
        }

        $_SESSION['user_id'] = $user['id'];

        header('Location: /');
        exit;
    }

    public function logout()
    {
        session_destroy();

        header('Location: /?page=index');
        exit;
    }
    public function registerForm()
{
    view('auth/register');
}

public function register()
{
    $email = $_POST['email'];
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    // すでに存在チェック（任意）
    $exists = User::findByEmail($email);
    if ($exists) {
        echo "このメールはすでに登録されています";
        return;
    }

User::create([
        'name' => $_POST['name'],
        'email' => $email,
        'password' => password_hash($password, PASSWORD_DEFAULT), // ← ハッシュ化！
    ]);

    header('Location: /?page=login');
    exit;
}
}