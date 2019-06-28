<div class="table">
	<h1 class="table-title"><?php echo $_SESSION['country']['title'];?></h1>
	<div class="head-block">
		<div class="search">
			<form action="<?php echo ROOT_PATH; ?>cities/search" method="post">
				<div class="search-fields">
					<div class="search-group">
						<label>Raktažodis</label>
						<input name="search" class="form-field search-even-field" id="search" type="text" placeholder="Įveskite pavadinimą ar pašto kodą" value="<?php if(isset($_SESSION['citySearch'])): echo $_SESSION['citySearch']; endif;?>"/>
					</div>
					<div class="search-group">
						<label>Data</label>
						<input type="date" name="filter" class="form-field" value="<?php echo $_SESSION['cityFilter']; ?>">
					</div>
				</div>
				<div class="search-btn-grp">
					<input name="submit" type="submit" class="btn btn-pink" value="Paieška" />
					<a class="btn btn-blue" href="<?php echo ROOT_PATH; ?>cities/clear">Atstatyti</a>
				</div>
			</form>
		</div>
		<div class="new">
			<a class="btn" href="<?php echo ROOT_PATH; ?>cities/add">Pridėti naują</a>
			<a class="btn btn-nav" href="<?php echo ROOT_PATH; ?>countries">Šalys</a>
		</div>
	</div>
	<div class="wrapper">
		<?php if(count($viewmodel) > 0) :?>
		<table class="hovertable">
			<thead>
				<tr>
					<th>Pridėta</th>
					<th>Pavadinimas <a class="btn btn-danger" href="<?php echo ROOT_PATH; ?>cities/sortASC">↓</a> <a class="btn btn-danger" href="<?php echo ROOT_PATH; ?>cities/sortDESC">↑</a></th>
					<th>Plotas</th>
					<th>Populiacija</th>
					<th>Pašto kodas</th>
					<th colspan="2" scope="colgroup">Veiksmai</th>
				</tr>
			<thead>
			<tbody>
			<?php foreach($viewmodel as $item) :?>
					<tr>
						<td><?php echo $item['date'];?></td>
						<td><?php echo $item['title'];?></td>
						<td><?php echo $item['size'];?></td>
						<td><?php echo $item['population'];?></td>
						<td><?php echo $item['citycode'];?></td>
						<td>
						<form method="post" action="<?php echo ROOT_PATH; ?>cities/edit">
							<input type="hidden" name="id" value="<?php echo $item['id']; ?>" />
							<input type="submit" name="edit" class="btn btn-pink btn-table" value="Redaguoti">
						</form>
						</td>
						<td>
						<form method="post" action="<?php echo ROOT_PATH; ?>cities/delete">
							<input type="hidden" name="id" value="<?php echo $item['id']; ?>" />
							<input type="submit" name="delete" class="btn btn-blue btn-table" value="Ištrinti">
						</form></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<div class="paging-wrapper">
			<div id='paging' >
				<?php echo $_SESSION['pagination'];?>
			</div>
		</div>
	</div>
			<?php else: ?>
			<div class="no-result">
				<p>Nėra rezultatų.</p>
				</div>
			<?php endif;?>
</div>