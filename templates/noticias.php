<?php
foreach ($rss as $item):?>
    <div class="item">
        <h2><a href="<?php echo $item->get_permalink(); ?>"><?php echo $item->get_title(); ?></a></h2>
        <p><?php echo $item->get_description(); ?></p>
        <p><small>Posted on <?php echo $item->get_date('j F Y | g:i a'); ?></small></p>
    </div>
<?php endforeach; ?>