<?php 

	function tampilData($nama_table,$andwhere=""){
		global $wpdb;
		$table_name = $wpdb->prefix.$nama_table;
		$sql = "SELECT * FROM " . $table_name . " WHERE 1 " .$andwhere;
		$query = $wpdb->get_results($sql);
		return $query;
	}
	
	function tambahData($nama_table,$data=array()){
		global $wpdb;
		$table = $wpdb->prefix.$nama_table;
		$wpdb->insert($table,$data);
		$id_insert = $wpdb->insert_id;
		return $id_insert;
	}

	function get_data($nama_table,$andwhere){
		global $wpdb;
		$table = $wpdb->prefix.$nama_table;
		$sql = "SELECT * FROM " . $table . " WHERE cw_id " .$andwhere;
		$row = $wpdb->get_row($sql);
		return $row;
	}

	function ambil_data($nama_table,$andwhere){
		global $wpdb;
		$table = $wpdb->prefix.$nama_table;
		$sql = "SELECT * FROM " . $table . " WHERE kode " .$andwhere;
		$row = $wpdb->get_row($sql);
		return $row;
	}


	function updateData($nama_table,$data=array(),$where=array()){
		global $wpdb;
		$table = $wpdb->prefix.$nama_table;
		$update = $wpdb->update($table,$data,$where);
		return $update;
	}

	function deleteData($nama_table,$where=array()){
		global $wpdb;
		$table = $wpdb->prefix.$nama_table;
		$delete = $wpdb->delete($table,$where);
		return $delete;	
	}	

?>