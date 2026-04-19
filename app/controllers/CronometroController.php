<?php

require_once APP_PATH . '/models/PomodoroModel.php';

class CronometroController extends Controller
{
    private PomodoroModel $pomodoroModel;

    public function __construct()
    {
        $this->pomodoroModel = new PomodoroModel();
    }

    public function index(): void
    {
        $this->requireAuth();

        $userId      = (int) $_SESSION['user_id'];
        $user        = $this->currentUser();
        $todaySessions = $this->pomodoroModel->todayByUser($userId);
        $flash       = $this->getFlash();

        $this->view('cronometro/index', compact('user', 'todaySessions', 'flash'));
    }

    public function store(): void
    {
        $this->requireAuth();

        $userId = (int) $_SESSION['user_id'];
        $data   = [
            'subject'          => $this->sanitize($this->post('subject', '')),
            'duration_minutes' => (int) $this->post('duration_minutes', 25),
            'type'             => $this->post('type', 'focus'),
            'completed'        => (int) $this->post('completed', 1),
        ];

        $id = $this->pomodoroModel->store($userId, $data);

        if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            $this->json(['success' => true, 'id' => $id]);
            return;
        }

        $this->flash('success', 'Sessão registrada!');
        $this->redirect('/cronometro');
    }
}
