<?=$this->Form->create()?>
<table id="settings" class="table table-bordered table-condensed table-striped table-hover">
	<thead>
        <tr class="search">
			<td><?=$this->Form->input('Setting.description', array('type' => 'text', 'escape' => false, 'label' => false, 'class' => 'span12', 'placeholder' => __('Description')));?></td>
			<td><?=$this->Form->input('Setting.value', array('type' => 'text', 'escape' => false, 'label' => false, 'class' => 'span12', 'placeholder' => __('Value')));?></td>
			<td><?=$this->Form->input('User.username', array('escape' => false, 'label' => false, 'class' => 'span12', 'placeholder' => __('Username')));?></td>
            <td class="text-align-center">
				<button type="submit" class="btn" onclick="return search.submit( $(this).closest('form') )"><i class="icon-search"></i></button>
			</td>
		</tr>
		<tr>
			<th class="span5"><?php echo $this->Paginator->sort('Setting.description', __('Description'), array('escape' => false)); ?></th>
			<th class="span4"><?php echo $this->Paginator->sort('Setting.value', __('Value'), array('escape' => false));?></th>
			<th class="span2"><?php echo $this->Paginator->sort('User.username', __('User'), array('escape' => false));?></th>
            <th class="span1 text-align-center"><?php echo __('Action');?></th>
		</tr>
	</thead>
	
	<tbody>
        <?php if (sizeof($settings)):?>
    		<?php for ($i = 0; $i < sizeof($settings); $i++):?>
    		<tr class="edit">
    			<td><?=__($settings[$i]['Setting']['description'])?></td>
    			<td><?=$settings[$i]['Setting']['type'] == 'boolean'? ($settings[$i]['Setting']['value'] == 1? __('Yes') : __('No')) : __($settings[$i]['Setting']['value']) ?></td>
    			<td><?=$settings[$i]['User']['username']?></td>
                <td class="text-align-center">
					<?=$this->Html->link('<i class="icon-edit"></i>', array('plugin' => 'settings', 'controller' => 'settings', 'action' => 'edit', $settings[$i]['Setting']['id']),
						array('escape' => false, 'title' => __('Edit'), 'onclick' => 'return modal.open(this.href, $(this).data())',
							'data-modal-header' => __('Edit setting'), 'data-modal-close' => __('Close'), 'data-modal-save' => __('Save changes')));?>
				</td>
    		</tr>	
    		<?php endfor?>
        <?php else:?>
			<tr>
				<td colspan="4" class="text-align-center"><?php echo __('no records found')?></td>
			</tr>
		<?php endif?>
	</tbody>
    
    <tfoot>
        <td colspan="4"><?=$this->element('paginator', array(), array('plugin' => 'Settings'))?></td>
    </tfoot>
</table>
<?=$this->Form->end();?>