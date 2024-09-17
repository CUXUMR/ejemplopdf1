<h1>Reporte de ventas desde la vista</h1>
<p>Este reporte tiene [pagetotal] paginas</p>
<table class="simple-table">
    <h1>tarea de enviar pdf a travez del correo electronico</h1>
    <thead>
        <tr>
            <th>NO.</th>
            <th>Nombre cliente</th>
            <th>fecha venta</th>
            <th>producto</th>
            <th>cantidad</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($productos as $key => $producto): ?>
            <tr>
                <td><?= $key + 1 ?></td>
                <td><?= $producto['cliente'] ?> </td>
                <td><?= $producto['fecha_venta'] ?> </td>
                <td><?= $producto['producto'] ?> </td>
                <td><?= $producto['cantidad'] ?> </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>
<pagebreak resetpagenum="1" pagenumstyle="a" suppress="off" />