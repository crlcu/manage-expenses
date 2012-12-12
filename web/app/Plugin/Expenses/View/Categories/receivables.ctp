<ul class="breadcrumb">
    <li>
        <?=$this->Html->link(__('Categories'), array('plugin' => 'expenses', 'controller' => 'categories', 'action' => 'payments'));?>
        <span class="divider">/</span>
    </li>
    <li class="active"><?=__('Receivables')?></li>
</ul>

<table class="table table-hover table-stripped">
    <thead>
        <tr>
            <th><?=$this->Paginator->sort('Category.name', __('Category')); ?></th>
            <th><?=$this->Paginator->sort('ParentCategory.name', __('Subcategory')); ?></th>
            <th class="span1">
                <?=$this->Html->link('<i class="icon-plus"></i>', array('controller' => 'categories', 'action' => 'add', 'receivables'), array('escape' => false, 'title' => __('Add')))?>
            </th>
        </tr>
    </thead>
    
    <tbody>
        <?php if ( $categories ): ?>
            <?php foreach($categories as $category):?>
                <tr>
                    <td><?php echo $this->Html->link($category['Category']['name'], array('controller' => 'receivables', 'action' => 'category', $category['Category']['id'] ));?></td>
                    <td></td>
                    <td>
                        <?php echo $this->Html->link('<i class="icon-edit"></i>', array('controller' => 'categories', 'action' => 'edit', $category['Category']['id'], 'receivables'), array('escape' => false, 'title' => __('Edit')))?>
                        <?php echo $this->Html->link('<i class="icon-remove"></i>', array('controller' => 'categories', 'action' => 'delete',  $category['Category']['id']), array('escape' => false, 'title' => __('Delete'), 'confirm' => __('Are you sure you want to delete?')))?>
                    </td>
                </tr>       
                <?php foreach ($category['ChildCategory'] as $child):?>
                <tr>
                    <td></td>
                    <td><?php echo $this->Html->link($child['name'], array('controller' => 'receivables', 'action' => 'subcategory', $child['id'] ));?></td>    
                    <td>
                        <?php echo $this->Html->link('<i class="icon-edit"></i>', array('controller' => 'categories', 'action' => 'edit', $child['id'], 'receivables'), array('escape' => false, 'title' => __('Edit')))?>
                        <?php echo $this->Html->link('<i class="icon-remove"></i>', array('controller' => 'categories', 'action' => 'delete',  $child['id']), array('escape' => false, 'title' => __('Delete'), 'confirm' => __('Are you sure you want to delete?')))?>
                    </td>
                </tr>
                <?php endforeach?>
            <?php endforeach?>
        <?php else : ?>
            <tr><td colspan="3"><?=__('no receivables categories found')?></td></tr>
        <?php endif ?>
    </tbody>
</table>

<?=$this->element('paginator')?>