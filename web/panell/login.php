<?php

require_once __DIR__ . '/../includes/session_handler.php';
require_once 'conexion.php';

// Array per emmagatzemar errors
$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtenir i netejar les dades del formulari
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $recordarme = isset($_POST['recordarme']); // Comprova si s'ha seleccionat "Recorda'm"

    // Consulta per obtenir les dades del client
    $stmt = $conn->prepare("SELECT id, nombre, password_hash FROM clientes WHERE email = :email");
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($cliente) {
        // Verifica si la contrasenya és correcta
        if (password_verify($password, $cliente['password_hash'])) {
            // Guarda les dades del client a la sessió
            $_SESSION['cliente_id'] = $cliente['id'];
            $_SESSION['cliente_nombre'] = $cliente['nombre'];

            // Si s'ha seleccionat "Recorda'm", crea una cookie
            if ($recordarme) {
                setcookie("cliente_id", $cliente['id'], time() + (86400 * 7), "/");
            }

            // Redirigeix al tauler de control
            header("Location: dashboard.php");
            exit();
        } else {
            // Afegeix un error si la contrasenya és incorrecta
            $errores[] = "Contrasenya incorrecta.";
        }
    } else {
        // Afegeix un error si el correu electrònic no es troba
        $errores[] = "Correu electrònic no trobat.";
    }
}
?>

<?php include 'header.php'; ?>
<link rel="stylesheet" href="dashboard.css">

<div class="container" style="max-width: 500px;">
    <div class="vm-card">
        <div class="vm-header">
            <h3 class="vm-hostname">Inicia sessió</h3> <!-- Títol del formulari -->
        </div>
        <div class="vm-body">
            <?php if (!empty($errores)): ?>
                <!-- Mostra els errors si n'hi ha -->
                <div class="error-message">
                    <?php foreach ($errores as $error): ?>
                        <div> <?php echo htmlspecialchars($error); ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Formulari d'inici de sessió -->
            <form method="post" class="form">
                <div class="form-group">
                    <label for="email">Correu electrònic</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="password">Contrasenya</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>
                        <input type="checkbox" name="recordarme">
                        Recorda'm
                    </label>
                </div>

                <div class="form-submit">
                    <button type="submit" class="btn btn-primary">Inicia sessió</button>
                </div>
            </form>

            <!-- Enllaç per registrar-se -->
            <p style="margin-top: 1rem; text-align: center;">
                No tens compte? <a href="registro.php">Registra't</a>
            </p>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>
