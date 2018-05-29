<?php
namespace OpenClassrooms\Blog\Model;
?>

<form action="index.php?action=update&amp;id=<?= $update['id'] ?>">
    <div>
        <label for="comment">Nouveau ommentaire</label><br />
        <textarea id="comment" name="comment"></textarea>
    </div>
    <div>
        <input type="submit" />
    </div>
</form>