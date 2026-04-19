<?php

require_once APP_PATH . '/models/NotaModel.php';
require_once APP_PATH . '/models/PomodoroModel.php';
require_once APP_PATH . '/models/CategoryModel.php';

class HomeController extends Controller
{
    private NotaModel     $notaModel;
    private PomodoroModel $pomodoroModel;
    private CategoryModel $categoryModel;

    public function __construct()
    {
        $this->notaModel     = new NotaModel();
        $this->pomodoroModel = new PomodoroModel();
        $this->categoryModel = new CategoryModel();
    }

    public function index(): void
    {
        $this->requireAuth();

        $userId         = (int) $_SESSION['user_id'];
        $user           = $this->currentUser();
        $totalNotas     = $this->notaModel->countByUser($userId);
        $weeklyMinutes  = $this->pomodoroModel->weeklyMinutesByUser($userId);
        $dailyStats     = $this->pomodoroModel->dailyStatsByUser($userId, 7);
        $recentNotas    = $this->notaModel->allByUser($userId);
        $recentNotas    = array_slice($recentNotas, 0, 5);
        $categories     = $this->categoryModel->allByUser($userId);
        $flash          = $this->getFlash();

        $this->view('home/index', compact(
            'user', 'totalNotas', 'weeklyMinutes',
            'dailyStats', 'recentNotas', 'categories', 'flash'
        ));
    }
}
