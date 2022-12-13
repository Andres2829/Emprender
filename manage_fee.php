<?php include 'db_connect.php' ?>
<?php
if (isset($_GET['id'])) {
	$qry = $conn->query("SELECT * FROM student_ef_list where id = {$_GET['id']} ");
	foreach ($qry->fetch_array() as $k => $v) {
		$$k = $v;
	}
}
?>
<div class="container-fluid">
	<form id="manage-fees">
		<div id="msg"></div>
		<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
		<div class="form-group">
			<label for="" class="control-label">Nº Matrícula/ Nº Curso</label>
			<input type="text" class="form-control" name="ef_no" value="<?php echo isset($ef_no) ? $ef_no : '' ?>" required>
		</div>
		<div class="form-group">
			<label for="" class="control-label">Estudiante</label>
			<select name="student_id" id="student_id" class="custom-select input-sm select2">
				<option value=""></option>
				<?php
				$student = $conn->query("SELECT * FROM student order by name asc ");
				while ($row = $student->fetch_assoc()) :
				?>
					<option value="<?php echo $row['id'] ?>" <?php echo isset($student_id) && $student_id == $row['id'] ? 'selected' : '' ?>><?php echo ucwords($row['name']) . ' | ' . $row['id_no'] ?></option>
				<?php endwhile; ?>
			</select>
		</div>
		<div class="form-group">
			<label for="" class="control-label">Programas Academicos</label>
			<select name="course_id" id="course_id" class="custom-select input-sm select2">
				<option value=""></option>
				<?php
				$student = $conn->query("SELECT *,concat(course,'-',level) as class FROM courses order by course asc ");
				while ($row = $student->fetch_assoc()) :
				?>
					<option value="<?php echo $row['id'] ?>" data-amount="<?php echo $row['total_amount'] ?>" <?php echo isset($course_id) && $course_id == $row['id'] ? 'selected' : '' ?>><?php echo $row['class'] ?></option>
				<?php endwhile; ?>
			</select>
		</div>
		<div class="form-group">
			<label for="" class="control-label">Tarifa</label>
			<input id="tarifa" type="text" class="form-control text-right" name="total_fee" value="<?php echo isset($total_fee) ? number_format($total_fee) : '' ?>">
		</div>
		<div class="form-group">
			<label for="" class="control-label">Cuotas</label>
			<input id="cuotas" type="number" step="any" min="0" class="form-control text-right" name="cuotas" value="<?php echo isset($cuotas) ? number_format($cuotas) : '' ?>">
		</div>

		<input type="button" onClick="multiplyBy()" 
        Value="Calcular Valor de Cuotas" /><br>
		<p> <br>
       <span id = "result" class="form-control text-right" name="valor_cuota" value="<?php echo isset($valor_cuota) ? number_format($valor_cuota) : '' ?>" ></span>
        </p>

		<div class="form-group">
			<label for="" class="control-label">Concepto</label>
			<input id="concepto" type="text" class="form-control text-right" name="concepto" value="<?php echo isset($concepto) ? number_format($concepto) : '' ?>">
		</div>

		<div class="form-group">
			<label for="" class="control-label">Fecha Inicio de Clases</label>
			<input type="datetime-local" class="form-control text-right" name="inicioclases" value="<?php echo isset($inicioclases)  ?>" required>
		</div>


	</form>
	


	<script>
    function multiplyBy()
    {
      num1 = document.getElementById(
        "tarifa").value;
      num2 = document.getElementById(
        "cuotas").value;
      document.getElementById(
        "result").innerHTML = ((parseFloat(num1) / parseFloat(num2))*1000000);

		
    }
  </script>
	
</div>

<script>
	$('.select2').select2({
		placeholder: 'Por favor seleccione aquí',
		width: '100%'
	})
	$('#course_id').change(function() {
		var amount = $('#course_id option[value="' + $(this).val() + '"]').attr('data-amount')
		$('[name="total_fee"]').val(parseFloat(amount).toLocaleString('en-US', {
			style: 'decimal',
			maximumFractionDigits: 2,
			minimumFractionDigits: 2
		}))
	})
	$('#manage-fees').submit(function(e) {
		e.preventDefault()
		start_load()
		$.ajax({
			url: 'ajax.php?action=save_fees',
			method: 'POST',
			data: $(this).serialize(),
			error: err => {
				console.log(err)
				end_load()
			},
			success: function(resp) {
				if (resp == 1) {
					location.reload();
					alert_toast("Datos guardados exitósamente", 'success')
					setTimeout(function() {
						location.reload()
					}, 1000)
				} else if (resp == 2) {
					$('#msg').html('<div class="alert alert-danger">Número de Curso Existe Actualmente</div>')
					end_load()
				}
			}
		})
	})
</script>