<?php echo validation_errors(); ?>
<?php echo form_open_multipart('Livre/Add'); ?>

<div>Titre      : <input type="text" name="titre" value="<?php echo set_value('titre',$this->input->post('titre')) ; ?>" /></div>

<input type="file" name="couverture" files="file1" value="valuetest" filename="test" width="10" id="idFile" onchange="loadFile(event)" />


<div>Auteur     : <?php echo set_value('auteur',$comboBoxAuteur->Render()); ?></div>
<div>Editeur    : <?php echo set_value('editeur',$comboBoxEditeur->Render()); ?></div>
<div>Quizz      : <?php echo set_value('quizz',$comboBoxQuizz->Render()); ?></div>

<div><img src="<?php echo base_url('img/Livre-18.jpeg') ?>" alt="<?php echo $this->input->post('titre'); ?>" height="100" width="100" id="idImage"> </div>


<script>
 var loadFile = function(event) {
    var output = document.getElementById('output');
    output.src = URL.createObjectURL(event.target.files[0]);
  };
}
</script>

<button type="submit" id="idSubmit">Sauvegarder</button>

<?php echo form_close(); ?>



