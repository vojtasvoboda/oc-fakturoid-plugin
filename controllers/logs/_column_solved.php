<?php if (empty($record->solved)): ?>
    <a type="button" class="btn btn-default px-2 py-0" style="font-size: 12px" data-request="onSetSolved" data-request-data="id: <?= $record->id ?>">
        Solved
    </a>

<?php else: ?>
    <a type="button" class="btn btn-primary px-2 py-0 text-white" style="font-size: 12px" data-request="onUnsetSolved" data-request-data="id: <?= $record->id ?>">
        Back
    </a>
<?php endif; ?>
