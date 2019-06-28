<?php
class CountryModel extends Model{
	private $table = 'country';
	
	public function Index($page){
		$set = $this->paging($this->table, $page, $_SESSION['sort']);
		$_SESSION['pagination'] = $this->pagination($this->table,5,$page);
		return $set;
	}
	
	public function edit($id){
		$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
		if(isset($_POST['submit']) && $_POST['submit'] && $this->validate($_POST['title'], $_POST['size'], $_POST['population'], $_POST['dialcode'], $_POST['usedSpace'], $_POST['usedPopulation'])){
			// Insert into MySQL
			$this->updateValue('UPDATE country SET title = \''.$_POST['title'].'\', size = '.$_POST['size'].', population = '.$_POST['population'].', dialcode = \''.$_POST['dialcode'].'\' WHERE id = '.$id);
			$_POST['submit'] = true;
			return true;
		}
		else {
			$_POST['submit'] = false;
			$this->query('SELECT * FROM country WHERE id = '.$id.';');
			$result = $this->single();
			return $result;
		}
	}
	
	public function delete($id){

		if(!is_numeric($id) || !is_int($id + 0) || $id < 0)
		{
			Messages::setMsg('Įvyko klaida mėginant ištrinti pasirinktą įrašą: Netinkamas ID', 'error');
			return;
		}
		
		$this->query("SELECT * FROM country WHERE id = ".$id);
		$found = $this->single();
		
		if(empty($found))
		{
			Messages::setMsg('Įvyko klaida mėginant ištrinti pasirinktą įrašą: Neegzistuojantis ID', 'error');
			return;
		}
		
		$this->query("DELETE FROM country WHERE id = :id");
		$this->bind(':id', $id);
		$this->execute();
		Messages::setMsg('Įrašas ištrintas', 's');
		return;
	}
	
	public function search($search, $filter, $page) {
		if ($search != '' && $filter != '')
		{
			$s = "WHERE (title LIKE '%".$search."%' OR dialcode LIKE '%".$search."%') AND date BETWEEN '".$filter." 00:00:00' AND '".$filter." 23:59:59'";
		} else if ($search == '')
		{
			$s = "WHERE date BETWEEN '".$filter." 00:00:00' AND '".$filter." 23:59:59'";
		} else {
			$s = "WHERE title LIKE '%".$search."%' OR dialcode LIKE '%".$search."%'";
		}
		$query="country ".$s;
        /*$this->query("SELECT * FROM country WHERE title LIKE '%".$search.
				"%' OR dialcode LIKE '%".$search."%' OR date = '%".$filter."%'");
		$rows= $this->resultSet();*/
		$rows = $this->paging($query, $page, $_SESSION['sort']);
		$_SESSION['pagination'] = $this->pagination($query, 5, $page);
		
        if(!empty($rows)) {
            return $rows;
        } else {
            return;
        }
    }
	
	public function add(){
		// Sanitize Post
		$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
		if($_POST['submit'] && $this->validate($_POST['title'], $_POST['size'], $_POST['population'], $_POST['dialcode'], 0, 0)){
			// Insert into MySQL
			$this->query('INSERT INTO country(title, size, population, dialcode) VALUES(:title, :size, :population, :dialcode)');
			$this->bind(':title', $_POST['title']);
			$this->bind(':size', $_POST['size']);
			$this->bind(':population', $_POST['population']);
			$this->bind(':dialcode', $_POST['dialcode']);
			$this->execute();

			// Verify
			if($this->lastInsertId()){
				// Redirect
				$_POST['submit'] = true;
				return true;
			}
		}
		else {
			$_SESSION['add']['title'] = $_POST['title'];
			$_SESSION['add']['size'] = $_POST['size'];
			$_SESSION['add']['population'] = $_POST['population'];
			$_SESSION['add']['dialcode'] = $_POST['dialcode'];
			$_POST['submit'] = false;
		}
	}
	
	public function validate($title, $size, $population, $dialcode, $usedSpace, $usedPopulation)
	{
		if($_POST['title'] == '' || $_POST['size'] =='' || $_POST['population'] == '' || $_POST['dialcode'] == ''){
			Messages::setMsg('Užpildykite visus laukus', 'error');
			return false;
		}
			
		if(preg_match('~^[\p{L}\p{Z}]+$~u', $_POST['title']) == false){
			Messages::setMsg('Pavadinime gali būti tik raidės ir tarpai', 'error');
			return false;
		}
		
		if(!is_numeric($_POST['size']) || $_POST['size'] < 0)
		{
			Messages::setMsg('Plotas turi buti teigiamas skaičius', 'error');
			return false;
		}
		
		if(!is_numeric($_POST['population']) || !is_int($_POST['population'] + 0) || $_POST['population'] < 0)
		{
			Messages::setMsg('Populiacija turi būti teigiamas sveikasis skaičius', 'error');
			return false;
		}
		
		if($usedSpace > $_POST['size'])
		{
			
			Messages::setMsg('Plotas negali būti mažesnis, nei naudojamas miestų plotas. Užimtas plotas: '.$_SESSION['country']['usedSize'], 'error');
			return false;
		}
		
		if($usedPopulation > $_POST['population'])
		{
			Messages::setMsg('Populiacija negali būti mažesnė nei miestų populiacija. Užimta populiacija: '.$_SESSION['country']['usedPop'], 'error');
			return false;
		}
		
		return true;
	}	
}