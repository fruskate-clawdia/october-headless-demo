<?php Block::put('breadcrumb') ?>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= Backend::url('demo/api/todos') ?>">Todos</a></li>
        <li class="breadcrumb-item active">Create</li>
    </ol>
<?php Block::endPut() ?>

<?= Form::open(['class' => 'layout']) ?>

    <div class="layout-row">
        <?= $this->formRender() ?>
    </div>

    <div class="form-buttons">
        <div class="loading-indicator-container">
            <button
                type="submit"
                data-request="onSave"
                data-hotkey="ctrl+s, cmd+s"
                data-load-indicator="Creating Todo..."
                class="btn btn-primary">
                Create
            </button>
            <span class="btn-text">
                or <a href="<?= Backend::url('demo/api/todos') ?>">Cancel</a>
            </span>
        </div>
    </div>

<?= Form::close() ?>
