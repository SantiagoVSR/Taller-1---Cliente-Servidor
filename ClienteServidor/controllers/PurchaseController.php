<?php
/**
 * Controlador de Compras
 * Ubicación: controllers/PurchaseController.php
 */

require_once __DIR__ . '/../models/Purchase.php';

class PurchaseController {
    private $purchaseModel;
    
    public function __construct() {
        $this->purchaseModel = new Purchase();
    }
    
    public function index() {
        $purchases = $this->purchaseModel->getAll();
        require_once __DIR__ . '/../views/purchases/index.php';
    }
    
    public function create() {
        $errors = [];
        require_once __DIR__ . '/../views/purchases/create.php';
    }
    
    public function store() {
        $errors = $this->validate($_POST);
        
        if (empty($errors)) {
            $this->purchaseModel->create($_POST);
            header('Location: /index.php?controller=purchase&action=index&success=created');
            exit;
        }
        require_once __DIR__ . '/../views/purchases/create.php';
    }
    
    public function edit() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /index.php?controller=purchase&action=index&error=not_found');
            exit;
        }
        
        $purchase = $this->purchaseModel->getById($id);
        if (!$purchase) {
            header('Location: /index.php?controller=purchase&action=index&error=not_found');
            exit;
        }
        
        $errors = [];
        require_once __DIR__ . '/../views/purchases/edit.php';
    }
    
    public function update() {
        $id = $_POST['id'] ?? null;
        if (!$id) {
            header('Location: /index.php?controller=purchase&action=index&error=not_found');
            exit;
        }
        
        $errors = $this->validate($_POST);
        
        if (empty($errors)) {
            $this->purchaseModel->update($id, $_POST);
            header('Location: /index.php?controller=purchase&action=index&success=updated');
            exit;
        }
        
        $purchase = $this->purchaseModel->getById($id);
        require_once __DIR__ . '/../views/purchases/edit.php';
    }
    
    public function delete() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->purchaseModel->delete($id);
            header('Location: /index.php?controller=purchase&action=index&success=deleted');
        } else {
            header('Location: /index.php?controller=purchase&action=index&error=delete_failed');
        }
        exit;
    }
    
    private function validate($data) {
        $errors = [];
        if (empty($data['item_name'])) $errors['item_name'] = 'El nombre del ítem es requerido';
        if (empty($data['quantity']) || $data['quantity'] <= 0) $errors['quantity'] = 'Cantidad inválida';
        if (empty($data['unit_price']) || $data['unit_price'] < 0) $errors['unit_price'] = 'Precio inválido';
        if (empty($data['purchase_date'])) $errors['purchase_date'] = 'La fecha es requerida';
        return $errors;
    }
}