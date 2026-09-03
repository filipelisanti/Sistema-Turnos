<?= $this->extend('layout') ?>

<?= $this->section('contenido') ?>

<h1>Quiénes somos</h1>

<p><strong>Barbería Corte Top</strong> nació con la idea de ofrecer un espacio moderno y acogedor donde el buen corte y la atención personalizada son la prioridad.</p>

<p>Contamos con barberos profesionales apasionados por su oficio, brindando servicios de corte de cabello, arreglo de barba y cuidado personal en un ambiente de confianza.</p>

<p>Te esperamos para que vivas la experiencia <strong>Corte Top</strong>.</p>

<p>
    <a class="btn btn-primario" href="<?= site_url('turnos/nuevo') ?>">Solicitar tu turno</a>
</p>

<?= $this->endSection() ?>
