<div class="table">
<h1 class="table-title">Šalys</h1>
<div class="head-block">
	<div class="search">
		<form action="<?php echo ROOT_PATH; ?>countries/search" method="post">
		<div class="search-fields">
			<div class="search-group">
				<label>Raktažodis</label>
				<input name="search" id="search" class="form-field search-even-field" type="text" placeholder="Įveskite pavadinimą ar tel. kodą" value="<?php if(isset($_SESSION['countrySearch']))echo $_SESSION['countrySearch']?>"/>
			</div>
			<div class="search-group">
				<label>Data</label>
				<input type="date" name="filter" class="form-field" value="<?php echo $_SESSION['countryFilter']; ?>">
			</div>
		</div>
		<div class="search-btn-grp">
			<input name="submit" type="submit" class="btn btn-pink" value="Paieška" />
			<a class="btn btn-blue" href="<?php echo ROOT_PATH; ?>countries/clear">Atstatyti</a>
			</div>
		</form>
	</div>
	<div class="new">
		<a class="btn" href="<?php echo ROOT_PATH; ?>countries/add">Pridėti naują</a>
		<a class="btn btn-nav" href="<?php echo ROOT_PATH; ?>">Pagrindinis</a>
	</div>
</div>
<div class="wrapper">
	<?php if(count($viewmodel) > 0): ?>
	<table class="hovertable">
		<thead>
			<tr>
				<th>Pridėta</th>
				<th>Pavadinimas <a class="btn" href="<?php echo ROOT_PATH; ?>countries/sortASC">↓</a> <a class="btn" href="<?php echo ROOT_PATH; ?>countries/sortDESC">↑</a></th>
				<th>Plotas</th>
				<th>Populiacija</th>
				<th>Tel. kodas</th>
				<th>Miestai</th>
				<th colspan="2" scope="colgroup">Veiksmai</th>

			</tr>
		<thead>
		<tbody>
		<?php foreach($viewmodel as $item) : ?>
				<tr>
					<td><?php echo $item['date'];?></td>
					<td><?php echo $item['title'];?></td>
					<td><?php echo $item['size'];?></td>
					<td><?php echo $item['population'];?></td>
					<td><?php echo $item['dialcode'];?></td>
					<td>
					<form method="post" action="<?php echo ROOT_PATH; ?>countries/getCities">
						<input type="hidden" name="id" value="<?php echo $item['id']; ?>" />
						<input type="hidden" name="title" value="<?php echo $item['title']; ?>" />
						<input type="hidden" name="size" value="<?php echo $item['size']; ?>" />
						<input type="hidden" name="population" value="<?php echo $item['population']; ?>" />
						<input type="submit" name="view" class="btn btn-table" value="Peržiūrėti">
					</form>
					</td>
					<td>
					<form method="post" action="<?php echo ROOT_PATH; ?>countries/edit">
						<input type="hidden" name="id" value="<?php echo $item['id']; ?>" />
						<input type="submit" name="edit" class="btn btn-pink btn-table" value="Redaguoti">
					</form>
					</td>
					<td>
					<form method="post" action="<?php echo ROOT_PATH; ?>countries/delete">
						<input type="hidden" name="id" value="<?php echo $item['id']; ?>" />
						<input type="submit" name="delete" class="btn btn-blue btn-table" value="Šalinti">
					</form>
					</td>
					
				</tr>
			<?php endforeach;?>
		</tbody>
	</table>
	<div class="paging-wrapper">
		<div id='paging'>
			<?php echo $_SESSION['pagination'];?>
		</div>
	</div>
	<?php else: ?>
	</div>
	<div class="no-result">
		<p>Nėra rezultatų.</p>
	</div>
	<?php endif;?>
	
</div>