<div class="form">
<h1 class="form-title">Redaguojamas miestas</h1>
	<form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
		<div class="form-group">
			<label>Pavadinimas</label>
			<input type="text" name="title" class="form-field" value="<?php echo $viewmodel['title'];?>">
		</div>
		<div class="form-group">
			<label>Plotas</label>
			<input type="text" name="size" class="form-field" value="<?php echo $viewmodel['size'];?>">
		</div>
		<div class="form-group">
			<label>Populiacija</label>
			<input type="text" name="population" class="form-field" value="<?php echo $viewmodel['population'];?>">
		</div>
		<div class="form-group">
			<label>Pašto kodas</label>
			<input type="text" name="citycode" class="form-field" value="<?php echo $viewmodel['citycode'];?>">
		</div>
		<input type="hidden" name="id" value="<?php echo $viewmodel['id']; ?>" />
		<div class="form-btn-grp">	
			<input type="hidden" name="exSize" value="<?php echo $viewmodel['size']; ?>" />
			<input type="hidden" name="exPop" value="<?php echo $viewmodel['population']; ?>" />
			<input type="submit" name="submit" class="btn btn-pink" value="Išsaugoti">
			<a class="btn btn-blue" href="<?php echo ROOT_PATH; ?>cities">Atšaukti</a>
		</div>
	 </form>
 </div>