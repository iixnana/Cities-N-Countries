<?php
class Countries extends Controller{
	protected function Index(){
		$_SESSION['add']['title'] = '';
		$_SESSION['add']['size'] = '';
		$_SESSION['add']['population'] = '';
		$_SESSION['add']['dialcode'] = '';
		if (strpos($_SERVER['REQUEST_URI'], '?') !== false)
		{
			$uri = explode("?", $_SERVER['REQUEST_URI']);
			$get = explode("=", $uri[1]);
			$page = (int) $get[1];
		} else {
			$page = 1;
		}
		$_SESSION['country']='';
		if(!isset($_SESSION['sort']))
		{
			$this->sortASC();
		}
		$viewmodel = new CountryModel();
		if((!isset($_SESSION['countrySearch']) || $_SESSION['countrySearch'] == '') && (!isset($_SESSION['countryFilter']) || $_SESSION['countryFilter'] == ''))
		{
			$this->ReturnView($viewmodel->Index($page), true);
		} else
		{
			$this->ReturnView($viewmodel->search($_SESSION['countrySearch'], $_SESSION['countryFilter'], $page), true);
		}
	}
	
	protected function sortASC(){
		$_SESSION['sort']='ASC';
		header('Location: '.ROOT_URL.'countries');
	}
	
	protected function sortDESC(){
		$_SESSION['sort']='DESC';
		header('Location: '.ROOT_URL.'countries');
	}
	
	protected function search(){
		$_SESSION['countrySearch'] = $_POST['search'];
		$_SESSION['countryFilter'] = $_POST['filter'];
		header('Location: '.ROOT_URL.'countries');
		return;
	}
	
	protected function clear(){
		$_SESSION['countrySearch'] = '';
		$_SESSION['countryFilter'] = '';
		header('Location: '.ROOT_URL.'countries');
		return;
	}
	
	protected function getCities(){
		$_SESSION['country']['id']=$_POST['id'];
		$_SESSION['country']['size']=$_POST['size'];
		$_SESSION['country']['population']=$_POST['population'];
		$_SESSION['country']['title']=$_POST['title'];
		$_SESSION['sort'] = 'ASC';
		header('Location: '.ROOT_URL.'cities');
		return;
	}
	
	protected function edit(){
		$_SESSION['country']['id']=$_POST['id'];
		$viewmodel = new CountryModel();
		$this->ReturnView($viewmodel->edit($_POST['id']), true);
		if($_POST['submit']){
			header('Location: '.ROOT_URL.'countries');
		}
	}
	
	protected function delete(){
		$viewmodel = new CountryModel();
		$viewmodel->delete($_POST['id']);
		header('Location: '.ROOT_URL.'countries');
		return;
	}
	
	protected function add(){
		$_SESSION['country']['usedPop'] = 0;
		$_SESSION['country']['usedSize'] = 0;
		$viewmodel = new CountryModel();
		$this->ReturnView($viewmodel->add(), true);
			if($_POST['submit']){
			header('Location: '.ROOT_URL.'countries');
		}
	}
	
}