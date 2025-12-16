<?php
/**
 * Modelo de Compras (Implementos)
 * Ubicación: models/Purchase.php
 */

require_once __DIR__ . '/../config/database.php';

class Purchase {
    private $db;
    
    public function __construct() {
        $database = Database::getInstance();
        $this->db = $database->getConnection();
    }
    
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM purchases ORDER BY purchase_date DESC");
        return $stmt->fetchAll();
    }
    
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM purchases WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }
    
    public function create($data) {
        // Calcular precio total en el servidor
        $total_price = $data['quantity'] * $data['unit_price'];

        $sql = "INSERT INTO purchases (item_name, supplier, quantity, unit_price, total_price, purchase_date, status, notes) 
                VALUES (:item_name, :supplier, :quantity, :unit_price, :total_price, :purchase_date, :status, :notes)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'item_name' => $data['item_name'],
            'supplier' => $data['supplier'] ?? null,
            'quantity' => $data['quantity'],
            'unit_price' => $data['unit_price'],
            'total_price' => $total_price,
            'purchase_date' => $data['purchase_date'],
            'status' => $data['status'] ?? 'received',
            'notes' => $data['notes'] ?? null
        ]);
        return $this->db->lastInsertId();
    }
    
    public function update($id, $data) {
        // Recalcular total al actualizar
        $total_price = $data['quantity'] * $data['unit_price'];

        $sql = "UPDATE purchases 
                SET item_name = :item_name, supplier = :supplier, quantity = :quantity, 
                    unit_price = :unit_price, total_price = :total_price, 
                    purchase_date = :purchase_date, status = :status, notes = :notes
                WHERE id = :id";
                
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'item_name' => $data['item_name'],
            'supplier' => $data['supplier'] ?? null,
            'quantity' => $data['quantity'],
            'unit_price' => $data['unit_price'],
            'total_price' => $total_price,
            'purchase_date' => $data['purchase_date'],
            'status' => $data['status'] ?? 'received',
            'notes' => $data['notes'] ?? null
        ]);
    }
    
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM purchases WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}