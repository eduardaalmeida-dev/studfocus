<?php

class NotaModel extends Model
{
    protected string $table = 'notes';

    public function allByUser(int $userId, ?int $categoryId = null, string $search = ''): array
    {
        $sql = "
            SELECT n.*, c.name AS category_name, c.color AS category_color
            FROM notes n
            LEFT JOIN categories c ON n.category_id = c.id
            WHERE n.user_id = ?
        ";
        $params = [$userId];

        if ($categoryId) {
            $sql .= " AND n.category_id = ?";
            $params[] = $categoryId;
        }

        if ($search) {
            $sql .= " AND (n.title LIKE ? OR n.content LIKE ?)";
            $params[] = "%{$search}%";
            $params[] = "%{$search}%";
        }

        $sql .= " ORDER BY n.updated_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function findForUser(int $id, int $userId): object|false
    {
        $stmt = $this->db->prepare("
            SELECT n.*, c.name AS category_name, c.color AS category_color
            FROM notes n
            LEFT JOIN categories c ON n.category_id = c.id
            WHERE n.id = ? AND n.user_id = ?
        ");
        $stmt->execute([$id, $userId]);
        return $stmt->fetch();
    }

    public function createForUser(int $userId, array $data): int
    {
        return $this->insert([
            'user_id'     => $userId,
            'category_id' => $data['category_id'] ?: null,
            'title'       => $data['title'],
            'content'     => $data['content'] ?? '',
        ]);
    }

    public function updateForUser(int $id, int $userId, array $data): bool
    {
        $stmt = $this->db->prepare("
            UPDATE notes SET title = ?, content = ?, category_id = ?, updated_at = NOW()
            WHERE id = ? AND user_id = ?
        ");
        return $stmt->execute([
            $data['title'],
            $data['content'] ?? '',
            $data['category_id'] ?: null,
            $id,
            $userId,
        ]);
    }

    public function deleteForUser(int $id, int $userId): bool
    {
        $stmt = $this->db->prepare("DELETE FROM notes WHERE id = ? AND user_id = ?");
        return $stmt->execute([$id, $userId]);
    }

    public function countByUser(int $userId): int
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM notes WHERE user_id = ?");
        $stmt->execute([$userId]);
        return (int) $stmt->fetchColumn();
    }
}
