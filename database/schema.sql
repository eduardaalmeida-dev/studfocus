-- =============================================
-- StudyFocus - Database Schema
-- =============================================

CREATE DATABASE IF NOT EXISTS studyfocus CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE studyfocus;

-- =============================================
-- USERS (Autenticação)
-- =============================================
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    avatar VARCHAR(255) DEFAULT NULL,
    plan ENUM('Estudante Free', 'Estudante Pro') DEFAULT 'Estudante Free',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- =============================================
-- CATEGORIES (Tags de categorias)
-- =============================================
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    color VARCHAR(20) DEFAULT '#0d6efd',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- =============================================
-- NOTES (Anotações)
-- =============================================
CREATE TABLE IF NOT EXISTS notes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    category_id INT DEFAULT NULL,
    title VARCHAR(255) NOT NULL,
    content LONGTEXT DEFAULT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);

-- =============================================
-- SCHEDULES (Cronograma/Agenda)
-- =============================================
CREATE TABLE IF NOT EXISTS schedules (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT DEFAULT NULL,
    subject VARCHAR(100) DEFAULT NULL,
    scheduled_at DATETIME NOT NULL,
    duration_minutes INT DEFAULT 60,
    status ENUM('pending', 'completed', 'cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- =============================================
-- POMODORO SESSIONS (Cronômetro)
-- =============================================
CREATE TABLE IF NOT EXISTS pomodoro_sessions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    subject VARCHAR(150) DEFAULT NULL,
    duration_minutes INT NOT NULL DEFAULT 25,
    type ENUM('focus', 'short_break', 'long_break') DEFAULT 'focus',
    completed TINYINT(1) DEFAULT 0,
    started_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    finished_at DATETIME NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- =============================================
-- REPORTS / STUDY GOALS
-- =============================================
CREATE TABLE IF NOT EXISTS study_goals (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    subject VARCHAR(150) NOT NULL,
    target_hours DECIMAL(5,2) NOT NULL DEFAULT 10.00,
    achieved_hours DECIMAL(5,2) NOT NULL DEFAULT 0.00,
    week_start DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- =============================================
-- FILES (Arquivos)
-- =============================================
CREATE TABLE IF NOT EXISTS files (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    note_id INT DEFAULT NULL,
    filename VARCHAR(255) NOT NULL,
    original_name VARCHAR(255) NOT NULL,
    file_type VARCHAR(100) DEFAULT NULL,
    file_size INT DEFAULT NULL,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (note_id) REFERENCES notes(id) ON DELETE SET NULL
);

-- =============================================
-- SEED: Usuário demo + dados iniciais
-- =============================================
INSERT INTO users (name, email, password, plan) VALUES 
('Ana Silva', 'ana@studyfocus.com', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Estudante Pro');
-- Senha: password

INSERT INTO categories (user_id, name, color) VALUES 
(1, 'História', '#198754'),
(1, 'Matemática', '#0d6efd'),
(1, 'Inglês', '#6f42c1'),
(1, 'Ciências', '#fd7e14'),
(1, 'Geografia', '#20c997');

INSERT INTO notes (user_id, category_id, title, content) VALUES 
(1, 1, 'Revolução Francesa - Resumo', '<h2>1. Antecedentes (Antigo Regime)</h2><p>A sociedade francesa foi dividida em três estados:</p><ul><li>Primeiro Estado: Clero (Igreja)</li><li>Segundo Estado: Nobreza</li><li>Terceiro Estado: Burguesia e Camponeses (97% da população)</li></ul><p>O Terceiro Estado pagava todos os impostos enquanto a nobreza e o clero tinham privilégios e isenções.</p><h2>2. A Queda da Bastilha (14 de Julho de 1789)</h2><p>Símbolo do absolutismo real, a prisão da Bastilha foi tomada pela população. Este evento marca o início da Revolução e o fim do poder absoluto do rei.</p><h2>3. Declaração dos Direitos do Homem e do Cidadão</h2><p>Documento inspirado no Iluminismo que definia a justiça jurídica, a liberdade de expressão e o direito à propriedade. "Liberdade, Igualdade, Fraternidade" tornou-se o lema.</p>'),
(1, 2, 'Fórmulas de Bhaskara', '<p>Delta = b² - 4ac. Se delta > 0, há duas raízes reais distintas. Se delta = 0, há uma raiz real. Se delta < 0, não há raízes reais.</p><h3>Fórmula</h3><p>x = (-b ± √Δ) / 2a</p>'),
(1, 3, 'Verbos Irregulares', '<p>Ser, ter, fazer, ir...</p><ul><li>Be - Was/Were - Been</li><li>Have - Had - Had</li><li>Go - Went - Gone</li><li>Do - Did - Done</li></ul>'),
(1, 1, 'Resumo Era Vargas', '<p>Estado Novo, DIP e Leis Trabalhistas marcaram o período getulista.</p>');
