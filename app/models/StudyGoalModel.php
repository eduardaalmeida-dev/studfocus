<?php

class StudyGoalModel extends Model
{
    protected string $table = 'study_goals';

    /**
     * Metas da semana atual do usuário.
     */
    public function currentWeek(int $userId): array
    {
        $weekStart = date('Y-m-d', strtotime('monday this week'));
        $stmt = $this->db->prepare("
            SELECT * FROM study_goals
            WHERE user_id = ? AND week_start = ?
            ORDER BY subject ASC
        ");
        $stmt->execute([$userId, $weekStart]);
        return $stmt->fetchAll();
    }

    /**
     * Cria ou atualiza meta semanal para uma matéria.
     */
    public function upsert(int $userId, string $subject, float $targetHours): int
    {
        $weekStart = date('Y-m-d', strtotime('monday this week'));
        $existing  = $this->findBySubjectAndWeek($userId, $subject, $weekStart);

        if ($existing) {
            $this->update($existing->id, ['target_hours' => $targetHours]);
            return $existing->id;
        }

        return $this->insert([
            'user_id'        => $userId,
            'subject'        => $subject,
            'target_hours'   => $targetHours,
            'achieved_hours' => 0,
            'week_start'     => $weekStart,
        ]);
    }

    /**
     * Adiciona horas conquistadas a uma meta.
     */
    public function addHours(int $id, float $hours): bool
    {
        $stmt = $this->db->prepare("
            UPDATE study_goals
            SET achieved_hours = LEAST(achieved_hours + ?, target_hours)
            WHERE id = ?
        ");
        return $stmt->execute([$hours, $id]);
    }

    private function findBySubjectAndWeek(int $userId, string $subject, string $weekStart): object|false
    {
        $stmt = $this->db->prepare("
            SELECT * FROM study_goals
            WHERE user_id = ? AND subject = ? AND week_start = ?
            LIMIT 1
        ");
        $stmt->execute([$userId, $subject, $weekStart]);
        return $stmt->fetch();
    }
}
