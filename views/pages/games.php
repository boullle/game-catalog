<?php
$games = $games ?? [];
?>

<h1>Game Catalog</h1>
<p class="sub">Games sorted by ratings </p>



<?php foreach ($games as $game): ?>
    <article class="card">
        <h2 class="card__title"><?= $game['title'] ?></h2>

        <div class="meta">
            <span class="badge"><?= $game['platform'] ?></span>
            <span class="badge"><?= $game['genre'] ?></span>
            <span class="badge"><?= (int)$game['releaseYear'] ?></span>
            <span class="badge"><?= (int)$game['rating'] ?>/10</span>
        </div>
        <a href="/games/<?= $game['id'] ?>">Naviguer vers le détail</a>
 
    </article>
<?php endforeach; ?>