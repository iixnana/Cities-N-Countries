<?php
class Cities extends Controller{
	protected function Index(){
		$_SESSION['add']['title'] = '';
		$_SESSION['add']['size'] = '';
		$_SESSION['add']['population'] = '';
		$_SESSION['add']['citycode'] = '';
		
		if (strpos($_SERVER['REQUEST_URI'], '?') !== false)
		{
			$uri = explode("?", $_SERVER['REQUEST_URI']);
			$get = explode("=", $uri[1]);
			$page = (int) $get[1];
		} else {
			$page = 1;
		}
		
		$viewmodel = new CityModel();
		if(!isset($_SESSION['sort']))
		{
			$this->sortASC();
		}
		if((!isset($_SESSION['citySearch']) || $_SESSION['citySearch'] == '') && (!isset($_SESSION['cityFilter']) || $_SESSION['cityFilter'] == ''))
		{
			$this->ReturnView($viewmodel->Index($page), true);
		} else
		{
			$this->ReturnView($viewmodel->search($_SESSION['citySearch'], $_SESSION['cityFilter'], $page), true);
		}
		$_SESSION['citySearch'] = '';
	}
	
	protected function sortASC(){
		$_SESSION['sort']='ASC';
		header('Location: '.ROOT_URL.'cities');
	}
	
	protected function sortDESC(){
		$_SESSION['sort']='DESC';
		header('Location: '.ROOT_URL.'cities');
	}
	
	protected function search(){
		$_SESSION['citySearch'] = $_POST['search'];
		$_SESSION['cityFilter'] = $_POST['filter'];
		header('Location: '.ROOT_URL.'cities');
		return;
	}
	
	protected function clear(){
		$_SESSION['citySearch'] = '';
		$_SESSION['cityFilter'] = '';
		header('Location: '.ROOT_URL.'cities');
		return;
	}
	
	protected function edit(){
		$viewmodel = new CityModel();
		$this->ReturnView($viewmodel->edit($_POST['id']), true);
		if($_POST['submit']){
			header('Location: '.ROOT_URL.'cities');
		}
	}
	
	protected function delete(){
		$viewmodel = new CityModel();
		$viewmodel->delete($_POST['id']);
		header('Location: '.ROOT_URL.'cities');
		return;
	}
	
	protected function add(){
		$viewmodel = new CityModel();
		$this->ReturnView($viewmodel->add(), true);
		if($_POST['submit']){
			header('Location: '.ROOT_URL.'cities');
		}
	}
}