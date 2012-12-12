<ul class="breadcrumb">
    <li>
        <?=$this->Html->link(__('Payments'), array('plugin' => 'expenses', 'controller' => 'payments', 'action' => 'index'));?>
        <span class="divider">/</span>
    </li>
    <li class="active"><?=$category['Category']['name']?></li>
</ul>

<table class="table table-hover table-stripped">
    <thead>
    <tr>
        <th><?=$this->Paginator->sort('ChildCategory.name', __('Category')); ?></th>
        <th><?=$this->Paginator->sort('Payment.description', __('Description')); ?></th>
        <th><?=$this->Paginator->sort('Payment.value', __('Value')); ?></th>
        <th class="span2"><?php echo $this->Paginator->sort('Payment.date', __('Date')); ?></th>
        <th class="span1">
            <?php echo $this->Html->link('<i class="icon-plus"></i>', array('controller' => 'payments', 'action' => 'add', $category['Category']['id']), array('escape' => false, 'title' => __('Add')))?>
        </th>
    </tr>
    </thead>
    
    <tbody>
        <?php foreach ($payments as $payment):?>
            <tr>
                <td><?=$this->Html->link($payment['ChildCategory']['name'], array('controller' => 'payments', 'action' => 'subcategory', $payment['ChildCategory']['id'] ))?></td>
                <td><?=$payment['Payment']['description']?></td>
                <td><?=$payment['Payment']['value']?></td>
                <td><?=$payment['Payment']['date']?></td>
                <td>
                    <?php echo $this->Html->link('<i class="icon-edit"></i>', array('controller' => 'payments', 'action' => 'edit', $payment['Payment']['id']), array('escape' => false, 'title' => __('Edit')))?>
                    <?php echo $this->Html->link('<i class="icon-remove"></i>', array('controller' => 'payments', 'action' => 'delete', $payment['Payment']['id']), array('escape' => false, 'title' => __('Delete'), 'confirm' => __('Are you sure you want to delete?')))?>
                </td>
            </tr>
        <?php endforeach?>
    </tbody>
    
    <tfoot>
        <tr class="footer">
            <td colspan="2"><strong><?=__('Total')?></strong></td>
            <td colspan="3" align="right"><strong><?=$total?></strong></td>
        </tr>
        <tr class="footer">
            <td colspan="2"><?=date('F')?></td>
            <td colspan="3" align="right"><?=$total_current?></td>
        </tr>
    </tfoot>
</table>

<?=$this->element('paginator')?>