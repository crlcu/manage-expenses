<table class="table table-bordered table-condensed table-striped table-hover">
    <thead>
        <tr>
            <th class="span2"><?php echo $this->Paginator->sort('UserDetail.first_name', __('Name'), array('escape' => false)); ?></th>
            <th class="span2"><?php echo $this->Paginator->sort('User.username', __('Username'), array('escape' => false)); ?></th>
            <th class="span2"><?php echo $this->Paginator->sort('User.email', __('Email'), array('escape' => false)); ?></th>
            <th class="span2"><?php echo $this->Paginator->sort('UserGroup.name', __('Group'), array('escape' => false)); ?></th>
            <th class="span2"><?php echo $this->Paginator->sort('UserActivity.last_url', __('Last URL'), array('escape' => false)); ?></th>
            <th class="span2"><?php echo $this->Paginator->sort('UserActivity.user_browser', __('Browser'), array('escape' => false)); ?></th>
            <th class="span2"><?php echo $this->Paginator->sort('UserActivity.ip_address', __('Ip address'), array('escape' => false)); ?></th>
            <th class="span2"><?php echo $this->Paginator->sort('UserActivity.modified', __('Last action'), array('escape' => false)); ?></th>
            <th class="span1"><?php echo __('Action');?></th>
        </tr>
    </thead>
    
	<tbody>
        <?php if (!empty($users)): ?>
			<?php for ($i = 0; $i < sizeof($users); $i++):?>
				<tr>
				    <td><?=($users[$i]['UserActivity']['user_id'] == null) ? 'Guest' : h($users[$i]['User']['UserDetail']['full_name']);?></td>
				    <td><?=$users[$i]['User']['username'];?></td>
                    <td><?=$users[$i]['User']['email'];?></td>
                    <td><?=$users[$i]['User']['Group']['name'];?></td>
				    <td><?=$this->Html->link(Router::url(json_decode($users[$i]['UserActivity']['params'], true), true), Router::url(json_decode($users[$i]['UserActivity']['params'], true), true), array('target' => '_blank'));?></td>
				    <td><?=h($users[$i]['UserActivity']['user_browser']);?></td>
				    <td><?=h($users[$i]['UserActivity']['ip_address']);?></td>
				    <td><?=distanceOfTimeInWords(strtotime($users[$i]['UserActivity']['modified']));?></td>
				    <td></td>
                </tr>
            <?php endfor ?>
		<?php else: ?>
			<tr>
				<td colspan="9" class="text-align-center"><?php echo __('no records found')?></td>
			</tr>
	   <?php endif?>
	</tbody>
    
    <tfoot>
        <td colspan="9"><?=$this->element('paginator', array(), array('plugin' => 'Users'))?></td>
    </tfoot>
</table>