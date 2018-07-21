<?php /** This is paging layout */
?>
<div class="page-nav">
    <?php echo paginate_links(array(
            'type' => 'plain',
            'prev_text' => '<i class="fa fa-angle-left"></i>',
            'next_text' => '<i class="fa fa-angle-right"></i>'
        )
    ) ?>
</div>