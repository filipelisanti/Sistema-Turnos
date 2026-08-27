<?= $this->extend('layout') ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="<?= base_url('css/turnos.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('contenido') ?>

<h1>Nuevo turno</h1>

<form action="<?= site_url('turnos') ?>" method="post" id="form-turno" class="form-card">
    <?= csrf_field() ?>

    <label for="nombre">Nombre del cliente:</label>
    <input type="text" name="nombre" id="nombre" value="<?= old('nombre') ?>" required>

    <label for="email">Email:</label>
    <input type="email" name="email" id="email" value="<?= old('email') ?>" required>

    <label for="telefono">Teléfono:</label>
    <input type="tel" name="telefono" id="telefono" value="<?= old('telefono') ?>">

    <label for="profesional_id">Profesional:</label>
    <select name="profesional_id" id="profesional_id" required>
        <option value="">-- Seleccionar --</option>
        <?php foreach ($profesionales as $profesional): ?>
            <option value="<?= $profesional['id'] ?>" <?= $profesionalSeleccionado == $profesional['id'] ? 'selected' : '' ?>>
                <?= esc($profesional['nombre']) ?> (<?= esc($profesional['especialidad']) ?>)
            </option>
        <?php endforeach; ?>
    </select>

    <label for="fecha">Fecha:</label>
    <input type="date" name="fecha" id="fecha" value="<?= esc($fechaSeleccionada) ?>" required>

    <h2>Disponibilidad del día</h2>
    <table id="tabla-horarios">
        <thead>
            <tr><th>Hora</th><th>Estado</th></tr>
        </thead>
        <tbody>
            <?php foreach (range(9, 19) as $h): ?>
                <?php $hora = sprintf('%02d:00', $h); ?>
                <?php $ocupada = in_array($hora, $horasOcupadas); ?>
                <tr data-hora="<?= $hora ?>" class="<?= $ocupada ? 'ocupada' : 'libre' ?>">
                    <td><span class="hora-rango"><?= $hora ?> - <?= sprintf('%02d:00', $h + 1) ?></span></td>
                    <td><?= $ocupada ? '<em>Ocupado</em>' : '<em>Disponible</em>' ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <input type="hidden" name="hora_inicio" id="hora_inicio">
    <input type="hidden" name="hora_fin" id="hora_fin">

    <div class="form-actions">
        <button type="button" id="ver-disponibilidad" class="btn btn-secundario"
            data-url="<?= site_url('turnos/nuevo') ?>">Ver disponibilidad</button>
        <button type="submit" id="btn-crear" class="btn btn-primario" disabled>Crear turno</button>
    </div>
</form>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="<?= base_url('js/turnos.js') ?>"></script>
<?= $this->endSection() ?>
