<div class="pull-left">
    <?=$this->Paginator->counter( ADMIN_PAGINATOR_COUNTER );?>
</div>

<?php if ( $this->Paginator->numbers() ) :?>
<div class="pagination pagination-right">
    <ul>
        <?php
            // Shows the prev
            echo $this->Paginator->prev('&laquo;', array('escape' => false, 'tag' => 'li', 'class' => 'prev'), null, array('class' => 'hide'));
             
            // Shows the page numbers
            echo $this->Paginator->numbers(array('modulus' => 5, 'tag' => 'li', 'currentClass' => 'active', 'separator' => false));
            
            //Shows the next
            echo $this->Paginator->next('&raquo;', array('escape' => false, 'tag' => 'li', 'class' => 'next'), null, array('class' => 'hide'));
        ?>
    </ul>
</div>
<?php endif ?>