<?php 

class Task extends DB {
	
	// Mengambil data task
	function getTask() {
		// Query mysql select data ke tb_to_do
		$query = "SELECT * FROM tb_to_do";

		// Mengeksekusi query
		return $this->execute($query);
	}

	// menambah data task
	function addTask() {

		// tampungan variabel dari form
		$name = $_POST['tname'];
		$deadline = $_POST['tdeadline'];
		$detail = $_POST['tdetails'];
		$subject = $_POST['tsubject'];
		$priority = $_POST['tpriority'];

		// query insert to database
		$query = "INSERT INTO tb_to_do (name_td, details_td, subject_td, priority_td, deadline_td, status_td)
					VALUES ('$name', '$detail', '$subject', '$priority', '$deadline', 'Belum')";

		// eksekusi query
		return $this->execute($query);
	}

	// menghapus data task
	function deleteTask($id_hapus) {

		// query untuk mendelete
		$query = "DELETE FROM tb_to_do WHERE id = $id_hapus";

		// exekusi query
		return $this->execute($query);
	}

	// mengubah status data task
	function changeTaskStatus($id_update) {

		// query untuk mengupdate
		$query = "UPDATE tb_to_do SET status_td = 'Sudah' WHERE id = $id_update";

		// eksekusi query
		return $this->execute($query);
	}

	// mengsorting data pada tabel
	// true (1) = sorting Priority
	// false (0) = sorting atribut lain
	function sortingTask($isPriority, $orderBy) {

		// jika isPriority true
		if ($isPriority == "true") {

			// query sorting priority
			$query = "SELECT * FROM tb_to_do ORDER BY
						(CASE
						WHEN $orderBy = 'High' THEN 1
						WHEN $orderBy = 'Medium' THEN 2
						ELSE 3 END)";
		}

		// jika false
		// maka sorting asc biasa untuk atribut lain
		else {
			$query = "SELECT * FROM tb_to_do ORDER BY $orderBy";
		}

		// eksekusi query
		return $this->execute($query);
	}
	
}

?>