<?php
// --- LÓGICA PHP (Mantenemos la misma lógica funcional) ---
include 'db.php'; // Asegúrate de tener tu archivo de conexión
session_start();

// Verificación de sesión
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$message = '';

// Lógica para agregar página
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_page'])) {
    // Validación básica
    $nombre = trim($_POST['nombre']);
    $url = trim($_POST['url']);

    if (!empty($nombre) && !empty($url)) {
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            $stmt = $pdo->prepare("INSERT INTO paginas (usuario_id, nombre_sitio, url_sitio) VALUES (?, ?, ?)");
            try {
                $stmt->execute([$_SESSION['user_id'], $nombre, $url]);
                $message = "página agregada";
            } catch (Exception $e) {
                $message = "error";
            }
        } else {
            $message = "url_invalida";
        }
    } else {
        $message = "campos_vacios";
    }
}

// Consultar páginas del usuario actual
$stmt = $pdo->prepare("SELECT * FROM paginas WHERE usuario_id = ? ORDER BY id DESC");
$stmt->execute([$_SESSION['user_id']]);
$paginas = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WebManager | Tu Panel de Control Frío</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'frio-bg': '#F0F4F8',    /* Fondo general (Gris muy claro azulado) */
                        'frio-panel': '#FFFFFF', /* Fondo de paneles (Blanco puro) */
                        'frio-primary': '#243B55', /* Azul marino muy oscuro (Texto, acentos fuertes) */
                        'frio-secondary': '#627D98', /* Azul grisáceo medio (Texto secundario, bordes) */
                        'frio-accent': '#00B5AD', /* Cian brillante (Botones, enlaces) */
                        'frio-accent-hover': '#009791', /* Cian oscuro para hover */
                        'frio-border': '#D9E2EC' /* Color de borde ligero */
                    },
                    borderRadius: {
                        'xl-mod': '1rem', // Esquinas redondeadas modernas
                        '2xl-mod': '1.5rem'
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Pequeño toque de CSS personalizado para transiciones suaves globales */
        * { transition: all 0.2s ease-out; }
    </style>
</head>
<body class="bg-frio-bg text-frio-primary font-sans antialiased">

    <header class="bg-frio-panel shadow-sm border-b border-frio-border sticky top-0 z-50">
        <nav class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <i class="fas fa-layer-group text-frio-accent text-2xl"></i>
                <h1 class="text-2xl font-bold text-frio-primary tracking-tight">Web<span class="text-frio-secondary font-light">Manager</span></h1>
            </div>
            
            <div class="flex items-center gap-6">
                <div class="flex items-center gap-3">
                    <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($_SESSION['username']); ?>&background=D9E2EC&color=243B55&rounded=true&bold=true" 
                         alt="Avatar" class="w-10 h-10 rounded-full border border-frio-border">
                    <span class="font-medium text-frio-primary">
                        <?php echo htmlspecialchars($_SESSION['username']); ?>
                    </span>
                </div>
                <a href="logout.php" class="text-sm font-semibold text-frio-secondary hover:text-frio-accent flex items-center gap-2">
                    <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                </a>
            </div>
        </nav>
    </header>

    <main class="container mx-auto px-6 py-10">
        
        <div class="flex flex-col md:flex-row gap-10">
            
            <aside class="w-full md:w-1/3 flex-shrink-0">
                <div class="bg-frio-panel p-8 rounded-2xl-mod shadow-xl shadow-gray-200/50 border border-frio-border">
                    <div class="flex items-center gap-3 mb-6">
                        <i class="fas fa-plus-circle text-frio-accent text-xl"></i>
                        <h2 class="text-xl font-semibold text-frio-primary tracking-tight">Nuevo Proyecto</h2>
                    </div>

                    <?php if ($message == 'página agregada'): ?>
                        <div class="bg-green-50 text-green-700 p-4 rounded-xl-mod mb-5 text-sm flex items-center gap-2">
                            <i class="fas fa-check-circle"></i> ¡Sitio guardado exitosamente!
                        </div>
                    <?php elseif ($message == 'error' || $message == 'url_invalida' || $message == 'campos_vacios'): ?>
                        <div class="bg-red-50 text-red-700 p-4 rounded-xl-mod mb-5 text-sm flex items-center gap-2">
                            <i class="fas fa-exclamation-circle"></i> Error: Verifique los datos ingresados.
                        </div>
                    <?php endif; ?>

                    <form method="POST" class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-frio-secondary mb-1.5" for="nombre">Nombre del Sitio</label>
                            <input type="text" id="nombre" name="nombre" placeholder="Ej. Portafolio Pro" required 
                                   class="w-full px-4 py-3 border border-frio-border rounded-xl-mod bg-frio-bg/50 focus:ring-2 focus:ring-frio-accent/30 focus:border-frio-accent outline-none transition-colors">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-frio-secondary mb-1.5" for="url">URL del Sitio</label>
                            <input type="url" id="url" name="url" placeholder="https://..." required
                                   class="w-full px-4 py-3 border border-frio-border rounded-xl-mod bg-frio-bg/50 focus:ring-2 focus:ring-frio-accent/30 focus:border-frio-accent outline-none transition-colors">
                        </div>
                        <button type="submit" name="add_page" 
                                class="w-full bg-frio-accent hover:bg-frio-accent-hover text-white font-bold py-3.5 rounded-xl-mod transition shadow-lg shadow-frio-accent/20 flex items-center justify-center gap-2">
                            <i class="fas fa-cloud-upload-alt"></i> Guardar Sitio
                        </button>
                    </form>
                </div>
            </aside>

            <section class="w-full md:w-2/3">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-semibold text-frio-primary tracking-tight">Tus Sitios Registrados</h3>
                    <span class="text-sm font-medium text-frio-secondary bg-frio-panel px-4 py-1.5 rounded-full border border-frio-border">
                        Total: <?php echo count($paginas); ?>
                    </span>
                </div>
                
                <?php if (empty($paginas)): ?>
                    <div class="bg-frio-panel text-center py-16 px-8 rounded-2xl-mod border border-frio-border shadow-inner flex flex-col items-center">
                        <i class="fas fa-globe text-frio-border text-6xl mb-6"></i>
                        <h4 class="text-xl font-medium text-frio-secondary mb-2">Aún no hay sitios</h4>
                        <p class="text-frio-secondary/80 max-w-sm">Utiliza el panel lateral para agregar tu primera página web al sistema.</p>
                    </div>
                <?php else: ?>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <?php foreach ($paginas as $p): ?>
                            <div class="bg-frio-panel p-6 rounded-2xl-mod border border-frio-border shadow-sm hover:shadow-xl hover:shadow-frio-accent/5 hover:-translate-y-1 transform transition-all group flex flex-col justify-between">
                                <div>
                                    <div class="flex justify-between items-start gap-4 mb-3">
                                        <h4 class="font-bold text-lg text-frio-primary leading-tight truncate">
                                            <?php echo htmlspecialchars($p['nombre_sitio']); ?>
                                        </h4>
                                        <i class="fas fa-check text-xs bg-green-100 text-green-600 p-1.5 rounded-full flex-shrink-0"></i>
                                    </div>
                                    <p class="text-sm text-frio-secondary truncate bg-frio-bg p-2 rounded-lg mb-4 font-mono">
                                        <?php echo htmlspecialchars($p['url_sitio']); ?>
                                    </p>
                                </div>
                                <a href="<?php echo $p['url_sitio']; ?>" target="_blank" 
                                   class="text-frio-accent text-sm font-semibold uppercase tracking-wider flex items-center gap-2 group-hover:text-frio-accent-hover mt-2">
                                    Abrir Sitio <i class="fas fa-external-link-alt text-xs transition-transform group-hover:translate-x-1"></i>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </section>

        </div>
    </main>

</body>
</html>