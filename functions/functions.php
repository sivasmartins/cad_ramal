<?php
	function mysqliResultArray($conexaodb, $sql) {
		$arrayResult = null;
		$query = null;
		$rows = 0;

		$query = mysqli_query($conexaodb, $sql);
		if($query){
			while ($row = mysqli_fetch_assoc($query)) {
				$arrayResult[] = $row;
			}
			return $arrayResult;
		}
	}

	function mysqliResultRows($conexaodb, $sql) {
		$query = null;
		$rows = 0;

		$query = mysqli_query($conexaodb, $sql);
		if($query){
			$rows = mysqli_num_rows($query);
			return $rows;
		}
		
	}	
?>