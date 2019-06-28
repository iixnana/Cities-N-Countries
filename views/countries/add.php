<div class="form">
<h1 class="form-title">Nauja šalis</h1>
	<form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
		<div class="form-group">
			<label>Pavadinimas</label>
			<input type="text" name="title" class="form-field" value="<?php echo $_SESSION['add']['title']; ?>">
		</div>
		<div class="form-group">
			<label>Plotas</label>
		<input type="text" name="size" class="form-field" value="<?php echo $_SESSION['add']['size']; ?>">
		</div>
		<div class="form-group">
			<label>Populiacija</label>
			<input type="text" name="population" class="form-field" value="<?php echo $_SESSION['add']['population']; ?>">
		</div>
		<div class="form-group">
			<label>Tel. kodas</label>
			<input type="text" name="dialcode" class="form-field" value="<?php echo $_SESSION['add']['dialcode']; ?>">
		</div>
		<div class="form-btn-grp">
		<input type="submit" name="submit" class="btn btn-pink" value="Įrašyti">
		<a class="btn btn-blue" href="<?php echo ROOT_PATH; ?>countries">Atšaukti</a>
		</div>
	</form>
</div>