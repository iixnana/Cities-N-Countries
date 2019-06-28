<?php
//include("Pagination.php");
abstract class Model{
	
	protected $dbh;
	protected $stmt;
	
	private $limit = 10; //records per page

	public function __construct(){
		try{
			$this->dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
			$this->dbh->setAttribute(PDO::ATTR_ERRMODE,  
			PDO::ERRMODE_EXCEPTION);  
		}
		catch(PDOException $e){ 
			die("ERROR: Could not connect. " . $e->getMessage()); 
		} 
	}
	
	public function paging($table, $page, $order){
		//$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
    	//$limit = 5; //records per page
    	$startpoint = ($page * $this->limit) - $this->limit;
        $statement = $table." order by title ".$order; //you have to pass your query over here
		$res=$this->query("select * from {$statement} LIMIT {$startpoint} , {$this->limit}");
		return $this->resultSet();
	}
	
	protected function pagination($query, $per_page = 10, $page = 1, $url = '?'){
		$per_page = $this->limit;
		$result = $this->query("SELECT COUNT(*) as 'num' FROM {$query}");
		$row = $this->single();
    	$total = $row['num'];
        $adjacents = "2"; 

    	$page = ($page == 0 ? 1 : $page);  
    	$start = ($page - 1) * $per_page;								
		
    	$prev = $page - 1;							
    	$next = $page + 1;
        $lastpage = ceil($total/$per_page);
    	$lpm1 = $lastpage - 1;
    	
    	$pagination = "";
    	if($lastpage > 1)
    	{	
    		$pagination .= "<ul class='pagination'>";
                    $pagination .= "<li class='details' style='margin-top:2px'>$page puslapis iš $lastpage</li>";
    		if ($lastpage < 7 + ($adjacents * 2))
    		{	
    			for ($counter = 1; $counter <= $lastpage; $counter++)
    			{
    				if ($counter == $page)
    					$pagination.= "<li><a class='current'>$counter</a></li>";
    				else
    					$pagination.= "<li><a href='{$url}page=$counter'>$counter</a></li>";					
    			}
    		}
    		elseif($lastpage > 5 + ($adjacents * 2))
    		{
    			if($page < 1 + ($adjacents * 2))		
    			{
    				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= "<li><a class='current'>$counter</a></li>";
    					else
    						$pagination.= "<li><a href='{$url}page=$counter'>$counter</a></li>";					
    				}
    				$pagination.= "<li class='dot'>...</li>";
    				$pagination.= "<li><a href='{$url}page=$lpm1'>$lpm1</a></li>";
    				$pagination.= "<li><a href='{$url}page=$lastpage'>$lastpage</a></li>";		
    			}
    			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
    			{
    				$pagination.= "<li><a href='{$url}page=1'>1</a></li>";
    				$pagination.= "<li><a href='{$url}page=2'>2</a></li>";
    				$pagination.= "<li class='dot'>...</li>";
    				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= "<li><a class='current'>$counter</a></li>";
    					else
    						$pagination.= "<li><a href='{$url}page=$counter'>$counter</a></li>";					
    				}
    				$pagination.= "<li class='dot'>..</li>";
    				$pagination.= "<li><a href='{$url}page=$lpm1'>$lpm1</a></li>";
    				$pagination.= "<li><a href='{$url}page=$lastpage'>$lastpage</a></li>";		
    			}
    			else
    			{
    				$pagination.= "<li><a href='{$url}page=1'>1</a></li>";
    				$pagination.= "<li><a href='{$url}page=2'>2</a></li>";
    				$pagination.= "<li class='dot'>..</li>";
    				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= "<li><a class='current'>$counter</a></li>";
    					else
    						$pagination.= "<li><a href='{$url}page=$counter'>$counter</a></li>";					
    				}
    			}
    		}
    		
    		if ($page < $counter - 1){ 
    			$pagination.= "<li><a href='{$url}page=$next'>Kitas</a></li>";
                $pagination.= "<li><a href='{$url}page=$lastpage'>Paskutinis</a></li>";
    		}else{
    			$pagination.= "<li><a class='current'>Kitas</a></li>";
                $pagination.= "<li><a class='current'>Paskutinis</a></li>";
            }
    		$pagination.= "</ul>\n";		
    	}
        return $pagination;
    } 
	
	public function query($query){
		$this->stmt = $this->dbh->prepare($query);
	}

	public function bind($param, $value, $type = null){
		if(is_null($type)){
			switch(true){
				case is_int($value):
					$type = PDO::PARAM_INT;
					break;
				case is_string($value):
					$type = PDO::PARAM_STR;
					break;
				case is_bool($value):
					$type = PDO::PARAM_BOOL;
					break;
				case is_null($value):
					$type = PDO::PARAM_NULL;
					break;
					default:
					$type = PDO::PARAM_STR;
			}
		}
		$this->stmt->bindValue($param, $value, $type);
	}
	
	public function updateValue($sql)
	{
		try{
			$this->dbh->exec($sql);
		}
		catch(PDOException $e){ 
			die("ERROR: Could not execute $sql. " . $e->getMessage()); 
		} 
	}

	public function execute(){
		$this->stmt->execute();
	}

	public function lastInsertId(){
		return $this->dbh->lastInsertId();
	}

	public function single(){
		$this->execute();
		return $this->stmt->fetch(PDO::FETCH_ASSOC);
	}

	public function resultSet(){
		$this->execute();
		return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function countRows(){
		return $this->stmt->rowCount();
	}
}