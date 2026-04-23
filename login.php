<?php
include 'db.php';
session_start();
$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_input = trim($_POST['username']);
    $pass_input = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE username = ?");
    $stmt->execute([$user_input]);
    $user = $stmt->fetch();

    if ($user && password_verify($pass_input, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: panel.php");
        exit;
    } else {
        $error = "Usuario o contraseña incorrectos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | WebManager</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-[#F0F4F8] min-h-screen flex items-center justify-center font-sans">

    <div class="w-full max-w-md mx-4">
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-[#D9E2EC] p-8">
            
            <div class="text-center mb-8">
                <div class="bg-[#F0F4F8] w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-key text-[#00B5AD] text-2xl"></i>
                </div>
                <h2 class="text-3xl font-bold text-[#243B55]">Bienvenido</h2>
                <p class="text-[#627D98] mt-2">Ingresa tus credenciales para continuar</p>
            </div>

            <?php if ($error): ?>
                <div class="mb-6 p-4 bg-red-50 text-red-700 border border-red-100 rounded-xl text-sm flex items-center gap-3">
                    <i class="fas fa-exclamation-circle"></i>
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="space-y-6">
                <div>
                    <label class="block text-sm font-semibold text-[#243B55] mb-2 ml-1">Usuario</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-[#627D98]">
                            <i class="fas fa-at"></i>
                        </span>
                        <input type="text" name="username" placeholder="Tu nombre de usuario" required
                               class="w-full pl-11 pr-4 py-3.5 bg-[#F0F4F8] border border-[#D9E2EC] rounded-2xl focus:ring-2 focus:ring-[#00B5AD]/30 focus:border-[#00B5AD] outline-none transition-all">
                    </div>
                </div>

                <div>
                    <div class="flex justify-between mb-2 ml-1">
                        <label class="text-sm font-semibold text-[#243B55]">Contraseña</label>
                    </div>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-[#627D98]">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="password" name="password" placeholder="••••••••" required
                               class="w-full pl-11 pr-4 py-3.5 bg-[#F0F4F8] border border-[#D9E2EC] rounded-2xl focus:ring-2 focus:ring-[#00B5AD]/30 focus:border-[#00B5AD] outline-none transition-all">
                    </div>
                </div>

                <button type="submit" 
                        class="w-full bg-[#00B5AD] hover:bg-[#009791] text-white font-bold py-4 rounded-2xl shadow-lg shadow-[#00B5AD]/20 transition-all transform hover:-translate-y-1">
                    Entrar al Panel
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-[#D9E2EC] text-center">
                <p class="text-[#627D98] text-sm">
                    ¿No tienes una cuenta? 
                    <a href="registro.php" class="text-[#243B55] font-bold hover:text-[#00B5AD] transition-colors ml-1">Regístrate ahora</a>
                </p>
            </div>
        </div>
        
        <p class="text-center text-[#627D98] text-xs mt-8 uppercase tracking-widest">WebManager &copy; 2026</p>
    </div>

</body>
</html>