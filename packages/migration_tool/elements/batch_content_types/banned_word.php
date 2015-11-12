<table class="migration-table table table-bordered table-striped">
    <thead>
    <tr>
        <th><?=t('Word')?></th>
    </tr>
    </thead>
    <tbody>
    <? foreach($collection->getWords() as $word) {
        $validator = $word->getPublisherValidator();
        ?>
        <tr <? if ($validator->skipItem()) { ?>class="migration-item-skipped"<? } ?>>
            <td><?=$word->getWord()?></td>
        </tr>
    <? } ?>
    </tbody>
</table>
