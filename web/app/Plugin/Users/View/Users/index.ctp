<?=$this->Form->create()?>
<table id="users" class="table table-bordered table-condensed table-striped table-hover">
	<thead>
		<tr class="search">
			<td><?=$this->Form->input('UserDetail.first_name', array('escape' => false, 'label' => false, 'class' => 'span12', 'placeholder' => __('First name')));?></td>
			<td><?=$this->Form->input('UserDetail.last_name', array('escape' => false, 'label' => false, 'class' => 'span12', 'placeholder' => __('Last name')));?></td>
			<td><?=$this->Form->input('User.username', array('escape' => false, 'label' => false, 'class' => 'span12', 'placeholder' => __('Username')));?></td>
			<td><?=$this->Form->input('User.email', array('escape' => false, 'label' => false, 'class' => 'span12', 'placeholder' => __('Email')));?></td>
			<td><?=$this->Form->input('UserGroup.name', array('escape' => false, 'label' => false, 'class' => 'span12', 'placeholder' => __('Group')));?></td>
			<td><?=$this->Form->input('UserDetail.gender', array('escape' => false, 'label' => false, 'options' => array('' => __('All'), 'male' => __('male'), 'female' => __('female') ), 'class' => 'span12'));?></td>
			<td><?=$this->Form->input('User.language', array('escape' => false, 'label' => false, 'class' => 'span12', 'placeholder' => __('Language')));?></td>
            <td><?=$this->Form->input('User.active', array('escape' => false, 'label' => false, 'options' => array('' => __('All'), '1' => __('Yes'), '0' => __('No') ), 'class' => 'span12'));?></td>
            <td><?=$this->Form->input('User.email_verified', array('escape' => false, 'label' => false, 'options' => array('' => __('All'), '1' => __('Yes'), '0' => __('No') ), 'class' => 'span12'));?></td>
            <td class="text-align-center">
				<button type="submit" class="btn" onclick="return search.submit( $(this).closest('form') )"><i class="icon-search"></i></button>
			</td>
		</tr>
		<tr>
			<th class="span1"><?php echo $this->Paginator->sort('UserDetail.first_name', __('First name'), array('escape' => false)); ?></th>
			<th class="span1"><?php echo $this->Paginator->sort('UserDetail.last_name', __('Last name'), array('escape' => false)); ?></th>
			<th class="span1"><?php echo $this->Paginator->sort('User.username', __('Username'), array('escape' => false));?></th>
			<th class="span2"><?php echo $this->Paginator->sort('User.email', __('Email'), array('escape' => false));?></th>
			<th class="span1"><?php echo $this->Paginator->sort('UserGroup.name', __('Group'), array('escape' => false));?></th>
			<th class="span1"><?php echo $this->Paginator->sort('UserDetail.gender', __('Gender'), array('escape' => false));?></th>
            <th class="span1"><?php echo $this->Paginator->sort('User.language', __('Language'), array('escape' => false));?></th>
            <th class="span1"><?php echo $this->Paginator->sort('User.active', __('Active'), array('escape' => false));?></th>
            <th class="span1"><?php echo $this->Paginator->sort('User.email_verified', __('Verified'), array('escape' => false));?></th>
			<th class="span1 text-align-center">
				<?php echo __('Action');?>
                <?=$this->Html->link('<i class="icon-plus"></i>', array('plugin' => 'users', 'controller' => 'users', 'action' => 'add'),
						array('escape' => false, 'title' => __('Add'), 'onclick' => 'return modal.open(this.href, $(this).data())',
						'data-modal-header' => __('Add user'), 'data-modal-close' => __('Close'), 'data-modal-save' => __('Add')));?>
			</th>
		</tr>
	</thead>
	
	<tbody>
		<?php if (sizeof($users)):?>
			<?php for ($i = 0; $i < sizeof($users); $i++):?>
			<tr class="edit">
				<td><?=$users[$i]['UserDetail']['first_name']?></td>
				<td><?=$users[$i]['UserDetail']['last_name']?></td>
				<td><?=$users[$i]['User']['username']?></td>
				<td><?=$users[$i]['User']['email']?></td>
				<td><?=$users[$i]['Group']['name']?></td>
				<td><?=$users[$i]['UserDetail']['gender']?></td>
                <td><?=$users[$i]['User']['language']?></td>
                <td><?=$users[$i]['User']['active']? __('Yes') : __('No')?></td>
                <td><?=$users[$i]['User']['email_verified']? __('Yes') : __('No')?></td>
				<td class="text-align-center">
					<?=$this->Html->link('<i class="icon-edit"></i>', array('plugin' => 'users', 'controller' => 'users', 'action' => 'edit', $users[$i]['User']['id']),
						array('escape' => false, 'title' => __('Edit'), 'onclick' => 'return modal.open(this.href, $(this).data())',
							'data-modal-header' => __('Edit user'), 'data-modal-close' => __('Close'), 'data-modal-save' => __('Save changes')));?>
					<?=$this->Html->link('<i class="icon-remove"></i>', array('plugin' => 'users', 'controller' => 'users', 'action' => 'delete', $users[$i]['User']['id']),
						array('escape' => false, 'title' => __('Delete')), __('Are you sure you want to delete?'));?>
				</td>
			</tr>	
			<?php endfor?>
		<?php else:?>
			<tr>
				<td colspan="10" class="text-align-center"><?php echo __('no records found')?></td>
			</tr>
		<?php endif?>
	</tbody>
    
    <tfoot>
        <td colspan="10"><?=$this->element('paginator', array(), array('plugin' => 'Users'))?></td>
    </tfoot>
</table>
<?=$this->Form->end();?>