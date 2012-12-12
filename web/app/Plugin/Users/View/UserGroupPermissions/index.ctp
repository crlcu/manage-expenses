<table id="permissions" class="table table-bordered table-condensed table-striped table-hover">
	<thead>
		<tr>
			<td colspan="4" class="text-align-right">
				<?=$this->Form->input('controller', array('div' => false, 'label' => false, 'options' => $allControllers, 'selected' => $active, 'class' => 'span2',
					'onchange' => "window.location = '".Router::url(array('plugin' => 'users', 'controller' => 'user_group_permissions', 'action' => 'index'), true)."/'+this.value"))?>
			</td>
		</tr>
		<tr>
            <th  class="span3"><?=__('Url')?></th>
			<th  class="span3"><?=__('Controller')?></th>
			<th  class="span3"><?=__('Action')?></th>
			<th  class="span3"><?=__('Permission')?></th>
		</tr>
	</thead>
	
	<tbody>		
		<?php $k=1; foreach ($controllers as $key => $value): ?>
			<?php if (!empty($value)): ?>
				<?php for ($i=0; $i < count($value); $i++): ?>
					<?php if (isset($value[$i])): ?>
						<tr>
                            <td>
                                <?=$this->Html->link(Router::url(array('plugin' => strtolower($value['plugin']), 'controller' => Inflector::underscore($key), 'action' => $value[$i]), true), 
                                    Router::url(array('plugin' => strtolower($value['plugin']), 'controller' => Inflector::underscore($key), 'action' => $value[$i]), true),
                                    array('target' => '_blank'))?></td>
							<td><?=$key?></td>
							<td><?=$value[$i]?></td>
							<td>
								<?php foreach ($user_groups as $user_group): ?>
									<?=$this->Form->create('UserGroupPermission', 
                                        array('class' => 'span1 pull-left', 'url' => array('plugin' => 'users', 'controller' => 'user_group_permissions', 'action' => 'update')))?>
                                        <?=$this->Form->input('user_group_id', array('type' => 'hidden', 'value' => $user_group['id']));?>
										<?=$this->Form->input('controller', array('type' => 'hidden', 'value' => $key));?>
										<?=$this->Form->input('action', array('type' => 'hidden', 'value' => $value[$i]));?>
										<?=$this->Form->input('allowed', array('label' => array('text' => __($user_group['name']), 'for' => $key.$value[$i].$user_group['name']), 'id' => $key.$value[$i].$user_group['name'], 'type' => 'checkbox', 'checked' => ( isset($value[$value[$i]][$user_group['alias_name']]) && $value[$value[$i]][$user_group['alias_name']] == 1? true : false )));?>
									<?=$this->Form->end()?>
								<?php endforeach ?>
							</td>
						</tr>
					<?php $k++; endif ?>
				<?php endfor?>
			<?php endif ?>
		<?php endforeach ?>
	</tbody>
</table>

<?php
$js = <<<EOF
	$(document).ready(function(){
		var permissions = new Permissions( $('#permissions') );
	});
EOF;

	echo $this->Html->scriptBlock($js, array('block' => 'customScript'));
?>