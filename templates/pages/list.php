
<div class ="lista">
    <section>
        <div class='message'>
            <?php 
                if(!empty($params['error'])) {
                    switch($params['error']) {
                        case 'noteNotFound':
                            echo 'Notatka nie została znaleziona';
                            break;
                        case 'missingNoteId':
                            echo 'Niepoprwny identyfikator notatki';
                            break;
                        default:
                            break;
                    }
                }
            ?>
        </div>

        <div class='message'>
            <?php 
                if(!empty($params['before'])) {
                    switch($params['before']) {
                        case 'created':
                            echo 'Notatka została utworzona';
                            break;
                        case 'edited':
                            echo 'Notatka została zaktualizowana';
                            break;
                        case 'deleted':
                            echo 'Notatka została usunięta';
                            break;
                        default:
                            break;
                    }
                }
            ?>
        </div>

        <?php
            $sort = $params['sort'] ?? [];
            $by = $sort['by'] ?? 'title';
            $order = $sort['order'] ?? 'desc';
            dump($sort);
        ?>
        
        <div>
            <form class="settings-form" action="/" method="GET">
                <div>    
                    <div>Sortuj po:</div>
                    <label> Tytule: <input name="sortby" type="radio" value="title" <?php echo $by === 'title' ? 'checked' : '' ?> ></label>
                    <label> Dacie: <input name="sortby" type="radio" value="created" <?php echo $by === 'created' ? 'checked' : '' ?> ></label>
                </div>
                    
                <div>    
                    <div>Kierunek sortowania:</div>
                    <label> Rosnąco: <input name='sortorder' type='radio' value='asc' <?= $order === 'asc' ? 'checked' : '' ?> ></label>
                    <label> Malejąco: <input name='sortorder' type='radio' value='desc' <?= $order === 'desc' ? 'checked' : '' ?> ></label>
                </div>

                <input type="submit" value="Wyślij"/>
            </form>
        </div>


        <div class='tbl-header'>
            <table cellpadding='0' cellspacing="0" border="0">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Tytuł</th>
                        <th>Data</th>
                        <th>Opcje</th>
                    </tr>
                </thead>
            </table>
        </div>

        <div class='tbl-content'>
            <table cellpadding='0' cellspacing="0" border="0">
                <tbody>
                    <?php foreach($params['notes'] ?? [] as $note): ?>
                        <tr>
                            <td><?= $note['id'] ;  ?></td>
                            <td><?= $note['title']   ?></td>
                            <td><?= $note['created']   ?></td>
                            <td>
                                <a href="/?action=show&id=<?= $note['id'] ?>">
                                    <button>Pokaż</button>
                                </a>
                                <a href="/?action=delete&id=<?= $note['id'] ?>">
                                    <button>X</button>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    <section>


    <h4>lista notatek</h4>
    <b><?php echo $params['resultList'] ?? "" ?></b>

</div>
