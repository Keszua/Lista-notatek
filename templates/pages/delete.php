<div class="show">
    <?php $note = $params['note'] ?? null; ?>
    <?php if($note): ?>
        <ul>
            <li>Id: <?= ($note['id']) ?> </li>
            <li>Tytuł: <?= $note['title'] ?> </li>
            <li><?= $note['description'] ?> </li>
            <li>Utworzono: <?= $note['created'] ?> </li>
        </ul>

        <!-- <a href="/?action=edit&id=<?= $note['id'] ?>">
            <button>Edytuj</button>
        </a> -->

        <form method="POST" action="/?action=delete">
            <input type="hidden" name="id" value="<?= $note['id'] ?>" />
            <!-- <button>Usuń</button> -->
            <input type="submit" value="Usuń"/>
            

        </form>

    <?php else: ?>
        <div> Brak notatki do wyświetlenia </div>
    <?php endif ?>

    <a href="/"> 
        <button>Powrót do listy notatek</button>
    </a>


</div>