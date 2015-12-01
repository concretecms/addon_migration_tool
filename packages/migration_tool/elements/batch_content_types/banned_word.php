<table class="migration-table table table-bordered table-striped">
    <thead>
    <tr>
        <th><?=t('Word')?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($collection->getWords() as $word) {
    $validator = $word->getPublisherValidator();
    ?>
        <tr <?php if ($validator->skipItem()) {
    ?>class="migration-item-skipped"<?php 
}
    ?>>
            <td><?=$word->getWord()?></td>
        </tr>
    <?php 
} ?>
    </tbody>
</table>
