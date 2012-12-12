<ul class="breadcrumb">
    <li class="active"><?=__('Payments')?></li>
</ul>

<table class="table table-hover table-stripped">
    <thead>
        <tr>
            <th><?=$this->Paginator->sort('ParentCategory.name', __('Category')); ?></th>
            <th><?=$this->Paginator->sort('ChildCategory.name', __('Subcategory')); ?></th>
            <th><?=$this->Paginator->sort('Payment.description', __('Description')); ?></th>
            <th><?=$this->Paginator->sort('Payment.value', __('Value')); ?></th>
            <th class="span2"><?php echo $this->Paginator->sort('Payment.date', __('Date')); ?></th>
            <th class="span1">
                <?=$this->Html->link('<i class="icon-plus"></i>', array('plugin' => 'expenses', 'controller' => 'payments', 'action' => 'add'), array('escape' => false, 'title' => __('Add')))?>
            </th>
        </tr>
    </thead>
    
    <tbody>
    <?php foreach ($payments as $payment):?>
    <tr>
        <td><?=$payment['ParentCategory']['name']? $this->Html->link($payment['ParentCategory']['name'], array('controller' => 'payments', 'action' => 'category', $payment['ParentCategory']['id'] )) : $this->Html->link($payment['ChildCategory']['name'], array('controller' => 'payments', 'action' => 'category', $payment['ChildCategory']['id'] ))?></td>
        <td><?=$payment['ParentCategory']['name']? $this->Html->link($payment['ChildCategory']['name'], array('controller' => 'payments', 'action' => 'subcategory', $payment['ChildCategory']['id'] )) : ''?></td>
        <td><?=$payment['Payment']['description']?></td>
        <td><?=$payment['Payment']['value']?></td>
        <td><?=$payment['Payment']['date']?></td>
        <td>
            <?=$this->Html->link('<i class="icon-edit"></i>', array('plugin' => 'expenses', 'controller' => 'payments', 'action' => 'edit', $payment['Payment']['id']), array('escape' => false, 'title' => __('Edit')))?>
            <?=$this->Html->link('<i class="icon-remove"></i>', array('plugin' => 'expenses', 'controller' => 'payments', 'action' => 'delete', $payment['Payment']['id']), array('escape' => false, 'title' => __('Delete'), 'confirm' => __('Are you sure you want to delete?')))?>
        </td>
    </tr>
    <?php endforeach?>
    </tbody>
    
    <tfoot>
        <tr class="footer">
            <td colspan="3"><strong>Total</strong></td>
            <td colspan="3"><strong><?=$total?></strong></td>
        </tr>
        <tr class="footer">
            <td colspan="3"><?=date('F')?></td>
            <td colspan="3"><?=$total_current?></td>
        </tr>
    </tfoot>
</table>

<?=$this->element('paginator')?>