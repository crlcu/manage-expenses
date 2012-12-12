<ul class="breadcrumb">
    <li class="active"><?=__('Receivables')?></li>
</ul>


<table class="table table-hover table-stripped">
    <thead>
        <tr>
            <th><?=$this->Paginator->sort('ParentCategory.name', __('Category')); ?></th>
            <th><?=$this->Paginator->sort('ChildCategory.name', __('Subcategory')); ?></th>
            <th><?=$this->Paginator->sort('Receivable.description', __('Description')); ?></th>
            <th><?=$this->Paginator->sort('Receivable.value', __('Value')); ?></th>
            <th class="span2"><?php echo $this->Paginator->sort('Receivable.date', __('Date')); ?></th>
            <th class="span1">
                <?=$this->Html->link('<i class="icon-plus"></i>', array('plugin' => 'expenses', 'controller' => 'receivables', 'action' => 'add'), array('escape' => false, 'title' => __('Add')))?>
            </th>
        </tr>
    </thead>
    
    <tbody>
        <?php foreach ($receivables as $receipt):?>
        <tr>
                <td><?=$receipt['ParentCategory']['name']? $this->Html->link($receipt['ParentCategory']['name'], array('controller' => 'receivables', 'action' => 'category', $receipt['ParentCategory']['id'] )) : $this->Html->link($receipt['ChildCategory']['name'], array('controller' => 'receivables', 'action' => 'category', $receipt['ChildCategory']['id'] ))?></td>
                <td><?=$receipt['ParentCategory']['name']? $this->Html->link($receipt['ChildCategory']['name'], array('controller' => 'receivables', 'action' => 'subcategory', $receipt['ChildCategory']['id'] )) : ''?></td>
                <td><?=$receipt['Receivable']['description']?></td>
                <td><?=$receipt['Receivable']['value']?></td>
                <td><?=$receipt['Receivable']['date']?></td>
                <td>
                    <?php echo $this->Html->link('<i class="icon-edit"></i>', array('plugin' => 'expenses', 'controller' => 'receivables', 'action' => 'edit', $receipt['Receivable']['id']), array('escape' => false, 'title' => __('Edit')))?>
                    <?php echo $this->Html->link('<i class="icon-remove"></i>', array('plugin' => 'expenses', 'controller' => 'receivables', 'action' => 'delete', $receipt['Receivable']['id']), array('escape' => false, 'title' => __('Delete'), 'confirm' => __('Are you sure you want to delete?')))?>
                </td>
            </tr>
        <?php endforeach?>
    </tbody>
    
    <tfoot>
        <tr class="footer">
            <td colspan="3"><strong><?=__('Total')?></strong></td>
            <td colspan="3"><strong><?=$total?></strong></td>
        </tr>
        <tr class="footer">
            <td colspan="3"><?=date('F')?></td>
            <td colspan="3"><?=$total_current?></td>
        </tr>
    </tfoot>
</table>

<?=$this->element('paginator')?>