<?php echo validation_errors(); ?>
<?php echo form_open('Login/Index'); ?>
<label for="login">Login :</label>
<input type="text" name="login" value="<?php echo $this->input->post('nom'); ?>" id="login"/><br/>
<label for="password">Password :</label>
<input type="password" name="password" id="password"/><br/>
<button type="submit">Login</button>

 <a href="<?php echo base_url('Login/account'); ?>">Inscription</a>
<!-- todo : renommer second lien -->
 <a href="<?php echo base_url('Account/mdpOublie'); ?>">Mot de passe oublié</a>
 
<?php echo form_close(); ?>