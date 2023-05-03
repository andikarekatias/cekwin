<div class="w3-container">
	<h3>Cekwin</h3>
	<?php 

		if ($aksi == 'edit') {
			$nama_table = 'cekwin';
			$andwhere = " AND cw_id='".$cw_id."'";
			$get_data_row = get_data($nama_table,$andwhere);
			$id_r = $get_data_row->cw_id;
			$nama_r = $get_data_row->nama;
			$id_login_r = $get_data_row->id_login;
			$kode_r = $get_data_row->kode;
			$status_r = $get_data_row->status;
		}
	 ?>
	<div class="w3-bar w3-black">
	    <button class="w3-bar-item w3-button tablink w3-red" onclick="openTab(event,'home')">Home</button>
	    <button class="w3-bar-item w3-button tablink" onclick="openTab(event,'data')">Data</button>
	  </div>
	  
	  <div id="home" class="w3-container w3-border w3-card-4 tab">
	  	<form action="" class="w3-container w3-light-grey" method="POST">
	    	<?php if ($aksi == 'edit'): ?>
	    		<input type="hidden" name="cw_id" value="<?= $id_r ?>">
	    	<?php endif; ?>
	    	<p>
	    		<label>Nama</label>
	    		<input class="w3-input w3-border-0" type="text" name="nama" value="<?php if(isset($nama_r)){ echo $nama_r; }  ?>" maxlength="55" required>
	    	</p>
	    	<p>
	    		<label>ID Login</label>
	    		<input class="w3-input w3-border-0" type="text" name="id_login" value="<?php if(isset($id_login_r)){ echo $id_login_r; }  ?>" maxlength="14" required>
	    	</p>
	    	<p>
	    		<label>Kode</label>
	    		<input class="w3-input w3-border-0" type="text" name="kode" value="<?php if(isset($kode_r)){ echo $kode_r; }  ?>" maxlength="20" required>
	    	</p>
	    	<label>Status</label>
	    	<select class="w3-select w3-border-0" name="status" required>
			  <option value="<?php if(isset($status_r)){ echo $status_r; }  ?>" disabled selected>
			  	<?php 
					if(isset($status_r)){
						if ($status_r == 0 ) {
							echo "Tidak Lulus";
						}elseif ($status_r == 1) {
							echo "Lulus";
						}
					}else{
						echo "Lulus/Tidak Lulus";
					}
				?></option>
			  <option value="1">Lulus</option>
			  <option value="0">Tidak Lulus</option>
			</select>
			<p>
				<button type="submit" class="w3-btn w3-teal">Submit</button>
			</p>
	    </form>
	  </div>

	  <div id="data" class="w3-container w3-card-4 tab" style="display:none">
	  	<div class="w3-responsive">
		<button class="w3-button w3-red" onclick="deleteDatabase()">Delete all data </button>		  
	  	<table class="w3-table-all w3-striped w3-border dt-custom">
			<thead>
				<tr class="w3-dark-grey">
					<th>No</th>
					<th>Nama</th>
					<th>ID Login</th>
					<th>Kode</th>
					<th>Status</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody>
				<?php 
					$no = 1;
					$tampil_data = tampilData('cekwin');
					foreach($tampil_data as $td):
				 ?>
				 <tr class="w3-hover-text-green">
				 	<td><?= $no++; ?></td>
				 	<td><?= $td->nama; ?></td>
				 	<td><?= $td->id_login; ?></td>
				 	<td><?= $td->kode; ?></td>
				 	<td><?php if ($td->status == 1) {
				 		echo "Lulus";
				 	}else{
				 		echo "Tidak Lulus";
				 	} ?></td>
				 	<td>
				 		<a href="<?= admin_url().'admin.php?page=cekwin&aksi=edit&cw_id='.$td->cw_id; ?>" class="w3-button w3-yellow">Edit</a>
				 		<a href="<?= admin_url().'admin.php?page=cekwin&aksi=hapus&cw_id='.$td->cw_id; ?>" class="w3-button w3-red">hapus</a>
				 	</td>
				 </tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		</div>
	  </div>
	</div>
</div>