<?php
include 'db_connect.php';
$fees = $conn->query("SELECT ef.*,s.name as sname,s.id_no,concat(c.course,' - ',c.level) as `class` FROM student_ef_list ef inner join student s on s.id = ef.student_id inner join courses c on c.id = ef.course_id  where ef.id = {$_GET['ef_id']}");
foreach ($fees->fetch_array() as $k => $v) {
	$$k = $v;
}
$payments = $conn->query("SELECT * FROM payments where ef_id = $id ");
$pay_arr = array();
while ($row = $payments->fetch_array()) {
	$pay_arr[$row['id']] = $row;
}
?>

<style>
	.flex {
		display: inline-flex;
		width: 100%;
	}

	.w-50 {
		width: 50%;
	}

	.text-center {
		text-align: center;
	}

	.text-right {
		text-align: right;
	}

	table.wborder {
		width: 100%;
		border-collapse: collapse;
	}

	table.wborder>tbody>tr,
	table.wborder>tbody>tr>td {
		border: 1px solid;
	}

	p {
		margin: unset;
	}
</style>
<div class="container-fluid">
	<p class="text-center"><b><?php echo $_GET['pid'] == 0 ? "Reporte de pagos" : 'Recibo de Pago' ?></b></p>
	<hr>
	<span style="font-size:1rem; font-weight:bold;">Importante </span>
	<span>Apreciado estudiante usted se encuentra con un saldo en mora en su <span style="font-size:1rem; font-weight:bold;">CREDITO ESTUDIANTIL,</span> debe cancelar en la fecha estipulada en este informe, el no pago traeria como consecuencia la suspencion de su <span style="font-size:1rem; font-weight:bold;">MATRICULA.</span></span>
	<p><span style="font-size:1rem; font-weight:bold;">ESPERAMOS SU PRONTO PAGO,</span> si usted se encuentra al dia en sus obligaciones haga caso omiso a este anuncio.</p>
	<h1 class="text-center mb-5"><img src="assets/uploads/emprender.jpeg" width="249px"></h1>
	<div class="flex">
		<div class="w-50">
			<p>No de Inscripción: <b><?php echo $ef_no ?></b></p>
			<p>Estudiante: <b><?php echo ucwords($sname) ?></b></p>
			<p>Curso/Nivel: <b><?php echo $class ?></b></p>
			<p>Fecha Inicio de Clases: <b><?php echo $inicioclases ?></b></p>
		
			
		</div>
		<?php if ($_GET['pid'] > 0) : ?>
			<div class="w-50">
				<p>Fecha de Pago: <b><?php echo isset($pay_arr[$_GET['pid']]) ? date("M d,Y", strtotime($pay_arr[$_GET['pid']]['date_created'])) : '' ?></b></p>
				<p>Monto de Pago: <b><?php echo isset($pay_arr[$_GET['pid']]) ? number_format($pay_arr[$_GET['pid']]['amount'], 2) : '' ?></b></p>
				<p>Observación: <b><?php echo isset($pay_arr[$_GET['pid']]) ? $pay_arr[$_GET['pid']]['remarks'] : '' ?></b></p>
				<p>N.Factura: <b><?php echo isset($pay_arr[$_GET['pid']]) ? $pay_arr[$_GET['pid']]['nfactura'] : '' ?></b></p>
				<p>Arqueo: <b><?php echo isset($pay_arr[$_GET['pid']]) ? $pay_arr[$_GET['pid']]['arqueo'] : '' ?></b></p>
			</div>
		<?php endif; ?>
	</div>
	<hr>
	<p><b>Resumen de Pago</b></p>
	<table class="wborder">
		<tr>
			<td width="50%">
				<p><b>Detalles de la tarifa</b></p>
				<hr>
				<table width="100%">
					<tr>
						<td width="50%">Tipo de tarifa</td>
					</tr>
					<?php
					$cfees = $conn->query("SELECT * FROM fees where course_id = $course_id");
					$ftotal = 0; // 0 
					while ($row = $cfees->fetch_assoc()) {
						$ftotal += $row['amount'];
					?>
						<tr>
							<td><b><?php echo $row['description'] ?></b></td>
						</tr>
					<?php
					}
					?>
					<tr>
					
					</tr>
				</table>
			</td>
			<td width="50%">
				<p><b>Información de Pago</b></p>
				<table width="100%" class="wborder">
					<tr>
						<td width="50%">Fecha</td>
						<td width="50%" class='text-right'>N.Factura</td>
						<td width="50%" class='text-right'>Arqueo</td>
						<td width="50%" class='text-right'>Monto</td>
						
					</tr>
					<?php
					$ptotal = 0;
					foreach ($pay_arr as $row) {
						if ($row["id"] <= $_GET['pid'] || $_GET['pid'] == 0) {
							$ptotal += $row['amount'];
					?>
							<tr>
								<td><b><?php echo date("Y-m-d", strtotime($row['date_created'])) ?></b></td>
								<td class='text-right'><b><?php echo ($row['nfactura']) ?></b></td>
								<td class='text-right'><b><?php echo ($row['arqueo']) ?></b></td>
								<td class='text-right'><b><?php echo number_format($row['amount']) ?></b></td>
								
							</tr>
					<?php
						}
					}
					?>
					<tr>
						<th colspan="3">Total</th>
						<th class='text-right'><b><?php echo number_format($ptotal) ?></b></th>
					</tr>
				</table>
				<table width="100%">
					<tr>
						<td>Balance</td>
						<td class='text-right'><b><?php echo number_format($ftotal - $ptotal) ?></b></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<center>
	<br>
	<br>	
	<span style="font-size:1rem; font-weight:bold;">Centro de formacion empresarial Emptrender</span>
	<br>
	<span style="font-size:1rem; font-weight:;">Carrera 14 # 20-15, segundo piso</span>
	<br>
	<span style="font-size:1rem; font-weight:;">Tel: 314 572 08 54</span>
	<br>
	<span style="font-size:1rem; font-weight:;">Nit 13 016 724-1</span>
	</center>
</div>