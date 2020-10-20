
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
                        default:
                            break;
                    }
                }
            ?>
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
                            <td><?= $note['Id'] ;  ?></td>
                            <td><?= $note['title']   ?></td>
                            <td><?= $note['created']   ?></td>
                            <td>
                                <a href="/?action=show&id=<?= $note['Id'] ?>">
                                    <button>Pokaż</button>
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
