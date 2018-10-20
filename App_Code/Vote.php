<?php
$clsVote = new Vote();
class Vote{

	private $table = "vote";

	public function Vote(){}

	public function Add($mdl){

		$Database = new Database();
		$conn = $Database->GetConn();

		$sql = "INSERT INTO `".$this->table."`
				(
          `Election_Id`,
          `Candidate_Id`,
          `User_Id`
				) VALUES (
          '".$mdl->getsqlElection_Id()."',
          '".$mdl->getsqlCandidate_Id()."',
          '".$mdl->getsqlUser_Id()."'
				)";

		$result=mysqli_query($conn,$sql) or die(mysqli_error($conn));
		$id = mysqli_insert_id($conn);

		mysqli_close($conn);

		return $id;
	}

	public function Update($mdl){

		$Database = new Database();
		$conn = $Database->GetConn();

		$sql="UPDATE `".$this->table."` SET
      `Election_Id`='".$mdl->getsqlElection_Id()."',
      `Candidate_Id`='".$mdl->getsqlCandidate_Id()."',
			`User_Id`='".$mdl->getsqlUser_Id()."'
			WHERE `Vote_Id`='".$mdl->getsqlId()."'";
		$result=mysqli_query($conn,$sql) or die(mysqli_error($conn));

		mysqli_close($conn);
	}

	public function Delete($id){

		$Database = new Database();
		$conn = $Database->GetConn();

		$id = mysqli_real_escape_string($conn,$id);
		$sql="DELETE FROM `".$this->table."`
				WHERE `Vote_Id` = '".$id."'";
		$result=mysqli_query($conn,$sql) or die(mysqli_error($conn));

		mysqli_close($conn);
	}

	public function IsExist($mdl){

		$Database = new Database();
		$conn = $Database->GetConn();

		$val = false;
		$msg = "";
}

	public function Get(){

		$Database = new Database();
		$conn = $Database->GetConn();

		$sql="SELECT * FROM `".$this->table."`";
		$result=mysqli_query($conn,$sql) or die(mysqli_error($conn));

		mysqli_close($conn);

		return $this->ListTransfer($result);
	}

	public function GetById($id){

		$Database = new Database();
		$conn = $Database->GetConn();

		$id = mysqli_real_escape_string($conn,$id);

		$sql="SELECT * FROM `".$this->table."`
				WHERE `Vote_Id` = '".$id."'";

		$result=mysqli_query($conn,$sql) or die(mysqli_error($conn));

		mysqli_close($conn);

		return $this->ModelTransfer($result);
	}

	public function GetByUser_Id($id){

		$Database = new Database();
		$conn = $Database->GetConn();

		$id = mysqli_real_escape_string($conn,$id);

		$sql="SELECT * FROM `".$this->table."`
				WHERE `User_Id` = '".$id."'";

		$result=mysqli_query($conn,$sql) or die(mysqli_error($conn));

		mysqli_close($conn);

		return $this->ListTransfer($result);
	}

  public function GetByElection_Id($id){

		$Database = new Database();
		$conn = $Database->GetConn();

		$id = mysqli_real_escape_string($conn,$id);

		$sql="SELECT * FROM `".$this->table."`
				WHERE `Election_Id` = '".$id."'";

		$result=mysqli_query($conn,$sql) or die(mysqli_error($conn));

		mysqli_close($conn);

		return $this->ListTransfer($result);
	}

  public function GetByCandidate_Id($id){

    $Database = new Database();
    $conn = $Database->GetConn();

    $id = mysqli_real_escape_string($conn,$id);

    $sql="SELECT * FROM `".$this->table."`
        WHERE `Candidate_Id` = '".$id."'";

    $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));

    mysqli_close($conn);

    return $this->ListTransfer($result);
  }

  public function IsVoted($userId,$electionId){

    $Database = new Database();
    $conn = $Database->GetConn();
		$value = false;

		$userId = mysqli_real_escape_string($conn,$userId);
		$electionId = mysqli_real_escape_string($conn,$electionId);

    $sql="SELECT * FROM `".$this->table."` AS `V`
					INNER JOIN `user` AS `U`
					ON `U`.`User_Id` = `V`.`User_Id`
					INNER JOIN `election` AS `E`
					ON `E`.`Election_Id` = `V`.`Election_Id`
        	WHERE `U`.`User_Id` = '".$userId."'
					AND `E`.`Election_Id` = '".$electionId."'";

    $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));
		$num_rows = mysqli_num_rows($result);
		if ($num_rows >0) {
			$value = true;
		}
    mysqli_close($conn);

    return $value;
  }

	public function CountAllRow(){

		$Database = new Database();
		$conn = $Database->GetConn();

		$sql = "SELECT `Vote_Id` FROM `".$this->table."`";
		$result=mysqli_query($conn,$sql) or die(mysqli_error($conn));
		$num_rows = mysqli_num_rows($result);

		mysqli_close($conn);
		return $num_rows;
	}

	public function ModelTransfer($result){

		$mdl = new VoteModel();
		while($row = mysqli_fetch_array($result))
		{
			$mdl = $this->ToModel($row);
		}
		return $mdl;
	}

	public function ListTransfer($result){

		$lst = array();
		while($row = mysqli_fetch_array($result))
		{
			$mdl = new VoteModel();
			$mdl = $this->ToModel($row);
			array_push($lst, $mdl);
		}
		return $lst;
	}

	public function ToModel($row){
		$mdl = new VoteModel();

		$mdl->setId((isset($row['Vote_Id'])) ? $row['Vote_Id'] : '');
		$mdl->setUser_Id((isset($row['User_Id'])) ? $row['User_Id'] : '');
		$mdl->setCandidate_Id((isset($row['Candidate_Id'])) ? $row['Candidate_Id'] : '');
		$mdl->setElection_Id((isset($row['Election_Id'])) ? $row['Election_Id'] : '');
		return $mdl;
	}
}
?>
