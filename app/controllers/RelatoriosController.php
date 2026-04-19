<?php

require_once APP_PATH . '/models/PomodoroModel.php';
require_once APP_PATH . '/models/NotaModel.php';

class RelatoriosController extends Controller
{
    private PomodoroModel $pomodoroModel;
    private NotaModel     $notaModel;

    public function __construct()
    {
        $this->pomodoroModel = new PomodoroModel();
        $this->notaModel     = new NotaModel();
    }

    public function index(): void
    {
        $this->requireAuth();

        $userId        = (int) $_SESSION['user_id'];
        $user          = $this->currentUser();
        $dailyStats    = $this->pomodoroModel->dailyStatsByUser($userId, 30);
        $weeklyMinutes = $this->pomodoroModel->weeklyMinutesByUser($userId);
        $totalNotas    = $this->notaModel->countByUser($userId);
        $flash         = $this->getFlash();

        $this->view('relatorios/index', compact(
            'user', 'dailyStats', 'weeklyMinutes', 'totalNotas', 'flash'
        ));
    }
}
