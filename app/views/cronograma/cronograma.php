<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StudFocus - Cronograma Semanal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #1fa55b;
            --bg-light: #f4f6f8;
            --sidebar-width: 240px;
            --card-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        body {
            background-color: var(--bg-light);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Sidebar Mockup */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            background: white;
            border-right: 1px solid #ddd;
            position: fixed;
            left: 0;
            top: 0;
            padding: 20px;
        }

        .main-content {
            margin-left: var(--sidebar-width);
            padding: 20px;
        }

        .header-cronograma {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .btn-novo-evento {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 8px;
            font-weight: 600;
        }

        .btn-novo-evento:hover {
            background-color: #168a4a;
            color: white;
        }

        .semana-navegacao {
            display: flex;
            align-items: center;
            gap: 15px;
            font-weight: 600;
            color: #333;
        }

        .cronograma-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr); /* Conforme o print que mostra 4 colunas visíveis */
            gap: 20px;
            overflow-x: auto;
        }

        .dia-coluna {
            min-width: 250px;
        }

        .dia-header {
            margin-bottom: 15px;
        }

        .dia-nome {
            font-weight: bold;
            font-size: 1.1rem;
            margin-bottom: 2px;
        }

        .dia-meta {
            font-size: 0.85rem;
            color: #666;
            background: #e9ecef;
            padding: 5px 10px;
            border-radius: 15px;
            display: inline-block;
            margin-bottom: 15px;
            width: 100%;
        }

        .card-evento {
            background: white;
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: var(--card-shadow);
            border-left: 5px solid transparent;
            position: relative;
        }

        .card-evento.historia { border-left-color: #ffc107; }
        .card-evento.matematica { border-left-color: #ff6b6b; }
        .card-evento.geografia { border-left-color: #4dabf7; }
        .card-evento.redacao { border-left-color: #20c997; }

        .tag-materia {
            font-size: 0.7rem;
            font-weight: bold;
            text-transform: uppercase;
            padding: 2px 8px;
            border-radius: 4px;
            display: inline-block;
            margin-bottom: 8px;
        }

        .tag-historia { background: #fff3cd; color: #856404; }
        .tag-matematica { background: #ffe3e3; color: #c92a2a; }
        .tag-geografia { background: #e7f5ff; color: #1971c2; }
        .tag-redacao { background: #e6fcf5; color: #087f5b; }

        .evento-titulo {
            font-weight: 600;
            font-size: 0.95rem;
            margin-bottom: 5px;
            color: #333;
        }

        .evento-info {
            font-size: 0.8rem;
            color: #888;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .btn-adicionar-dia {
            width: 100%;
            border: 2px dashed #ccc;
            background: transparent;
            color: #999;
            padding: 10px;
            border-radius: 8px;
            font-size: 0.9rem;
            transition: all 0.2s;
        }

        .btn-adicionar-dia:hover {
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        .check-done {
            position: absolute;
            top: 15px;
            right: 15px;
            color: var(--primary-color);
            font-size: 1.2rem;
        }

        /* Sidebar Menu Items */
        .menu-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            color: #666;
            text-decoration: none;
            border-radius: 8px;
            margin-bottom: 5px;
        }

        .menu-item.active {
            background-color: #e8f5e9;
            color: var(--primary-color);
            font-weight: 600;
        }

        .menu-item i { font-size: 1.2rem; }

    </style>
</head>
<body>

    <div class="sidebar">
        <div class="mb-4">
            <h5 class="text-success fw-bold mb-4">⏱ StudyFocus</h5>
        </div>
        <nav>
            <a href="#" class="menu-item"><i class="bi bi-grid"></i> Painel</a>
            <a href="#" class="menu-item active"><i class="bi bi-calendar3"></i> Cronograma</a>
            <a href="#" class="menu-item"><i class="bi bi-book"></i> Matérias</a>
            <a href="#" class="menu-item"><i class="bi bi-check2-square"></i> Tasks</a>
            <a href="#" class="menu-item"><i class="bi bi-bar-chart"></i> Relatórios</a>
        </nav>
    </div>

    <div class="main-content">
        <div class="header-cronograma">
            <h4 class="fw-bold">Cronograma Semanal</h4>
            <div class="d-flex gap-3 align-items-center">
                <i class="bi bi-bell fs-5 text-secondary"></i>
                <button class="btn-novo-evento">+ Novo Evento</button>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="semana-navegacao">
                <i class="bi bi-chevron-left cursor-pointer"></i>
                <span>16 a 22 de outubro de 2023</span>
                <i class="bi bi-chevron-right cursor-pointer"></i>
            </div>
            <div class="btn-group">
                <button class="btn btn-sm btn-outline-secondary active"><i class="bi bi-view-stacked"></i></button>
                <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-list"></i></button>
            </div>
        </div>

        <div class="cronograma-grid">
            <!-- Segunda -->
            <div class="dia-coluna">
                <div class="dia-header">
                    <div class="dia-nome">Segunda</div>
                    <div class="text-muted small">16 Out</div>
                </div>
                <div class="dia-meta">
                    <i class="bi bi-bullseye"></i> Meta: 3h Óculos
                </div>
                
                <div class="card-evento historia">
                    <span class="tag-materia tag-historia">História</span>
                    <div class="evento-titulo">com Francesa</div>
                    <div class="evento-info"><i class="bi bi-clock"></i> 09:00 - 10:30</div>
                    <div class="evento-info mt-2"><i class="bi bi-paperclip"></i> <i class="bi bi-person"></i></div>
                </div>

                <div class="card-evento matematica">
                    <span class="tag-materia tag-matematica">Matemática</span>
                    <div class="evento-titulo">Lista de Exercícios: Logaritmos</div>
                    <div class="evento-info"><i class="bi bi-clock"></i> 14:00 - 15:30</div>
                    <div class="evento-info mt-2"><i class="bi bi-paperclip"></i></div>
                </div>

                <button class="btn-adicionar-dia">+ adicionar</button>
            </div>

            <!-- Terça -->
            <div class="dia-coluna">
                <div class="dia-header">
                    <div class="dia-nome">Terça</div>
                    <div class="text-muted small">17 Out</div>
                </div>
                <div class="dia-meta">
                    <i class="bi bi-bullseye"></i> Meta: 4h Ônibus
                </div>

                <div class="card-evento geografia">
                    <i class="bi bi-check-circle-fill check-done"></i>
                    <span class="tag-materia tag-geografia">Geografia</span>
                    <div class="evento-titulo">Geopolítica Mundial</div>
                    <div class="evento-info"><i class="bi bi-clock"></i> 10:00 - 12:00</div>
                    <div class="evento-info mt-2"><i class="bi bi-file-earmark-text"></i></div>
                </div>

                <button class="btn-adicionar-dia">+ adicionar</button>
            </div>

            <!-- Quarta -->
            <div class="dia-coluna">
                <div class="dia-header">
                    <div class="dia-nome">Quarta</div>
                    <div class="text-muted small">18 Out</div>
                </div>
                <div class="dia-meta">
                    <i class="bi bi-bullseye"></i> Meta: 2h revisão
                </div>

                <div class="text-center py-5 text-muted small">
                    Nenhuma atividade
                </div>

                <button class="btn-adicionar-dia">+ adicionar</button>
            </div>

            <!-- Quinta -->
            <div class="dia-coluna">
                <div class="dia-header">
                    <div class="dia-nome">Quinta</div>
                    <div class="text-muted small">19 Out</div>
                </div>
                <div class="dia-meta">
                    <i class="bi bi-bullseye"></i> Meta: Simulado
                </div>

                <div class="card-evento redacao">
                    <span class="tag-materia tag-redacao">Redação</span>
                    <div class="evento-titulo">Prática de Texto: Tema 4</div>
                    <div class="evento-info"><i class="bi bi-clock"></i> 14:00 - 16:00</div>
                    <div class="evento-info mt-2"><i class="bi bi-paperclip"></i></div>
                </div>

                <button class="btn-adicionar-dia">+ adicionar</button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>