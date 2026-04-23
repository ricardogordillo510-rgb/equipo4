<?php
session_start();
// Si ya está logueado, lo mandamos al panel directamente
if (isset($_SESSION['user_id'])) {
    header("Location: panel.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido a WebManager</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-[#F0F4F8] min-h-screen flex items-center justify-center font-sans antialiased">

    <div class="max-w-4xl w-full mx-4 grid grid-cols-1 md:grid-cols-2 bg-white rounded-3xl shadow-2xl overflow-hidden border border-[#D9E2EC]">
        
        <div class="bg-[#243B55] p-12 text-white flex flex-col justify-center items-center text-center">
            <i class="fas fa-cubes text-6xl text-[#00B5AD] mb-6"></i>
            <h1 class="text-4xl font-bold mb-4 tracking-tight">WebManager</h1>
            <p class="text-[#D9E2EC] text-lg">La plataforma más limpia y rápida para gestionar tus proyectos web en un solo lugar.</p>
        </div>

        <div class="p-12 flex flex-col justify-center bg-white">
            <h2 class="text-2xl font-bold text-[#243B55] mb-2">Comencemos</h2>
            <p class="text-[#627D98] mb-8">Inicia sesión o crea una cuenta nueva para empezar a guardar tus sitios.</p>
            
            <div class="space-y-4">
                <a href="login.php" class="block w-full text-center bg-[#00B5AD] hover:bg-[#009791] text-white font-bold py-4 rounded-2xl shadow-lg shadow-[#00B5AD]/20 transition-all transform hover:-translate-y-1">
                    <i class="fas fa-sign-in-alt mr-2"></i> Iniciar Sesión
                </a>
                
                <a href="registro.php" class="block w-full text-center border-2 border-[#D9E2EC] text-[#243B55] hover:bg-[#F0F4F8] font-bold py-4 rounded-2xl transition-all">
                    <i class="fas fa-user-plus mr-2"></i> Crear Cuenta
                </a>
            </div>

            <p class="mt-8 text-center text-xs text-[#627D98] uppercase tracking-widest">v 1.0.2 - 2026</p>
        </div>

    </div>

</body>
</html>