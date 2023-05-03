<?php 
	add_action('admin_menu','cwMenu');
	function cwMenu(){
		 add_menu_page( 
	        __( 'Cekwin' ),
	        'Cekwin',
	        'manage_options',
	        'cekwin',
	        'callbackMenu',
	        'dashicons-businessperson',
	        6
    	);
	}
	function callbackMenu(){
		$aksi = isset( $_GET['aksi'] ) ? $_GET['aksi'] : '';
		$cw_id = isset( $_GET['cw_id'] ) ? $_GET['cw_id'] : '';
		$nama = isset($_POST['nama']) ? $_POST['nama'] : '';
		$id_login = isset($_POST['id_login']) ? $_POST['id_login'] : '';
		$kode = isset($_POST['kode']) ? $_POST['kode'] : '';
		$status = isset($_POST['status']) ? $_POST['status'] : '';
		$nama_table = 'cekwin';
		$data = array(
			'nama' => $nama,
			'id_login' => $id_login,
			'kode' => $kode,
			'status' => $status,
		);
		if ($aksi == 'hapus') {
			$where = array('cw_id' => $cw_id);
			$delete = deleteData($nama_table,$where);
			if ($delete) {
				wp_redirect( admin_url().'admin.php?page=cekwin' );
				exit();
			}
		}
		// echo "<pre>";
		// print_r($_POST);
		// echo "</pre>";

		if(!empty($id_login) && !empty($nama) && !empty($kode) && !empty($status)){
			if ($aksi == 'edit') {
			$where = array('cw_id' => $cw_id);
			$update = updateData($nama_table,$data,$where);
			if ($update) {
				wp_redirect( admin_url().'admin.php?page=cekwin' );
				exit();
			}
			}else{
				$insert = tambahData($nama_table,$data);

			}
		}
		// global $wpdb;
		// echo $wpdb->last_error;
		// echo $wpdb->last_query;
		include TEMP_DIR . 'index.php';
	}
 ?>