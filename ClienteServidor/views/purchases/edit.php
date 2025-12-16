<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<h2>Editar Compra</h2>

<form method="POST" action="/index.php?controller=purchase&action=update" class="form">
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($purchase['id']); ?>">
    
    <div class="form-group">
        <label for="item_name">Nombre del Implemento *</label>
        <input type="text" id="item_name" name="item_name" required 
               value="<?php echo htmlspecialchars($purchase['item_name']); ?>">
    </div>
    
    <div class="form-group">
        <label for="supplier">Proveedor</label>
        <input type="text" id="supplier" name="supplier" 
               value="<?php echo htmlspecialchars($purchase['supplier'] ?? ''); ?>">
    </div>
    
    <div style="display: flex; gap: 1rem;">
        <div class="form-group" style="flex: 1;">
            <label for="quantity">Cantidad *</label>
            <input type="number" id="quantity" name="quantity" min="1" required 
                   value="<?php echo htmlspecialchars($purchase['quantity']); ?>">
        </div>
        <div class="form-group" style="flex: 1;">
            <label for="unit_price">Precio Unitario ($) *</label>
            <input type="number" id="unit_price" name="unit_price" step="0.01" min="0" required 
                   value="<?php echo htmlspecialchars($purchase['unit_price']); ?>">
        </div>
    </div>
    
    <div class="form-group">
        <label for="purchase_date">Fecha de Compra *</label>
        <input type="date" id="purchase_date" name="purchase_date" required 
               value="<?php echo htmlspecialchars($purchase['purchase_date']); ?>">
    </div>

    <div class="form-group">
        <label for="status">Estado</label>
        <select id="status" name="status">
            <option value="received" <?php echo $purchase['status'] == 'received' ? 'selected' : ''; ?>>Recibido</option>
            <option value="ordered" <?php echo $purchase['status'] == 'ordered' ? 'selected' : ''; ?>>Pedido (Pendiente)</option>
            <option value="cancelled" <?php echo $purchase['status'] == 'cancelled' ? 'selected' : ''; ?>>Cancelado</option>
        </select>
    </div>
    
    <div class="form-group">
        <label for="notes">Notas / Descripción</label>
        <textarea id="notes" name="notes" rows="3"><?php echo htmlspecialchars($purchase['notes'] ?? ''); ?></textarea>
    </div>
    
    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="/index.php?controller=purchase&action=index" class="btn btn-secondary">Cancelar</a>
    </div>
</form>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>