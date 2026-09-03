<?= $this->extend('layout') ?>

<?= $this->section('contenido') ?>

<h1>Bienvenido a Barbería Corte Top</h1>

<p>En <strong>Barbería Corte Top</strong> nos especializamos en brindarte un servicio de calidad para que luzcas siempre a la altura. Nuestro equipo de profesionales está listo para atenderte.</p>

<p>Para asegurar tu lugar, podés solicitar tu turno de forma rápida y sencilla desde cualquier dispositivo.</p>

<p>
    <a class="btn btn-primario" href="<?= site_url('turnos/nuevo') ?>">Solicitar Nuevo Turno</a>
</p>

<?= $this->endSection() ?>
