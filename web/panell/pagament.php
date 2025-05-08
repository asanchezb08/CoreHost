<?php

require_once __DIR__ . '/../includes/session_handler.php';
// Verificar si hi ha dades de VM a la sessió
if (!isset($_SESSION['vm_datos'])) {
    header('Location: crear_vm.php');
    exit;
}

// Obtenir les dades de la sessió
$vm_datos = $_SESSION['vm_datos'];
$plan = $vm_datos['plan'];
$disco = $vm_datos['disco'];
$plantilla = $vm_datos['plantilla'];
$precio_plan = $vm_datos['precio_plan'];
$precio_disco = $vm_datos['precio_disco'];
$precio_total = $vm_datos['precio_total'];

// Buscar el nom del pla a la base de dades si no està disponible
if (!isset($plan['nombre']) || empty($plan['nombre'])) {
    try {
        require_once 'conexion.php';
        $plan_id = isset($plan['id']) ? $plan['id'] : null;

        if ($plan_id) {
            // Consultar el nom del pla a la base de dades
            $stmtPlan = $conn->prepare("SELECT nombre FROM planes_recursos WHERE id = ?");
            $stmtPlan->execute([$plan_id]);
            $planInfo = $stmtPlan->fetch(PDO::FETCH_ASSOC);
            if ($planInfo && isset($planInfo['nombre'])) {
                $plan['nombre'] = $planInfo['nombre'];
            } else {
                // Si no es pot obtenir el nom, assignar-ne un basat en els recursos
                $plan['nombre'] = "Plan " . $plan['cores'] . " cores / " . ($plan['ram'] / 1024) . " GB RAM";
            }
        } else {
            // Si no hi ha ID del pla, utilitzar informació dels recursos
            $plan['nombre'] = "Plan " . $plan['cores'] . " cores / " . ($plan['ram'] / 1024) . " GB RAM";
        }
    } catch (Exception $e) {
        // En cas d'error, utilitzar informació genèrica
        $plan['nombre'] = "Plan Personalizado";
    }
}

// Traduir el nom del pla al català
$nombre_plan = $plan['nombre'] ?? '';
switch($nombre_plan) {
    case 'Plan Básico':
        $nombre_plan = 'Pla Bàsic';
        break;
    case 'Plan Medio':
        $nombre_plan = 'Pla Mitjà';
        break;
    case 'Plan Avanzado':
        $nombre_plan = 'Pla Avançat';
        break;
    default:
        // Si és un nom generat, traduir parts comunes
        $nombre_plan = str_replace('Plan ', 'Pla ', $nombre_plan);
        $nombre_plan = str_replace('cores', 'nuclis', $nombre_plan);
        break;
}

include 'header.php';
?>

<!-- Càrrega del CSS correcte -->
<link rel="stylesheet" href="dashboard.css">
<!-- Incloure jsPDF -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<div class="container">
    <div class="header-container">
        <div class="header-title">
            <h1>Selecciona el teu mètode de pagament</h1>
        </div>
        <div class="action-buttons">
            <a href="dashboard.php" class="btn btn-outline">
                <span class="btn-icon">←</span> Tornar al panell
            </a>
        </div>
    </div>

    <!-- Resum de la comanda -->
    <div class="vm-card" style="margin-bottom: 20px;">
        <div class="vm-header">
            <h2>Resum del teu servidor</h2>
        </div>
        <div class="vm-body">
            <div class="vm-specs">
                <div class="spec-item">
                    <span class="spec-label">Pla</span>
                    <span class="spec-value"><?= htmlspecialchars($nombre_plan) ?></span>
                </div>
                <div class="spec-item">
                    <span class="spec-label">CPU</span>
                    <span class="spec-value"><?= htmlspecialchars($plan['cores']) ?> cores</span>
                </div>
                <div class="spec-item">
                    <span class="spec-label">RAM</span>
                    <span class="spec-value"><?= htmlspecialchars($plan['ram'] / 1024) ?> GB</span>
                </div>
                <div class="spec-item">
                    <span class="spec-label">Disc</span>
                    <span class="spec-value"><?= htmlspecialchars($disco['cantidad_gb']) ?> GB</span>
                </div>
            </div>

            <div class="form-divider">Sistema</div>
            <p>Sistema operatiu: <strong><?= htmlspecialchars($plantilla) ?></strong></p>
            <p>PHP: <strong>8.1</strong></p>

            <div class="form-divider">Costos mensuals</div>
            <div class="vm-specs">
                <div class="spec-item">
                    <span class="spec-label">Pla</span>
                    <span class="spec-value"><?= htmlspecialchars($precio_plan) ?> €</span>
                </div>
                <div class="spec-item">
                    <span class="spec-label">Disc addicional</span>
                    <span class="spec-value"><?= htmlspecialchars($precio_disco) ?> €</span>
                </div>
                <div class="spec-item">
                    <span class="spec-label">Total mensual</span>
                    <span class="spec-value"><?= htmlspecialchars($precio_total) ?> €</span>
                </div>
            </div>
        </div>
    </div>

    <div class="vm-grid">
        <!-- Targeta de crèdit -->
        <div class="vm-card">
            <div class="vm-header">
                <h2>Targeta de Crèdit</h2>
            </div>
            <div class="vm-body">
                <form id="creditCardForm">
                    <div>
                        <label>Número de targeta</label>
                        <input type="text" class="form-control" placeholder="0000 0000 0000 0000" id="cardNumber">
                    </div>
                    <div style="display: flex; gap: 10px; margin-top: 15px;">
                        <div style="flex: 1;">
                            <label>Data de caducitat</label>
                            <input type="text" class="form-control" placeholder="MM/AA" id="expiryDate">
                        </div>
                        <div style="flex: 1;">
                            <label>CVV</label>
                            <input type="text" class="form-control" placeholder="123" id="cvv">
                        </div>
                    </div>
                    <div style="margin-top: 15px;">
                        <label>Nom a la targeta</label>
                        <input type="text" class="form-control" placeholder="Nom complert" id="cardHolder">
                    </div>
                    <div style="margin-top: 20px; text-align: right;">
                        <button type="submit" class="btn btn-success">Pagar Ara</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- PayPal -->
        <div class="vm-card">
            <div class="vm-header">
                <h2>PayPal</h2>
            </div>
            <div class="vm-body">
                <div style="text-align: center; margin-bottom: 20px;">
                    <img src="https://www.paypalobjects.com/webstatic/mktg/logo/pp_cc_mark_111x69.jpg" alt="PayPal" style="max-width: 150px;">
                </div>
                <p style="text-align: center; margin-bottom: 20px;">
                    Inicia sessió a PayPal per completar el teu pagament
                </p>
                <div style="text-align: center;">
                    <a href="https://www.paypal.es" target="_blank" class="btn btn-info" style="width: 80%; display: inline-block; text-decoration: none;">Pagar amb PayPal</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Emmagatzemar les dades del servidor per incloure-les al PDF
const serverData = {
    plan: '<?= addslashes($nombre_plan) ?>',
    cores: <?= (int)$plan['cores'] ?>,
    ram: <?= (float)$plan['ram'] / 1024 ?>,
    disc: <?= (int)$disco['cantidad_gb'] ?>,
    plantilla: '<?= addslashes($plantilla) ?>',
    precioPlan: <?= (float)$precio_plan ?>,
    precioDisco: <?= (float)$precio_disco ?>,
    precioTotal: <?= (float)$precio_total ?>
};

document.getElementById('creditCardForm').addEventListener('submit', function(e) {
    e.preventDefault();

    // Crear PDF
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    const cardNumber = document.getElementById('cardNumber').value;
    const expiryDate = document.getElementById('expiryDate').value;
    const cvv = document.getElementById('cvv').value;
    const cardHolder = document.getElementById('cardHolder').value;

    doc.setFontSize(16);
    doc.text('Ticket de Compra - Servidor Virtual', 105, 20, null, null, 'center');

    doc.setFontSize(12);
    doc.text(`Data: ${new Date().toLocaleDateString()}`, 20, 40);

    // Detalls del pagament
    doc.text(`Mètode de pagament: Targeta de Crèdit`, 20, 55);
    doc.text(`Número de Targeta: ${cardNumber}`, 20, 65);
    doc.text(`Data de Caducitat: ${expiryDate}`, 20, 75);
    doc.text(`Titular: ${cardHolder}`, 20, 85);

    // Detalls del servidor
    doc.setFontSize(14);
    doc.text('Detalls del servidor:', 20, 105);
    doc.setFontSize(12);
    doc.text(`Pla: ${serverData.plan}`, 25, 120);
    doc.text(`CPU: ${serverData.cores} cores`, 25, 130);
    doc.text(`RAM: ${serverData.ram} GB`, 25, 140);
    doc.text(`Disc: ${serverData.disc} GB`, 25, 150);
    doc.text(`Sistema Operatiu: ${serverData.plantilla}`, 25, 160);

    // Detalls del cost
    doc.setFontSize(14);
    doc.text('Costos mensuals:', 20, 180);
    doc.setFontSize(12);
    doc.text(`Pla: ${serverData.precioPlan} €`, 25, 195);
    doc.text(`Disc addicional: ${serverData.precioDisco} €`, 25, 205);
    doc.text(`Total mensual: ${serverData.precioTotal} €`, 25, 215);

    doc.setFontSize(14);
    doc.text('Estat: Pagament Realitzat amb Èxit', 105, 235, null, null, 'center');
    doc.text('Gràcies per la teva compra!', 105, 250, null, null, 'center');

    // Guardar el PDF
    doc.save('ticket_compra_servidor.pdf');

    // Mostrar alerta i redirigir a dashboard.php
    alert('Pagament processat correctament! S\'ha descarregat el teu rebut.');

    // Netejar les dades temporals de la sessió
    fetch('clear_session.php')
    .finally(() => {
        // Redirigir a dashboard.php després que l'usuari tanqui l'alerta
        window.location.href = 'dashboard.php';
    });
});
</script>

<?php include 'footer.php'; ?>
