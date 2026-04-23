<?php
include 'db.php';
$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = trim($_POST['username']);
    $pass = $_POST['password'];

    if (!empty($user) && !empty($pass)) {
        $hash = password_hash($pass, PASSWORD_BCRYPT);
        $stmt = $pdo->prepare("INSERT INTO usuarios (username, password) VALUES (?, ?)");
        try {
            $stmt->execute([$user, $hash]);
            $mensaje = "¡Cuenta creada con éxito! Ya puedes iniciar sesión.";
            $tipo_mensaje = "success";
        } catch (Exception $e) {
            $mensaje = "Error: El nombre de usuario ya está en uso.";
            $tipo_mensaje = "error";
        }
    } else {
        $mensaje = "Por favor, rellena todos los campos.";
        $tipo_mensaje = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro | WebManager</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-[#F0F4F8] min-h-screen flex items-center justify-center font-sans">

    <div class="w-full max-w-md mx-4">
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-[#D9E2EC] p-8">
            
            <div class="text-center mb-8">
                <div class="bg-[#F0F4F8] w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-user-plus text-[#00B5AD] text-2xl"></i>
                </div>
                <h2 class="text-3xl font-bold text-[#243B55]">Crear Cuenta</h2>
                <p class="text-[#627D98] mt-2">Únete a WebManager hoy mismo</p>
            </div>

            <?php if ($mensaje): ?>
                <div class="mb-6 p-4 rounded-xl text-sm flex items-center gap-3 <?php echo $tipo_mensaje == 'success' ? 'bg-green-50 text-green-700 border border-green-100' : 'bg-red-50 text-red-700 border border-red-100'; ?>">
                    <i class="fas <?php echo $tipo_mensaje == 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'; ?>"></i>
                    <?php echo $mensaje; ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="space-y-5">
                <div>
                    <label class="block text-sm font-semibold text-[#243B55] mb-2 ml-1">Nombre de Usuario</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-[#627D98]">
                            <i class="fas fa-user"></i>
                        </span>
                        <input type="text" name="username" placeholder="Tu usuario" required
                               class="w-full pl-11 pr-4 py-3.5 bg-[#F0F4F8] border border-[#D9E2EC] rounded-2xl focus:ring-2 focus:ring-[#00B5AD]/30 focus:border-[#00B5AD] outline-none transition-all">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-[#243B55] mb-2 ml-1">Contraseña</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-[#627D98]">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="password" name="password" placeholder="••••••••" required
                               class="w-full pl-11 pr-4 py-3.5 bg-[#F0F4F8] border border-[#D9E2EC] rounded-2xl focus:ring-2 focus:ring-[#00B5AD]/30 focus:border-[#00B5AD] outline-none transition-all">
                    </div>
                </div>

                <button type="submit" 
                        class="w-full bg-[#243B55] hover:bg-[#1a2c40] text-white font-bold py-4 rounded-2xl shadow-lg transition-all transform hover:-translate-y-1">
                    Registrarse Ahora
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-[#D9E2EC] text-center">
                <p class="text-[#627D98] text-sm">
                    ¿Ya tienes una cuenta? 
                    <a href="login.php" class="text-[#00B5AD] font-bold hover:underline ml-1">Inicia sesión</a>
                </p>
            </div>
        </div>
        
        <p class="text-center text-[#627D98] text-xs mt-8 uppercase tracking-widest">WebManager &copy; 2026</p>
    </div>

</body>
</html>