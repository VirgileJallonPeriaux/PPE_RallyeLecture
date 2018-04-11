<!-- navigation -->
<div class="navigation">
    <a href="<?php echo base_url(); ?>">Home</a>
    <a href="<?php echo base_url('livre/add');?>">Ajouter</a>
    <a href="<?php echo base_url('livre/supprimer/');?>">Supprimer</a>
</div>


    <?php $lien = "/rallyeLecture/Livre/IndexRechercheNom/"; ?>
    <form action= <?php echo $lien; ?> method="post">
    <div>
        <br><br>
        Livre recherché : <input name="nom" type="text" id="titreLivre" />

        <button type="submit" name = btnValider">Rechercher</button>

        <br><br>
    </div>
    </form>

<table>
    <tr>
        <td>#</td>
        <td>titre</td>
        <td>couverture</td>
        <td>id auteur</td>
        <td>id editeur</td>
        <td>id quizz</td>
        <td>image</td>
        <td>Actions</td>
    </tr>
    
    
    <?php
    echo "Nombre de livres trouvés : ".$nombreLivres;
    echo "<br><br>";
    ?>
    
    <?php
    $k=0;
    foreach ($livres as $l):
        $k++;
        if($k%2==0){?> <tr bgcolor="#FF5D00"> <?php }else{ ?> <tr bgcolor="#9900CC"> <?php }
    ?>
        
            <td><?php echo $l['id']; ?></td>
            <td><?php echo $l['titre']; ?></td>
            <td><?php echo $l['couverture']; ?></td>
            <td><?php echo $l['idAuteur']; ?></td>
            <td><?php echo $l['idEditeur']; ?></td>
            <td><?php echo $l['idQuizz']; ?></td>
            <td><img src="<?php echo base_url('img/'.$l['couverture']) ?>" alt="<?php echo $l['titre']; ?>" height="50" width="50"> </td>
            <td>
                <a href="<?php echo site_url('livre/edit/'.$l['id']); ?>">Edit</a> |
                <input type="checkbox" name="<?php echo 'supprimer_'.$l['id']; ?>" value="ON" onclick="myfunction(this); gererListe(this);"/>
                <!-- <a href="<?php // echo site_url('livre/remove/'.$l['id']); ?>">Delete</a> -->
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<?php echo '<br><br>'.$links; ?>

<?php // $ck=555; ?>

<?php
function gererListe($obj)
{
    echo "-----".$obj."-----";
    myfunction($obj);
}
?>


<script type="text/javascript">

function myfunction(obj){
    if (obj.checked)
    {
        alert(obj.name.replace("supprimer_",""));
    }
    else
    {
        //some other code if you want something to happen when it is unchecked
    }
}

</script>