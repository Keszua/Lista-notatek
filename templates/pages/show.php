<div>
    <?php $note = $params['note'] ?? null; ?>
    <?php if($note): ?>
        <ul>
            <li>Id: <?= (int) ($note['Id']) ?> </li>
            <li>Tytuł: <?= htmlentities($note['title']) ?> </li>
            <li><?= htmlentities($note['description']) ?> </li>
            <li>Utworzono: <?= htmlentities($note['created']) ?> </li>
        </ul>
    <?php else: ?>
        <div> Brak notatki do wyświetlenia </div>
    <?php endif ?>

    <a href="/"> 
        <button>Powrót do listy notatek</button>
    </a>


</div>