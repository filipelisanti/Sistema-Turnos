<?= $this->extend('layout') ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="<?= base_url('css/turnos.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('contenido') ?>

<h1>Turnos</h1>

<table class="tabla-turnos">
    <thead>
        <tr>
            <th>Numero de Turno</th>
            <th>Usuario</th>
            <th>Profesional</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($turnos as $turno): ?>
            <tr>
                <td><?= esc($turno['id']) ?></td>
                <td><?= esc($turno['usuario_nombre']) ?></td>
                <td><?= esc($turno['profesional_nombre']) ?></td>
                <td><?= esc($turno['fecha']) ?></td>
                <td><?= esc($turno['hora_inicio']) ?> - <?= esc($turno['hora_fin']) ?></td>
                <td><span class="badge badge-<?= esc($turno['estado']) ?>"><?= esc($turno['estado']) ?></span></td>
                <td class="acciones">
                    <a class="btn btn-ver" href="<?= site_url("turnos/{$turno['id']}") ?>">Ver</a>

                    <?php if ($turno['estado'] === 'pendiente'): ?>
                        <form action="<?= site_url("turnos/{$turno['id']}/confirmar") ?>" method="post" style="display:inline" data-confirm="¿Confirmar este turno?">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-confirmar">Confirmar</button>
                        </form>
                    <?php endif; ?>

                    <?php if (in_array($turno['estado'], ['pendiente', 'confirmado'])): ?>
                        <form action="<?= site_url("turnos/{$turno['id']}/cancelar") ?>" method="post" style="display:inline" data-confirm="¿Cancelar este turno?">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-cancelar">Cancelar</button>
                        </form>
                    <?php endif; ?>

                    <?php if ($turno['estado'] === 'confirmado'): ?>
                        <form action="<?= site_url("turnos/{$turno['id']}/completar") ?>" method="post" style="display:inline" data-confirm="¿Marcar este turno como completado?">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-completar">Completar</button>
                        </form>
                    <?php endif; ?>

                    <form action="<?= site_url("turnos/{$turno['id']}/delete") ?>" method="post" style="display:inline" data-confirm="¿Eliminar este turno definitivamente? Esta acción no se puede deshacer.">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-eliminar">Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection() ?>
