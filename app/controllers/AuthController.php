<?php

require_once APP_PATH . '/models/UserModel.php';

class AuthController extends Controller
{
    private UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function loginForm(): void
    {
        if ($this->isLoggedIn()) {
            $this->redirect('/notas');
        }
        $flash = $this->getFlash();
        $this->view('auth/login', compact('flash'));
    }

    public function login(): void
    {
        $email    = $this->sanitize($this->post('email', ''));
        $password = $this->post('password', '');

        if (empty($email) || empty($password)) {
            $this->flash('danger', 'Preencha todos os campos.');
            $this->redirect('/login');
            return;
        }

        $user = $this->userModel->findByEmail($email);

        if (!$user || !$this->userModel->verifyPassword($password, $user->password)) {
            $this->flash('danger', 'E-mail ou senha incorretos.');
            $this->redirect('/login');
            return;
        }

        $_SESSION['user_id'] = $user->id;
        $_SESSION['user']    = [
            'id'     => $user->id,
            'name'   => $user->name,
            'email'  => $user->email,
            'plan'   => $user->plan,
            'avatar' => $user->avatar,
        ];

        $this->redirect('/notas');
    }

    public function registerForm(): void
    {
        if ($this->isLoggedIn()) {
            $this->redirect('/notas');
        }
        $flash = $this->getFlash();
        $this->view('auth/register', compact('flash'));
    }

    public function register(): void
    {
        $name     = $this->sanitize($this->post('name', ''));
        $email    = $this->sanitize($this->post('email', ''));
        $password = $this->post('password', '');
        $confirm  = $this->post('password_confirmation', '');

        if (empty($name) || empty($email) || empty($password)) {
            $this->flash('danger', 'Preencha todos os campos.');
            $this->redirect('/register');
            return;
        }

        if ($password !== $confirm) {
            $this->flash('danger', 'As senhas não coincidem.');
            $this->redirect('/register');
            return;
        }

        if (strlen($password) < 6) {
            $this->flash('danger', 'A senha deve ter no mínimo 6 caracteres.');
            $this->redirect('/register');
            return;
        }

        if ($this->userModel->emailExists($email)) {
            $this->flash('danger', 'Este e-mail já está cadastrado.');
            $this->redirect('/register');
            return;
        }

        $userId = $this->userModel->create($name, $email, $password);
        $user   = $this->userModel->find($userId);

        $_SESSION['user_id'] = $user->id;
        $_SESSION['user']    = [
            'id'     => $user->id,
            'name'   => $user->name,
            'email'  => $user->email,
            'plan'   => $user->plan,
            'avatar' => null,
        ];

        $this->flash('success', 'Conta criada com sucesso! Bem-vindo(a)!');
        $this->redirect('/notas');
    }

    public function logout(): void
    {
        session_destroy();
        $this->redirect('/login');
    }
}
