<?= $this->extend('layout') ?>

<?= $this->section('contenido') ?>

<h1>Iniciar Sesión</h1>

<p>Accedé con tus credenciales de barbero para gestionar tus turnos.</p>

<form class="form-card" action="<?= site_url('login') ?>" method="post">
    <?= csrf_field() ?>

    <label for="email">Email</label>
    <input type="email" id="email" name="email" value="<?= esc(old('email')) ?>" required autofocus>

    <label for="password">Contraseña</label>
    <input type="password" id="password" name="password" required>

    <div class="form-actions">
        <button type="submit" class="btn btn-primario">Ingresar</button>
        <a class="btn btn-secundario" href="<?= site_url('inicio') ?>">Volver</a>
    </div>
</form>

<?= $this->endSection() ?>
