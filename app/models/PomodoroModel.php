<?php

class PomodoroModel extends Model
{
    protected string $table = 'pomodoro_sessions';

    public function todayByUser(int $userId): array
    {
        $stmt = $this->db->prepare("
            SELECT * FROM pomodoro_sessions 
            WHERE user_id = ? AND DATE(started_at) = CURDATE()
            ORDER BY started_at DESC
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public function weeklyMinutesByUser(int $userId): int
    {
        $stmt = $this->db->prepare("
            SELECT COALESCE(SUM(duration_minutes), 0)
            FROM pomodoro_sessions
            WHERE user_id = ? AND completed = 1
              AND started_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
        ");
        $stmt->execute([$userId]);
        return (int) $stmt->fetchColumn();
    }

    public function dailyStatsByUser(int $userId, int $days = 7): array
    {
        $stmt = $this->db->prepare("
            SELECT DATE(started_at) AS day, 
                   COUNT(*) AS sessions,
                   SUM(duration_minutes) AS total_minutes
            FROM pomodoro_sessions
            WHERE user_id = ? AND completed = 1
              AND started_at >= DATE_SUB(NOW(), INTERVAL ? DAY)
            GROUP BY DATE(started_at)
            ORDER BY day ASC
        ");
        $stmt->execute([$userId, $days]);
        return $stmt->fetchAll();
    }

    public function store(int $userId, array $data): int
    {
        return $this->insert([
            'user_id'          => $userId,
            'subject'          => $data['subject'] ?? null,
            'duration_minutes' => $data['duration_minutes'] ?? 25,
            'type'             => $data['type'] ?? 'focus',
            'completed'        => $data['completed'] ?? 0,
            'finished_at'      => $data['completed'] ? date('Y-m-d H:i:s') : null,
        ]);
    }
}
