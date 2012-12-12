<?=$this->Form->create()?>
<table id="settings" class="table table-bordered table-condensed table-striped table-hover">
	<thead>
        <tr class="search">
			<td><?=$this->Form->input('Route.url', array('type' => 'text', 'escape' => false, 'label' => false, 'class' => 'span12', 'placeholder' => __('URL')));?></td>
			<td><?=$this->Form->input('Route.plugin', array('type' => 'text', 'escape' => false, 'label' => false, 'class' => 'span12', 'placeholder' => __('Plugin')));?></td>
			<td><?=$this->Form->input('Route.controller', array('escape' => false, 'label' => false, 'class' => 'span12', 'placeholder' => __('Controller')));?></td>
			<td><?=$this->Form->input('Route.action', array('escape' => false, 'label' => false, 'class' => 'span12', 'placeholder' => __('Action')));?></td>
            <td class="text-align-center">
				<button type="submit" class="btn" onclick="return search.submit( $(this).closest('form') )"><i class="icon-search"></i></button>
			</td>
		</tr>
		<tr>
			<th class="span5"><?php echo $this->Paginator->sort('Route.url', __('URL'), array('escape' => false)); ?></th>
			<th class="span2"><?php echo $this->Paginator->sort('Route.plugin', __('Plugin'), array('escape' => false));?></th>
			<th class="span2"><?php echo $this->Paginator->sort('Route.controller', __('Controller'), array('escape' => false));?></th>
			<th class="span2"><?php echo $this->Paginator->sort('Route.action', __('Action'), array('escape' => false));?></th>
            <th class="span1 text-align-center">
				<?php echo __('Action');?>
				<?=$this->Html->link('<i class="icon-plus"></i>', array('plugin' => 'routes', 'controller' => 'routes', 'action' => 'add'),
						array('escape' => false, 'title' => __('Add'), 'onclick' => 'return modal.open(this.href, $(this).data())',
						'data-modal-header' => __('Add route'), 'data-modal-close' => __('Close'), 'data-modal-save' => __('Add')));?>
			</th>
		</tr>
	</thead>
	
	<tbody>
        <?php if (sizeof($routes)):?>
    		<?php for ($i = 0; $i < sizeof($routes) ; $i++):?>
    		<tr class="edit">
    			<td><?=$this->Html->link(Router::url('/', true) .  $routes[$i]['Route']['url'], Router::url('/', true) .  $routes[$i]['Route']['url'], array('target' => '_blank'))?></td>
    			<td><?=$routes[$i]['Route']['plugin']?></td>
    			<td><?=$routes[$i]['Route']['controller']?></td>
				<td><?=$routes[$i]['Route']['action']?></td>
                <td class="text-align-center">
					<?=$this->Html->link('<i class="icon-edit"></i>', array('plugin' => 'routes', 'controller' => 'routes', 'action' => 'edit', $routes[$i]['Route']['id']),
						array('escape' => false, 'title' => __('Edit'), 'onclick' => 'return modal.open(this.href, $(this).data())',
							'data-modal-header' => __('Edit setting'), 'data-modal-close' => __('Close'), 'data-modal-save' => __('Save changes')));?>
					<?=$this->Html->link('<i class="icon-remove"></i>', array('plugin' => 'routes', 'controller' => 'routes', 'action' => 'delete', $routes[$i]['Route']['id']),
						array('escape' => false, 'title' => __('Delete')), __('Are you sure you want to delete?'));?>
				</td>
    		</tr>	
    		<?php endfor?>
        <?php else:?>
			<tr>
				<td colspan="5" class="text-align-center"><?php echo __('no records found')?></td>
			</tr>
		<?php endif?>
	</tbody>
    
    <tfoot>
        <td colspan="5"><?=$this->element('paginator', array(), array('plugin' => 'Routes'))?></td>
    </tfoot>
</table>
<?=$this->Form->end();?>