<?= $this->extend('layout') ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="<?= base_url('css/turnos.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('contenido') ?>

<h1>Turno #<?= esc($turno['id']) ?></h1>

<div class="detail-card">
    <div class="detalle-grid">
        <div class="detalle-item">
            <span class="etiqueta">Fecha</span>
            <span class="valor"><?= esc($turno['fecha']) ?></span>
        </div>
        <div class="detalle-item">
            <span class="etiqueta">Hora</span>
            <span class="valor"><?= esc($turno['hora_inicio']) ?> - <?= esc($turno['hora_fin']) ?></span>
        </div>
        <div class="detalle-item">
            <span class="etiqueta">Estado</span>
            <span class="valor"><span class="badge badge-<?= esc($turno['estado']) ?>"><?= esc($turno['estado']) ?></span></span>
        </div>
        <div class="detalle-item">
            <span class="etiqueta">Cliente</span>
            <span class="valor"><?= esc($turno['usuario_nombre']) ?></span>
        </div>
        <div class="detalle-item">
            <span class="etiqueta">Profesional</span>
            <span class="valor"><?= esc($turno['profesional_nombre']) ?></span>
        </div>
    </div>

    <a class="btn btn-secundario" href="<?= site_url('turnos') ?>">Volver al listado</a>
</div>

<?= $this->endSection() ?>
