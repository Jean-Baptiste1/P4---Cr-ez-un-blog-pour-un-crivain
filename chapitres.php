<?php
require 'lib/autoload.php';

$db = DBFactory::getMysqlConnexionWithPDO();
$manager = new NewsManagerPDO($db);
?>


<?php $content = ob_start();

if (isset($_GET['id']))
{
  $news = $manager->getUnique((int) $_GET['id']);
  
  echo '<p>Par <em>', $news->auteur(), '</em>, le ', $news->dateAjout()->format('d/m/Y à H\hi'), '</p>', "\n",
       '<h2>', $news->titre(), '</h2>', "\n",
       '<p id="text">', nl2br($news->contenu()), '</p>', "\n";
  
  if ($news->dateAjout() != $news->dateModif())
  {
    echo '<p style="text-align: right;"><small><em>Modifiée le ', $news->dateModif()->format('d/m/Y à H\hi'), '</em></small></p>';
  }
}

else
{
  echo '<h2 style="text-align:center">Liste de tous les chapitres</h2>';
  
  foreach ($manager->getList(0, 20) as $news)
  {
    if (strlen($news->contenu()) <= 350)
    {
      $contenu = $news->contenu();
    }
    
    else
    {
      $debut = substr($news->contenu(), 0, 350);
      $debut = substr($debut, 0, strrpos($debut, ' ')) . '...';
      
      $contenu = $debut;
    }
    
    echo '<div id="text"><h4><a href="?id=', $news->id(), '">', $news->titre(), '</a></h4>', "\n",
         '<p>', nl2br($contenu), '</p></div>';
  }
}
?>

<?php $content = ob_get_clean(); ?>

<?php require('App/Frontend/Templates/template.php'); ?>