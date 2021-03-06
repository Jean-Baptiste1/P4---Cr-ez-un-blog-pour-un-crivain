<?php session_start();

if (isset($_POST['nom'])) $_SESSION['nom'] = $_POST['nom'];
if (isset($_POST['mot_de_passe'])) $_SESSION['mot_de_passe'] = $_POST['mot_de_passe'];

if ((isset($_SESSION['nom'])) AND $_SESSION['nom'] == "a" AND (isset($_SESSION['mot_de_passe'])) AND $_SESSION['mot_de_passe'] == "a")
// Si le mot de passe est bon

{
var_dump($_SESSION);
    
$content = ob_start();

require 'lib/autoload.php';

$db = DBFactory::getMysqlConnexionWithPDO();
$manager = new NewsManagerPDO($db);

if (isset($_GET['modifier']))
{
  $news = $manager->getUnique((int) $_GET['modifier']);
}

if (isset($_GET['supprimer']))
{
  $manager->delete((int) $_GET['supprimer']);
  $message = 'La news a bien été supprimée !';
}

if (isset($_POST['auteur']))
{
  $news = new News(
    [
      'auteur' => $_POST['auteur'],
      'titre' => $_POST['titre'],
      'contenu' => $_POST['contenu']
    ]
  );
  
  if (isset($_POST['id']))
  {
    $news->setId($_POST['id']);
  }
  
  if ($news->isValid())
  {
    $manager->save($news);
    
    $message = $news->isNew() ? 'La news a bien été ajoutée !' : 'La news a bien été modifiée !';
  }
  else
  {
    $erreurs = $news->erreurs();
  }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>
            Administration
        </title>
        <meta charset="utf-8" />
    </head>
  
  <body>
    <form action="admin.php" method="post">
      <p style="text-align: center">
<?php
if (isset($message))
{
  echo $message, '<br />';
}
?>
        <?php if (isset($erreurs) && in_array(News::AUTEUR_INVALIDE, $erreurs)) echo 'L\'auteur est invalide.<br />'; ?>
        Auteur : <input type="text" name="auteur" value="<?php if (isset($news)) echo $news->auteur(); ?>" /><br />
        
        <?php if (isset($erreurs) && in_array(News::TITRE_INVALIDE, $erreurs)) echo 'Le titre est invalide.<br />'; ?>
        Titre : <input type="text" name="titre" value="<?php if (isset($news)) echo $news->titre(); ?>" /><br />
        
        <?php if (isset($erreurs) && in_array(News::CONTENU_INVALIDE, $erreurs)) echo 'Le contenu est invalide.<br />'; ?>
        Contenu :<br /><textarea rows="8" cols="60" name="contenu"><?php if (isset($news)) echo $news->contenu(); ?></textarea><br />
<?php
if(isset($news) && !$news->isNew())
{
?>
        <input type="hidden" name="id" value="<?= $news->id() ?>" />
        <input type="submit" value="Modifier" name="modifier" />
<?php
}
else
{
?>
        <input type="submit" value="Ajouter" />
<?php
}
?>
      </p>
    </form>
    
    <p style="text-align: center">Il y a actuellement <?= $manager->count() ?> news. En voici la liste :</p>
    
    <table>
      <tr><th>Auteur</th><th>Titre</th><th>Date d'ajout</th><th>Dernière modification</th><th>Action</th></tr>
<?php
foreach ($manager->getList() as $news)
{
  echo '<tr><td>', $news->auteur(), '</td><td>', $news->titre(), '</td><td>', $news->dateAjout()->format('d/m/Y à H\hi'), '</td><td>', ($news->dateAjout() == $news->dateModif() ? '-' : $news->dateModif()->format('d/m/Y à H\hi')), '</td><td><a href="?modifier=', $news->id(), '">Modifier</a> | <a href="?supprimer=', $news->id(), '">Supprimer</a></td></tr>', "\n";
}
?>
    </table>
  </body>
</html>

<?php $content = ob_get_clean();

require 'App/Backend/Templates/template.php';
    
$_SESSION = array();
    
}
else // Sinon, on affiche un message d'erreur
{
echo '<p>Mot de passe incorrect</p>';
echo '<a href="Connexion.php">Retour</a>';
}
?>