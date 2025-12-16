<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<h2>Compras de Implementos</h2>

<div class="actions">
    <a href="/index.php?controller=purchase&action=create" class="btn btn-primary">➕ Nueva Compra</a>
</div>

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Implemento</th>
            <th>Proveedor</th>
            <th>Cant.</th>
            <th>P. Unitario</th>
            <th>Total</th>
            <th>Fecha</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($purchases)): ?>
            <tr><td colspan="9" class="text-center">No hay compras registradas</td></tr>
        <?php else: ?>
            <?php foreach ($purchases as $p): ?>
                <tr>
                    <td><?php echo htmlspecialchars($p['id']); ?></td>
                    <td><?php echo htmlspecialchars($p['item_name']); ?></td>
                    <td><?php echo htmlspecialchars($p['supplier'] ?? '-'); ?></td>
                    <td><?php echo htmlspecialchars($p['quantity']); ?></td>
                    <td>$<?php echo number_format($p['unit_price'], 2); ?></td>
                    <td><strong>$<?php echo number_format($p['total_price'], 2); ?></strong></td>
                    <td><?php echo htmlspecialchars($p['purchase_date']); ?></td>
                    <td>
                        <span class="badge badge-<?php echo $p['status'] === 'received' ? 'success' : 'warning'; ?>">
                            <?php echo $p['status'] === 'received' ? 'Recibido' : ($p['status'] === 'ordered' ? 'Pedido' : 'Cancelado'); ?>
                        </span>
                    </td>
                    <td class="actions-cell">
                        <a href="/index.php?controller=purchase&action=edit&id=<?php echo $p['id']; ?>" class="btn btn-sm btn-secondary">Editar</a>
                        <a href="/index.php?controller=purchase&action=delete&id=<?php echo $p['id']; ?>" 
                           class="btn btn-sm btn-danger" 
                           onclick="return confirm('¿Eliminar registro de compra?')">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>