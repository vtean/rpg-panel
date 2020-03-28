<?php getHeader($data); ?>
    <h3 class="dv-page-title">Assign Groups to: <?php echo $data['user']['NickName']; ?></h3>
    <div class="dv-row">
        <div class="row">
            <div class="col-lg-5 col-sm-12 col-12">
                <form action="" method="POST" class="dv-form">
                    <div class="form-group">
                        <input type="hidden" name="csrfToken" value="<?php echo $_SESSION['csrfToken']; ?>">
                        <div class="dv-custom-select">
                            <select name="userGroups[]" id="userGroups" class="form-control" multiple="multiple" size="15">
                                <?php foreach ($data['groups'] as $group): ?>
                                    <option value="<?php echo $group['group_id']; ?>"<?php if ($data['userGroups']): if (in_array($group['group_id'], $data['userGroups'])): ?> selected='selected'<?php endif; endif; ?>><?php echo $group['group_name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="text-align-center">
                        <button type="submit" name="assign_group" class="dv-btn btn btn-primary m-auto">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php getFooter(); ?>