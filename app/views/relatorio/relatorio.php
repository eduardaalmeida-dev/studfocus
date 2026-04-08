<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StudFocus - Relatórios e Estatísticas</title>
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

        .header-relatorio {
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

        .card-metric {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: var(--card-shadow);
            height: 100%;
        }

        .card-metric .title {
            font-size: 0.9rem;
            color: #666;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .card-metric .value {
            font-size: 2rem;
            font-weight: bold;
            color: #333;
        }

        .card-metric .subtitle {
            font-size: 0.8rem;
            color: #888;
        }

        .card-chart, .card-disciplina, .card-historico {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: var(--card-shadow);
            margin-bottom: 20px;
        }

        .progress-bar-custom {
            height: 8px;
            border-radius: 4px;
        }

        .progress-bar-history { background-color: #ffc107; }
        .progress-bar-math { background-color: #ff6b6b; }
        .progress-bar-geo { background-color: #4dabf7; }
        .progress-bar-port { background-color: #20c997; }

        .table-historico th {
            font-size: 0.85rem;
            color: #666;
            border-bottom: 1px solid #eee;
        }

        .table-historico td {
            font-size: 0.9rem;
            color: #333;
            vertical-align: middle;
        }

        .table-historico tbody tr:last-child td {
            border-bottom: none;
        }

        .table-historico .tag-materia {
            font-size: 0.7rem;
            font-weight: bold;
            text-transform: uppercase;
            padding: 2px 8px;
            border-radius: 4px;
            display: inline-block;
        }

        .tag-historia { background: #fff3cd; color: #856404; }
        .tag-matematica { background: #ffe3e3; color: #c92a2a; }
        .tag-geografia { background: #e7f5ff; color: #1971c2; }
        .tag-redacao { background: #e6fcf5; color: #087f5b; }

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
            <a href="#" class="menu-item"><i class="bi bi-calendar3"></i> Cronograma</a>
            <a href="#" class="menu-item"><i class="bi bi-book"></i> Matérias</a>
            <a href="#" class="menu-item"><i class="bi bi-check2-square"></i> Tasks</a>
            <a href="#" class="menu-item active"><i class="bi bi-bar-chart"></i> Relatórios</a>
        </nav>
    </div>

    <div class="main-content">
        <div class="header-relatorio">
            <h4 class="fw-bold">Relatórios e Estatísticas</h4>
            <div class="d-flex gap-3 align-items-center">
                <span class="text-muted small">16 de outubro a 22 de outubro de 2023</span>
                <i class="bi bi-download fs-5 text-secondary"></i>
                <i class="bi bi-bell fs-5 text-secondary"></i>
                <button class="btn-novo-evento">+ Novo Evento</button>
            </div>
        </div>

        <div class="d-flex gap-2 mb-4">
            <button class="btn btn-sm btn-success">Semanal</button>
            <button class="btn btn-sm btn-outline-secondary">Mensal</button>
        </div>

        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card-metric">
                    <div class="title">Tempo Total Estudado <i class="bi bi-info-circle text-muted"></i></div>
                    <div class="value">18h 45m</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card-metric">
                    <div class="title">Ciclos Completados <i class="bi bi-arrow-repeat text-muted"></i></div>
                    <div class="value">32</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card-metric">
                    <div class="title">Taxa de Conclusão <i class="bi bi-check-circle text-muted"></i></div>
                    <div class="value">85%</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card-metric">
                    <div class="title">Dias de Ofensiva <i class="bi bi-fire text-warning"></i></div>
                    <div class="value">14</div>
                    <div class="subtitle">Recorde atual!</div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card-chart">
                    <h5 class="mb-3">Evolução de Desempenho (Horas)</h5>
                    <!-- Placeholder para o gráfico. Em um projeto real, usaria uma biblioteca como Chart.js -->
                    <div style="height: 250px; background-color: #f8f9fa; border-radius: 8px; display: flex; align-items: flex-end; justify-content: space-around; padding: 10px;">
                        <div style="width: 10%; height: 60%; background-color: var(--primary-color); border-radius: 4px;"></div>
                        <div style="width: 10%; height: 40%; background-color: var(--primary-color); border-radius: 4px;"></div>
                        <div style="width: 10%; height: 80%; background-color: var(--primary-color); border-radius: 4px;"></div>
                        <div style="width: 10%; height: 50%; background-color: var(--primary-color); border-radius: 4px;"></div>
                        <div style="width: 10%; height: 70%; background-color: var(--primary-color); border-radius: 4px;"></div>
                        <div style="width: 10%; height: 90%; background-color: var(--primary-color); border-radius: 4px;"></div>
                        <div style="width: 10%; height: 30%; background-color: var(--primary-color); border-radius: 4px;"></div>
                    </div>
                    <div class="d-flex justify-content-around mt-2 text-muted small">
                        <span>Seg</span>
                        <span>Ter</span>
                        <span>Qua</span>
                        <span>Qui</span>
                        <span>Sex</span>
                        <span>Sáb</span>
                        <span>Dom</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-disciplina">
                    <h5 class="mb-3">Por Disciplina</h5>
                    <div class="mb-2">
                        <div class="d-flex justify-content-between">
                            <span>História</span>
                            <span>45%</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar progress-bar-history" role="progressbar" style="width: 45%;" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="mb-2">
                        <div class="d-flex justify-content-between">
                            <span>Matemática</span>
                            <span>30%</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar progress-bar-math" role="progressbar" style="width: 30%;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="mb-2">
                        <div class="d-flex justify-content-between">
                            <span>Geografia</span>
                            <span>15%</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar progress-bar-geo" role="progressbar" style="width: 15%;" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="mb-2">
                        <div class="d-flex justify-content-between">
                            <span>Português</span>
                            <span>10%</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar progress-bar-port" role="progressbar" style="width: 10%;" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-historico">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Histórico de Sessões</h5>
                <a href="#" class="text-decoration-none">Ver tudo</a>
            </div>
            <div class="table-responsive">
                <table class="table table-borderless table-historico">
                    <thead>
                        <tr>
                            <th scope="col">Disciplina</th>
                            <th scope="col">Dados</th>
                            <th scope="col">Ciclos</th>
                            <th scope="col">Tempo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><span class="tag-materia tag-historia">História</span> com Francesa</td>
                            <td>Hoje, 10:30</td>
                            <td>4</td>
                            <td>1h 40min</td>
                        </tr>
                        <tr>
                            <td><span class="tag-materia tag-matematica">Matemática</span> Logaritmos</td>
                            <td>Ontem, 14:00</td>
                            <td>3</td>
                            <td>1h 30min</td>
                        </tr>
                        <tr>
                            <td><span class="tag-materia tag-geografia">Geografia</span> Geopolítica</td>
                            <td>01/04, 09:00</td>
                            <td>2</td>
                            <td>1h 00min</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>