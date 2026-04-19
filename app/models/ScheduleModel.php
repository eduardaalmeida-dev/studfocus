<?php

class ScheduleModel extends Model
{
    protected string $table = 'schedules';

    /**
     * Busca todos os eventos do usuário em um intervalo de datas.
     */
    public function byUserAndRange(int $userId, string $start, string $end): array
    {
        $stmt = $this->db->prepare("
            SELECT * FROM schedules
            WHERE user_id = ?
              AND scheduled_at BETWEEN ? AND ?
            ORDER BY scheduled_at ASC
        ");
        $stmt->execute([$userId, $start, $end]);
        return $stmt->fetchAll();
    }

    /**
     * Próximos eventos do usuário.
     */
    public function upcoming(int $userId, int $limit = 5): array
    {
        $stmt = $this->db->prepare("
            SELECT * FROM schedules
            WHERE user_id = ? AND scheduled_at >= NOW() AND status = 'pending'
            ORDER BY scheduled_at ASC
            LIMIT ?
        ");
        $stmt->execute([$userId, $limit]);
        return $stmt->fetchAll();
    }

    /**
     * Cria um novo evento.
     */
    public function createForUser(int $userId, array $data): int
    {
        return $this->insert([
            'user_id'          => $userId,
            'title'            => $data['title'],
            'description'      => $data['description'] ?? null,
            'subject'          => $data['subject'] ?? null,
            'scheduled_at'     => $data['scheduled_at'],
            'duration_minutes' => $data['duration_minutes'] ?? 60,
            'status'           => 'pending',
        ]);
    }

    /**
     * Marca evento como concluído.
     */
    public function complete(int $id, int $userId): bool
    {
        $stmt = $this->db->prepare("
            UPDATE schedules SET status = 'completed'
            WHERE id = ? AND user_id = ?
        ");
        return $stmt->execute([$id, $userId]);
    }

    /**
     * Conta eventos por status para o usuário.
     */
    public function countByStatus(int $userId): array
    {
        $stmt = $this->db->prepare("
            SELECT status, COUNT(*) as total
            FROM schedules
            WHERE user_id = ?
            GROUP BY status
        ");
        $stmt->execute([$userId]);
        $rows = $stmt->fetchAll();

        $result = ['pending' => 0, 'completed' => 0, 'cancelled' => 0];
        foreach ($rows as $row) {
            $result[$row->status] = (int)$row->total;
        }
        return $result;
    }
}
