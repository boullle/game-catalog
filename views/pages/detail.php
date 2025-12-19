<?php
$game ??= [];
$id ??=0;
$success ??=false;
?>

<?php if ($success): ?>
    <h1><?= $success  ?></h1>
<?php endif; ?>

<?php if (!$game): ?>
    <h1>Le jeu demandé n'est pas trouvé</h1>
<?php else: ?>
    <h1><?= $game['title'] ?></h1>
    <h1><?= $game['platform'] ?></h1>
<?php endif; ?>
