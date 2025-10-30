<?php

session_start();

if(empty($_SESSION['id_admin'])) {
	header("Location: index.php");
	exit();
}


require_once("../db.php");

if (isset($_GET['id'])) {
	$company_id = (int) $_GET['id'];

	$sql = "DELETE c, jp, ajp FROM company c
			LEFT JOIN job_post jp ON jp.id_company = c.id_company
			LEFT JOIN apply_job_post ajp ON ajp.id_company = c.id_company
			WHERE c.id_company = ?";

	if ($stmt = $conn->prepare($sql)) {
		$stmt->bind_param('i', $company_id);
		if ($stmt->execute()) {
			$stmt->close();
			header("Location: companies.php");
			exit();
		}
		$stmt->close();
	}
	echo "Error deleting company.";
} else {
	echo "Invalid request.";
}
