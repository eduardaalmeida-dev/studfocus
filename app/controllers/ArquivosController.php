<?php

class ArquivosController extends Controller
{
    public function index(): void
    {
        $this->requireAuth();
        $user  = $this->currentUser();
        $flash = $this->getFlash();
        $this->view('arquivos/index', compact('user', 'flash'));
    }
}
