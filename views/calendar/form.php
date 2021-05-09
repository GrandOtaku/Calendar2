<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label for="name">題名</label>
            <input id="name" type="text" requiered class="form-control" name="name" value="<?= isset($data['name']) ? h($data['name']) : '名前を挿入'; ?>">
            <?php if (isset($errors['name'])) : ?>
                <p class=" form-text"><?= $errors['name']; ?></p>
            <?php endif; ?>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label for="date">日取り</label>
            <input id="date" type="date" requiered class="form-control" name="date" value="<?= isset($data['date']) ? h($data['date']) : ''; ?>">
            <?php if (isset($errors['date'])) : ?>
                <p class="form-text"><?= $errors['date']; ?></p>
            <?php endif; ?>
        </div>
    </div>
</div>
<br>
<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label for="start">開始</label>
            <input id="start" type="time" requiered class="form-control" name="start" value="<?= isset($data['start']) ? h($data['start']) : 'HH:MM'; ?>"">
                    <?php if (isset($errors['start'])) : ?>
                        <p class=" form-text"><?= $errors['start']; ?></p>
        <?php endif; ?>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label for="end">終わり</label>
            <input id="end" type="time" requiered class="form-control" name="end" value="<?= isset($data['end']) ? h($data['end']) : 'HH:MM'; ?>">
            <?php if (isset($errors['end'])) : ?>
                <p class="form-text"><?= $errors['end']; ?></p>
            <?php endif; ?>
        </div>
    </div>
</div>
<br>
<div class="form-group">
    <label for="description">説明</label>
    <textarea name="description" id="description" class="form-control"><?= isset($data['description']) ? h($data['description']) : '名前を挿入'; ?></textarea>
</div>