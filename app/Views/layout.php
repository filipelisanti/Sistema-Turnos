<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barbería Corte Top</title>
    <link rel="stylesheet" href="<?= base_url('css/estilos.css') . '?v=' . filemtime(FCPATH . 'css/estilos.css') ?>">
    <?= $this->renderSection('styles') ?>
</head>
<body>
    <header class="header">
        <a class="header-marca" href="<?= site_url('inicio') ?>">Barbería Corte Top</a>

        <?php if (session()->get('profesional_id')): ?>
            <nav class="nav-usuario">
                <a class="nav-usuario-link" href="<?= site_url('turnos') ?>">Lista de turnos</a>
                <a class="nav-usuario-link" href="<?= site_url('mi-cuenta') ?>">Mi cuenta</a>
                <span class="nav-usuario-nombre"><?= esc(session()->get('profesional_nombre')) ?></span>
                <a class="nav-usuario-link nav-usuario-salir" href="<?= site_url('logout') ?>">Cerrar sesión</a>
            </nav>
        <?php else: ?>
            <nav class="dropdown">
                <button class="dropdown-boton" type="button" id="menuBoton" aria-haspopup="true" aria-expanded="false">
                    Menú
                </button>
                <ul class="dropdown-menu" id="menuDesplegable">
                    <li><a class="dropdown-item" href="<?= site_url('inicio') ?>">Inicio</a></li>
                    <li><a class="dropdown-item" href="<?= site_url('quienes-somos') ?>">Quiénes somos</a></li>
                    <li><a class="dropdown-item" href="<?= site_url('turnos/nuevo') ?>">Solicitar Nuevo Turno</a></li>
                    <li><a class="dropdown-item" href="<?= site_url('login') ?>">Iniciar Sesión</a></li>
                </ul>
            </nav>
        <?php endif; ?>
    </header>

    <main class="contenido">
        <div class="container">
            <?php if (session()->getFlashdata('mensaje')): ?>
                <p class="flash flash-mensaje"><?= esc(session()->getFlashdata('mensaje')) ?></p>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <p class="flash flash-error"><?= esc(session()->getFlashdata('error')) ?></p>
            <?php endif; ?>

            <?= $this->renderSection('contenido') ?>
        </div>
    </main>

    <footer class="footer">
        <p>Desarrollado por: <strong>Santiago Filipeli</strong></p>
        <p>
            Mi GitHub:
            <a href="https://github.com/filipelisanti" target="_blank" rel="noopener">https://github.com/filipelisanti</a>
        </p>
        <p>© <?= date('Y') ?> Barbería Corte Top. Todos los derechos reservados.</p>
    </footer>

    <script src="<?= base_url('js/app.js') . '?v=' . filemtime(FCPATH . 'js/app.js') ?>"></script>
    <?= $this->renderSection('scripts') ?>
</body>
</html>
