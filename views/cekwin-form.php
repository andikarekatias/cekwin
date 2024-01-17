<form action="" class="w3-container" method="POST">
   <?php wp_nonce_field('cekwin_form_nonce', 'cekwin_nonce'); ?>
   <p><input name="id_login" class="w3-input w3-hover-green" type="text" placeholder="ID Login" required></p>
   <p><input name="kode" class="w3-input w3-hover-green" type="text" placeholder="Kode" required></p>
   <p><button class="w3-button w3-hover-aqua w3-green" type="submit">Submit</button></p>
</form>
