<?= $this->extend('layout') ?>

<?= $this->section('contenido') ?>

<h1>Mi Cuenta</h1>

<p>Editá tus datos personales.</p>

<form class="form-card" action="<?= site_url('mi-cuenta/actualizar') ?>" method="post">
    <?= csrf_field() ?>

    <label for="nombre">Nombre</label>
    <input type="text" id="nombre" name="nombre" value="<?= esc(old('nombre', $profesional['nombre'])) ?>" required>

    <label for="especialidad">Especialidad</label>
    <input type="text" id="especialidad" name="especialidad" value="<?= esc(old('especialidad', $profesional['especialidad'])) ?>" required>

    <label for="email">Email</label>
    <input type="email" id="email" name="email" value="<?= esc(old('email', $profesional['email'])) ?>" required>

    <label for="telefono">Teléfono</label>
    <input type="text" id="telefono" name="telefono" value="<?= esc(old('telefono', $profesional['telefono'])) ?>">

    <label for="password">Nueva contraseña <span class="opcional">(opcional)</span></label>
    <input type="password" id="password" name="password" placeholder="Dejalo vacío para no cambiarla">

    <label for="password_confirm">Confirmar nueva contraseña <span class="opcional">(opcional)</span></label>
    <input type="password" id="password_confirm" name="password_confirm" placeholder="Repetí la nueva contraseña">

    <div class="form-actions">
        <button type="submit" class="btn btn-primario">Guardar cambios</button>
        <a class="btn btn-secundario" href="<?= site_url('turnos') ?>">Volver a mis turnos</a>
    </div>
</form>

<?= $this->endSection() ?>
