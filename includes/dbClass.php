<?php 			
class dbClass {		
	private $dbCon;	
	private $userId;
	
	public function __construct() {
		include("dbConnect.php");			
		$this->dbCon  = $conn;
	}
	
	function getDbConn(){
		return $this->dbCon;
	}

	function getSingleRow($sql){
		$stmt = $this->dbCon->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		return 	$result;	
	}
	
	function getResultList($sql){		
		$stmt = $this->dbCon->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return 	$result;	
	}

}

?>