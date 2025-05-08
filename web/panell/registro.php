<?php
require_once 'conexion.php';

// Variables per als missatges
$missatge = '';
$missatge_tipus = 'success';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['nombre'], $_POST['email'], $_POST['password'])) {
        $nom = trim($_POST['nombre']);
        $email = trim($_POST['email']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        try {
            // Inserir el nou client a la base de dades
            $stmt = $conn->prepare("INSERT INTO clientes (nombre, email, password_hash) VALUES (?, ?, ?)");
            $stmt->execute([$nom, $email, $password]);
            $missatge = 'Registre completat amb exit. Ja pots iniciar sessio.';
        } catch (PDOException $e) {
            // Missatge d'error si hi ha un problema amb la base de dades
            $missatge = 'Error en registrar l\'usuari: ' . $e->getMessage();
            $missatge_tipus = 'error';
        }
    } else {
        // Missatge d'error si falten camps
        $missatge = 'Si us plau, completa tots els camps.';
        $missatge_tipus = 'error';
    }
}
?>

<?php include 'header.php'; ?>
<link rel="stylesheet" href="dashboard.css">

<div class="container" style="max-width: 500px;">
    <div class="vm-card">
        <div class="vm-header">
            <h3 class="vm-hostname">Registre de client</h3> <!-- Títol del formulari -->
        </div>
        <div class="vm-body">
            <?php if ($missatge): ?>
                <!-- Mostra el missatge d'èxit o error -->
                <div class="<?php echo $missatge_tipus === 'error' ? 'error-message' : 'success-message'; ?>">
                    <?php echo htmlspecialchars($missatge); ?>
                </div>
            <?php endif; ?>

            <!-- Formulari de registre -->
            <form method="post" class="form">
                <div class="form-group">
                    <label for="nombre">Nom complet</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="email">Correu electrònic</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="password">Contrasenya</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>

                <div class="form-submit">
                    <button type="submit" class="btn btn-primary">Registrar-se</button>
                </div>
            </form>

            <!-- Enllaç per iniciar sessió -->
            <p style="margin-top: 1rem; text-align: center;">
                Ja tens un compte? <a href="login.php">Inicia sessió</a>
            </p>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
