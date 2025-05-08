<?php

require_once __DIR__ . '/../includes/session_handler.php';
require_once 'conexion.php';

// Comprova si l'usuari ha iniciat sessió
if (!isset($_SESSION['cliente_id'])) {
    header("Location: login.php");
    exit();
}

$cliente_id = $_SESSION['cliente_id'];

try {
    // Obté les dades del client des de la base de dades
    $stmt = $conn->prepare("SELECT * FROM clientes WHERE id = :id");
    $stmt->bindParam(':id', $cliente_id, PDO::PARAM_INT);
    $stmt->execute();
    $cliente = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Mostra un error si no es poden obtenir les dades del client
    die("Error en obtenir les dades del client.");
}

// Funció per escapar valors
function esc($value) {
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

include 'header.php';
?>
<link rel="stylesheet" href="dashboard.css">

<div class="container">
    <div class="header-container">
        <div class="header-title">
            <h1>El meu perfil</h1>
            <span class="header-subtitle">Gestiona les teves dades personals</span>
        </div>
        <div class="action-buttons">
            <a href="dashboard.php" class="btn btn-outline"><span class="btn-icon">←</span> Torna al panell</a>
        </div>
    </div>

    <?php 
    // Mostra un missatge de confirmació si el perfil s'ha actualitzat correctament
    if (isset($_GET['success']) && $_GET['success'] === 'perfil_actualizado'): ?>
        <div class="success-message"> Les teves dades s'han actualitzat correctament.</div>
    <?php endif; ?>

    <?php 
    // Mostra un missatge de confirmació si la contrasenya s'ha canviat correctament
    if (isset($_GET['success']) && $_GET['success'] === 'password_cambiada'): ?>
        <div class="success-message"> Contrasenya actualitzada correctament.</div>
    <?php endif; ?>

    <?php 
    // Mostra un missatge d'error si hi ha algun problema
    if (isset($_GET['error'])):
        $error = $_GET['error'];
        $message = match($error) {
            'missing_fields' => 'Si us plau, completa tots els camps obligatoris.',
            'database_error' => 'Error en desar els canvis.',
            'password_mismatch' => 'Les contrasenyes no coincideixen.',
            'password_empty' => 'Has d\'introduir ambdues contrasenyes.',
            default => 'S\'ha produït un error.'
        };
        echo '<div class="error-message"> ' . esc($message) . '</div>';
    endif; ?>

    <div class="vm-card">
        <div class="vm-header">
            <div class="vm-info">
                <!-- Mostra el nom i el correu electrònic del client -->
                <h3 class="vm-hostname"><?php echo esc($cliente['nombre']); ?></h3>
                <div class="vm-ip"><?php echo esc($cliente['email']); ?></div>
            </div>
            <span class="vm-status status-completado">perfil actiu</span>
        </div>

        <div class="vm-body">
            <!-- Formulari per actualitzar el perfil -->
            <form action="actualizar_perfil.php" method="post" class="form">
                <!-- Camp per introduir el nom del client -->
                <div class="form-group">
                    <label for="nombre">Nom</label>
                    <input type="text" id="nombre" name="nombre" class="form-control" value="<?php echo esc($cliente['nombre']); ?>" required>
                </div>

                <!-- Camp per introduir el correu electrònic del client -->
                <div class="form-group">
                    <label for="email">Correu electrònic</label>
                    <input type="email" id="email" name="email" class="form-control" value="<?php echo esc($cliente['email']); ?>" required>
                </div>

                <!-- Camp per introduir el telèfon del client (opcional) -->
                <div class="form-group">
                    <label for="telefono">Telèfon</label>
                    <input type="text" id="telefono" name="telefono" class="form-control" value="<?php echo esc($cliente['telefono']); ?>">
                </div>

                <!-- Camp per introduir el nom de l'empresa del client (opcional) -->
                <div class="form-group">
                    <label for="empresa">Empresa</label>
                    <input type="text" id="empresa" name="empresa" class="form-control" value="<?php echo esc($cliente['empresa']); ?>">
                </div>

                <!-- Botó per enviar el formulari i desar els canvis -->
                <div class="form-submit">
                    <button type="submit" class="btn btn-primary">Desa els canvis</button>
                </div>
            </form>

            <hr style="margin: 2rem 0;">

            <!-- Formulari per canviar la contrasenya -->
            <form action="cambiar_password.php" method="post" class="form">
                <!-- Títol per separar la secció de canvi de contrasenya -->
                <div class="form-divider">Canviar contrasenya</div>

                <!-- Camp per introduir la nova contrasenya -->
                <div class="form-group">
                    <label for="nueva_password">Nova contrasenya</label>
                    <input type="password" id="nueva_password" name="nueva_password" class="form-control" required>
                </div>

                <!-- Camp per confirmar la nova contrasenya -->
                <div class="form-group">
                    <label for="confirmar_password">Confirma la contrasenya</label>
                    <input type="password" id="confirmar_password" name="confirmar_password" class="form-control" required>
                </div>

                <!-- Botó per enviar el formulari i actualitzar la contrasenya -->
                <div class="form-submit">
                    <button type="submit" class="btn btn-info">Actualitza la contrasenya</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
