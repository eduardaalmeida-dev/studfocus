<?php

require_once APP_PATH . '/models/NotaModel.php';
require_once APP_PATH . '/models/CategoryModel.php';

class NotasController extends Controller
{
    private NotaModel     $notaModel;
    private CategoryModel $categoryModel;

    public function __construct()
    {
        $this->notaModel     = new NotaModel();
        $this->categoryModel = new CategoryModel();
    }

    public function index(): void
    {
        $this->requireAuth();

        $userId     = (int) $_SESSION['user_id'];
        $categoryId = (int) $this->get('categoria', 0);
        $search     = $this->sanitize($this->get('busca', ''));
        $activeId   = (int) $this->get('nota', 0);

        $categories = $this->categoryModel->allByUser($userId);
        $notas      = $this->notaModel->allByUser($userId, $categoryId ?: null, $search);
        $activeNota = $activeId ? $this->notaModel->findForUser($activeId, $userId) : ($notas[0] ?? null);
        $flash      = $this->getFlash();
        $user       = $this->currentUser();

        $this->view('notas/index', compact(
            'notas', 'categories', 'activeNota',
            'categoryId', 'search', 'flash', 'user'
        ));
    }

    public function store(): void
    {
        $this->requireAuth();

        $userId = (int) $_SESSION['user_id'];
        $data   = [
            'title'       => $this->sanitize($this->post('title', 'Nova Nota')),
            'content'     => $this->post('content', ''),
            'category_id' => (int) $this->post('category_id', 0),
        ];

        if (empty($data['title'])) {
            $this->json(['success' => false, 'message' => 'Título obrigatório.'], 422);
            return;
        }

        $id = $this->notaModel->createForUser($userId, $data);

        if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            $nota = $this->notaModel->findForUser($id, $userId);
            $this->json(['success' => true, 'nota' => $nota]);
            return;
        }

        $this->flash('success', 'Nota criada com sucesso!');
        $this->redirect("/notas?nota={$id}");
    }

    public function update(string $id): void
    {
        $this->requireAuth();

        $userId = (int) $_SESSION['user_id'];
        $id     = (int) $id;
        $data   = [
            'title'       => $this->sanitize($this->post('title', '')),
            'content'     => $this->post('content', ''),
            'category_id' => (int) $this->post('category_id', 0),
        ];

        $ok = $this->notaModel->updateForUser($id, $userId, $data);

        if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            $this->json(['success' => $ok]);
            return;
        }

        $this->flash($ok ? 'success' : 'danger', $ok ? 'Nota atualizada!' : 'Erro ao atualizar.');
        $this->redirect("/notas?nota={$id}");
    }

    public function destroy(string $id): void
    {
        $this->requireAuth();

        $userId = (int) $_SESSION['user_id'];
        $id     = (int) $id;
        $ok     = $this->notaModel->deleteForUser($id, $userId);

        if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            $this->json(['success' => $ok]);
            return;
        }

        $this->flash($ok ? 'success' : 'danger', $ok ? 'Nota excluída!' : 'Erro ao excluir.');
        $this->redirect('/notas');
    }

    public function search(): void
    {
        $this->requireAuth();
        $this->redirect('/notas?' . http_build_query(['busca' => $this->get('q', '')]));
    }
}
