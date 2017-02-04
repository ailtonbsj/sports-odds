<?php

date_default_timezone_set('America/Fortaleza');

try {
	if(file_exists("LOCAL")){
		$db = 'mysql:host=localhost;dbname=pe_db';
		$conn = new PDO($db,'root','');
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} else {
		$db = 'mysql:host=localhost;dbname=u234125999_db';
		$conn = new PDO($db,'u234125999_usr','qwertyuiop123456');
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
} catch (PDOException $e) {
	echo "<div class=\"alert alert-error\"><b>Error!</b> Add or remove LOCAL file. Or install database.</div>";
	exit();
}

?>
