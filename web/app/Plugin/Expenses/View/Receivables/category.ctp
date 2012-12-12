<ul class="breadcrumb">
    <li>
        <?=$this->Html->link(__('Receivables'), array('plugin' => 'expenses', 'controller' => 'payments', 'action' => 'index'));?>
        <span class="divider">/</span>
    </li>
    <li class="active"><?=$category['Category']['name']?></li>
</ul>

<table class="table table-hover table-stripped">
    <thead>
    <tr>
        <th><?=$this->Paginator->sort('ChildCategory.name', __('Category')); ?></th>
        <th><?=$this->Paginator->sort('Receivable.description', __('Description')); ?></th>
        <th><?=$this->Paginator->sort('Receivable.value', __('Value')); ?></th>
        <th class="span2"><?php echo $this->Paginator->sort('Receivable.date', __('Date')); ?></th>
        <th class="span1">
            <?=$this->Html->link('<i class="icon-plus"></i>', array('controller' => 'receivables', 'action' => 'add', $category['Category']['id']), array('escape' => false, 'title' => __('Add')))?>
        </th>
    </tr>
    </thead>
    
    <tbody>
    <?php foreach ($receivables as $receipt):?>
    <tr>
        <td><?=$this->Html->link($receipt['ChildCategory']['name'], array('controller' => 'receivables', 'action' => 'subcategory', $receipt['ChildCategory']['id'] ))?></td>
        <td><?=$receipt['Receivable']['description']?></td>
        <td><?=$receipt['Receivable']['value']?></td>
        <td><?=$receipt['Receivable']['date']?></td>
        <td>
            <?=$this->Html->link('<i class="icon-edit"></i>', array('controller' => 'receivables', 'action' => 'edit', $receipt['Receivable']['id']), array('escape' => false, 'title' => __('Edit')))?>
            <?=$this->Html->link('<i class="icon-remove"></i>', array('controller' => 'receivables', 'action' => 'delete', $receipt['Receivable']['id']), array('escape' => false, 'title' => __('Delete'), 'confirm' => __('Are you sure you want to delete?')))?>
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