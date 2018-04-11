<?php echo validation_errors(); ?>
<?php echo form_open('Account/create'); ?>
<br><br><br>
<?php
$array = array("Nom","Prenom","Email","MotDePasse","ConfirmezVotreMotDePasse");
for ($k = 0; $k < 5; $k++) {
    // echo $i;
    ?>
    <label for=<?php echo $array[$k] ?>><?php echo $array[$k]." :" ?></label>
    <input type="text" name=<?php echo $array[$k] ?> id=<?php echo $array[$k] ?>/><br/>
    <?php
}
?>

<button type="submit">Créez votre compte</button>
<?php echo form_close(); ?>