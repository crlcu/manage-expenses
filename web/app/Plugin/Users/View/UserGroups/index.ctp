<?=$this->Form->create()?>
<table id="users" class="table table-bordered table-condensed table-striped table-hover">
	<thead>
		<tr class="search">
			<td class="span1"><?=$this->Form->input('UserGroup.id', array('type' => 'text', 'escape' => false, 'label' => false, 'class' => 'span12', 'placeholder' => __('ID')));?></td>
			<td><?=$this->Form->input('UserGroup.name', array('escape' => false, 'label' => false, 'class' => 'span12', 'placeholder' => __('Name')));?></td>
			<td><?=$this->Form->input('UserGroup.alias_name', array('escape' => false, 'label' => false, 'class' => 'span12', 'placeholder' => __('Alias name')));?></td>
			<td><?=$this->Form->input('UserGroup.allow_registration', array('escape' => false, 'label' => false, 'options' => array('' => __('All'), '1' => __('Yes'), '0' => __('No') ), 'class' => 'span12'));?></td>
			<td><?=$this->Form->input('UserGroup.created', array('type' => 'text', 'escape' => false, 'label' => false, 'class' => 'span12', 'placeholder' => __('Created')));?></td>
			<td><?=$this->Form->input('UserGroup.modified', array('type' => 'text', 'escape' => false, 'label' => false, 'class' => 'span12', 'placeholder' => __('Modified')));?></td>
			<td class="text-align-center">
				<button type="submit" class="btn" onclick="return search.submit( $(this).closest('form') )"><i class="icon-search"></i></button>
			</td>
		</tr>
		<tr>
			<th class="span1 text-align-center"><?php echo $this->Paginator->sort('UserGroup.id', __('ID'), array('escape' => false)); ?></th>
			<th class="span2"><?php echo $this->Paginator->sort('UserGroup.name', __('Name'), array('escape' => false)); ?></th>
			<th class="span2"><?php echo $this->Paginator->sort('UserGroup.alias_name', __('Alias name'), array('escape' => false));?></th>
			<th class="span2"><?php echo $this->Paginator->sort('UserGroup.allow_registration', __('Allow registration'), array('escape' => false));?></th>
			<th class="span2"><?php echo $this->Paginator->sort('UserGroup.created', __('Created'), array('escape' => false));?></th>
			<th class="span2"><?php echo $this->Paginator->sort('UserGroup.modified', __('Modified'), array('escape' => false));?></th>
			<th class="span1 text-align-center">Action</th>
		</tr>
	</thead>
	
    <tbody>
		<?php if (sizeof($groups)):?>
			<?php for ($i = 0; $i < sizeof($groups); $i++):?>
			<tr>
				<td class="text-align-center"><?=$groups[$i]['UserGroup']['id']?></td>
				<td><?=$groups[$i]['UserGroup']['name']?></td>
				<td><?=$groups[$i]['UserGroup']['alias_name']?></td>
				<td><?=$groups[$i]['UserGroup']['allow_registration']? __('Yes') : __('No')?></td>
				<td><?=$groups[$i]['UserGroup']['created']?></td>
				<td><?=$groups[$i]['UserGroup']['modified']?></td>
				<td class="text-align-center">
					<?=$this->Html->link('<i class="icon-edit"></i>', array('plugin' => 'users', 'controller' => 'user_groups', 'action' => 'edit', $groups[$i]['UserGroup']['id']),
						array('escape' => false, 'title' => __('Edit'), 'onclick' => 'return modal.open(this.href, $(this).data())',
							'data-modal-header' => __('Edit group'), 'data-modal-close' => __('Close'), 'data-modal-save' => __('Save changes')));?>
				</td>
			</tr>	
			<?php endfor?>
		<?php else:?>
			<tr>
				<td colspan="7"><?php echo __('no records found')?></td>
			</tr>
		<?php endif?>
	</tbody>
    
    <tfoot>
        <td colspan="7"><?=$this->element('paginator', array(), array('plugin' => 'Users'))?></td>
    </tfoot>
</table>
<?=$this->Form->end();?>