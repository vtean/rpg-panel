<?php getHeader($data); ?>
    <?php flashMessage(); ?>
    <?php
        echo "{$data['info']['players']}/{$data['info']['maxPlayers']}";
        foreach ($data['players'] as $player):
            echo "<table><tr><td>{$player['name']}</td><td> - {$player['score']}</td></tr>";
        endforeach;
    ?>
<?php getFooter(); ?>