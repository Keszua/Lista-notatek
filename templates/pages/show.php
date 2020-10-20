<div>
    <?php $note = $params['note'] ?? null; ?>
    <?php if($note): ?>
        <ul>
            <li>Id: <?= ($note['Id']) ?> </li>
            <li>Tytuł: <?= $note['title'] ?> </li>
            <li><?= $note['description'] ?> </li>
            <li>Utworzono: <?= $note['created'] ?> </li>
        </ul>
    <?php else: ?>
        <div> Brak notatki do wyświetlenia </div>
    <?php endif ?>

    <a href="/"> 
        <button>Powrót do listy notatek</button>
    </a>


</div>