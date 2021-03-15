<?php

    declare(strict_types=1);

    global $remoteUsers;
?>
<table id="remote-users" class="remote-users">
    <caption>Remote Users List</caption>
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">User Name</th>
        </tr>
    </thead>
    <tbody>
        <?php if (true === $remoteUsers['is_success']) : ?>
            <?php foreach ($remoteUsers['users'] as $rUser) : ?>
                <tr id="<?php echo esc_attr($rUser->id) ?>">
                    <th scope="row"><a><?php echo esc_html($rUser->id)  ?></a></th>
                    <td><a><?php echo esc_html($rUser->name) ?></a></td>
                    <td><a><?php echo esc_html($rUser->username) ?></a></td>
                </tr>
            <?php endforeach; ?>
        <?php elseif (false === $remoteUsers['is_success']) : ?>
            <tr>
                <td scope="row colspan=" 3"><?php __('Please try again after few minutes.', 'remote-users') ?></td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
<?php
