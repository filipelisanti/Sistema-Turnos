<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Turnos</title>
    <link rel="stylesheet" href="<?= base_url('css/estilos.css') ?>">
    <?= $this->renderSection('styles') ?>
</head>
<body>
    <nav class="navbar">
        <a href="<?= site_url('turnos') ?>">Ver turnos</a>
        <a href="<?= site_url('turnos/nuevo') ?>">Nuevo turno</a>
    </nav>

    <div class="container">
        <?php if (session()->getFlashdata('mensaje')): ?>
            <p class="flash flash-mensaje"><?= esc(session()->getFlashdata('mensaje')) ?></p>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <p class="flash flash-error"><?= esc(session()->getFlashdata('error')) ?></p>
        <?php endif; ?>

        <?= $this->renderSection('contenido') ?>
    </div>

    <script src="<?= base_url('js/app.js') ?>"></script>
    <?= $this->renderSection('scripts') ?>
</body>
</html>
