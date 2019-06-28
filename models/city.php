<?php
class CityModel extends Model{
	private $table = 'city';
	
	public function Index($page){
		$query = 'city WHERE country = '. $_SESSION['country']['id'];
		$set = $this->paging($query, $page, $_SESSION['sort']);
		$_SESSION['pagination'] = $this->pagination($query,5,$page);
		$this->query('SELECT * FROM city WHERE country = '. $_SESSION['country']['id'] . ' ORDER BY title '.$_SESSION['sort']);
		$rows= $this->resultSet();
		return $set;
	}
	
	public function search($search, $filter, $page) {
		if ($search != '' && $filter != '')
		{
			$s = "WHERE country = '".$_SESSION['country']['id']."' AND (title LIKE '%".$search."%' OR citycode LIKE '%".$search."%') AND date BETWEEN '".$filter." 00:00:00' AND '".$filter." 23:59:59'";
		} else if ($search == '')
		{
			$s = "WHERE country = '".$_SESSION['country']['id']."' AND date BETWEEN '".$filter." 00:00:00' AND '".$filter." 23:59:59'";
		} else {
			$s = "WHERE country = '".$_SESSION['country']['id']."' AND title LIKE '%".$search."%' OR citycode LIKE '%".$search."%'";
		}
		$query="city ".$s;
		$rows = $this->paging($query, $page, $_SESSION['sort']);
		$_SESSION['pagination'] = $this->pagination($query, 5, $page);

        if(!empty($rows)) {
            return $rows;
        } else {
            return;
        }
    }
	
	public function edit($id){
		$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
		if(isset($_POST['submit']) && $_POST['submit'] && $this->validate($_POST['exSize'], $_POST['exPop'])){

			$this->updateValue('UPDATE city SET title = \''.$_POST['title'].'\', size = '.$_POST['size'].', population = '.$_POST['population'].', citycode = \''.$_POST['citycode'].'\' WHERE id = '.$id);
			$_POST['submit'] = true;
			return true;
		}
		else {
			$_POST['submit'] = false;
			$this->query('SELECT * FROM city WHERE id = '.$id);
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
		
		$this->query("SELECT * FROM city WHERE id = ".$id);
		$found = $this->single();
		
		if(empty($found))
		{
			Messages::setMsg('Įvyko klaida mėginant ištrinti pasirinktą įrašą: Neegzistuojantis ID', 'error');
			return;
		}
		
		$this->query("SELECT * FROM country WHERE id = ".$_SESSION['country']['id']);
		$country = $this->single();
		$newSize = $country['usedSize'] - $found['size'];
		$newPopulation = $country['usedPopulation'] - $found['population'];
		$this->updateValue("UPDATE country SET usedSize = ".$newSize.", usedPopulation = ".$newPopulation." WHERE id = ".$_SESSION['country']['id']);
		
		$this->query("DELETE FROM city WHERE id = :id");
		$this->bind(':id', $id);
		$this->execute();

		Messages::setMsg('Įrašas ištrintas', 's');
		return;
	}
	
	public function add(){
		// Sanitize Post
		$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
		if($_POST['submit'] && $this->validate()){
			// Insert into MySQL
			
			
			$this->query('INSERT INTO city(country, title, size, population, citycode) VALUES(:country, :title, :size, :population, :citycode)');
			$this->bind(':country', $_SESSION['country']['id']);
			$this->bind(':title', $_POST['title']);
			$this->bind(':size', $_POST['size']);
			$this->bind(':population', $_POST['population']);
			$this->bind(':citycode', $_POST['citycode']);
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
			$_SESSION['add']['citycode'] = $_POST['citycode'];
			$_POST['submit'] = false;
		}
	}
	
	public function validate($size = 0, $population = 0)
	{
		if($_POST['title'] == '' || $_POST['size'] =='' || $_POST['population'] == '' || $_POST['citycode'] == ''){
			Messages::setMsg('Užpildykite visus laukus', 'error');
			return false;
		}
			
		if(preg_match('~^[\p{L}\p{Z}]+$~u', $_POST['title']) == false){
			Messages::setMsg('Pavadinime gali būti tik raidės ir tarpai', 'error');
			return false;
		}
		
		if(!is_numeric($_POST['size']) || $_POST['size'] < 0)
		{
			Messages::setMsg('Plotas turi būti teigiamas skaičius', 'error');
			return false;
		}
		
		if(!is_numeric($_POST['population']) || !is_int($_POST['population'] + 0) || $_POST['population'] < 0)
		{
			Messages::setMsg('Populiacija turi būti teigiamas sveikasis skaičius', 'error');
			return false;
		}
		
		$this->query("SELECT * FROM country WHERE id = ".$_SESSION['country']['id']);
		$country = $this->single();
		$freeSize = $country['size'] - $country['usedSize'] + $size;
		if($freeSize < $_POST['size'])
		{
			Messages::setMsg('Plotas negali viršyti laisvo šalies ploto. Laisvas plotas: '.$freeSize, 'error');
			return false;
		}
		$freePopulation = $country['population'] - $country['usedPopulation'] + $population;
		if($freePopulation < $_POST['population'])
		{
			$free = $country['usedPopulation'];
			Messages::setMsg('Populiacija negali viršyti šalies populiacijos. Laisva populiacija: '.$freePopulation, 'error');
			return false;
		}
		$newSize = $country['usedSize'] - $size + $_POST['size'];
		$newPopulation = $country['usedPopulation'] - $population + $_POST['population'];
		$this->updateValue("UPDATE country SET usedSize = ".$newSize.", usedPopulation = ".$newPopulation." WHERE id = ".$_SESSION['country']['id']);
		
		return true;
	}
}