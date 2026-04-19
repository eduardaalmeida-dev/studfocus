<?php

class CategoryModel extends Model
{
    protected string $table = 'categories';

    public function allByUser(int $userId): array
    {
        $stmt = $this->db->prepare("SELECT * FROM categories WHERE user_id = ? ORDER BY name");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }
}
