<?php

include("conf.php");
include("DB.php");
include("Task.php");
include("Template.php");

// Membuat objek dari kelas task
$otask = new Task($db_host, $db_user, $db_password, $db_name);
$otask->open();

// Memanggil method getTask di kelas Task
$otask->getTask();

// jika form sudah disubmit
if(isset($_POST['add'])) {

	// memanggil method
	$otask->addTask();

	// mengembalikan ke halaman utama
	header("location:index.php");
}

// jika submit delete button
if (isset($_GET['id_hapus'])){

	// get id hapus ke variabel
	$id_hapus = $_GET['id_hapus'];

	// memanggil methodnya
	$otask->deleteTask($id_hapus);

	// mengembalikan ke halaman utama
	header("location:index.php");
}

// jika submit update button
if (isset($_GET['id_status'])){

	// menampung variabel dari id data tersebut
	$id_update = $_GET['id_status'];

	// memanggil methodnya
	$otask->changeTaskStatus($id_update);
	
	// mengembalikan ke halaman utama
	header("location:index.php");
}

// jika submit button sorting
if (isset($_GET['sortTask'])) {

	// get value button sesuai sortingan nya
	$sortBy = $_GET['sortTask'];

	// jika reset
	if ($sortBy == "reset") {

		// maka tampilkan default
		$otask->getTask();
	}

	// jika priority
	else if ($sortBy == "priority_td") {

		// panggil method
		// set mode true 1
		// jika isPriorty true
		$otask->sortingTask("true", $sortBy);
	}

	// jika lainnya
	else {

		// panggil method
		// set false
		$otask->sortingTask("false", $sortBy);
	}
}

// Proses mengisi tabel dengan data
$data = null;
$no = 1;

while (list($id, $tname, $tdetails, $tsubject, $tpriority, $tdeadline, $tstatus) = $otask->getResult()) {
	// Tampilan jika status task nya sudah dikerjakan
	if($tstatus == "Sudah"){
		$data .= "<tr>
		<td>" . $no . "</td>
		<td>" . $tname . "</td>
		<td>" . $tdetails . "</td>
		<td>" . $tsubject . "</td>
		<td>" . $tpriority . "</td>
		<td>" . $tdeadline . "</td>
		<td>" . $tstatus . "</td>
		<td>
		<button class='btn btn-danger'><a href='index.php?id_hapus=" . $id . "' style='color: white; font-weight: bold;'>Hapus</a></button>
		</td>
		</tr>";
		$no++;
	}

	// Tampilan jika status task nya belum dikerjakan
	else{
		$data .= "<tr>
		<td>" . $no . "</td>
		<td>" . $tname . "</td>
		<td>" . $tdetails . "</td>
		<td>" . $tsubject . "</td>
		<td>" . $tpriority . "</td>
		<td>" . $tdeadline . "</td>
		<td>" . $tstatus . "</td>
		<td>
		<button class='btn btn-danger'><a href='index.php?id_hapus=" . $id . "' style='color: white; font-weight: bold;'>Hapus</a></button>
		<button class='btn btn-success' ><a href='index.php?id_status=" . $id .  "' style='color: white; font-weight: bold;'>Selesai</a></button>
		</td>
		</tr>";
		$no++;
	}
}

// Menutup koneksi database
$otask->close();

// Membaca template skin.html
$tpl = new Template("templates/skin.html");

// Mengganti kode Data_Tabel dengan data yang sudah diproses
$tpl->replace("DATA_TABEL", $data);

// Menampilkan ke layar
$tpl->write();