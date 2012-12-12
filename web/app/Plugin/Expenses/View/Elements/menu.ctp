<ul class="nav nav-tabs nav-stacked first level">
    <li class="categories">
        <?=$this->Html->link('<i class="icon-reorder"></i> ' . __('Categories') . ' <i class="icon-sort-down pull-right"></i>', array('plugin' => 'expenses', 'controller' => 'categories', 'action' => 'payments' ), array('escape' => false, 'title' => __('Categories')))?>

        <ul class="second level <?=sizeof( array_intersect_assoc(array('plugin' => 'expenses', 'controller' => 'categories'), $this->request->params) ) == 2? '' : 'hide'?>">
            <li>
                <?php echo $this->Html->link(__('Payments'), array('plugin' => 'expenses', 'controller' => 'categories', 'action' => 'payments'), array('escape' => false));?>
            </li>
            <li>
                <?php echo $this->Html->link(__('Receivables'), array('plugin' => 'expenses', 'controller' => 'categories', 'action' => 'receivables'), array('escape' => false));?>
            </li>
        </ul>
    </li>
    
    <li class="payments">
        <?=$this->Html->link('<i class="icon-money"></i> ' . __('Payments') . ' <i class="icon-sort-down pull-right"></i>', array('plugin' => 'expenses', 'controller' => 'payments', 'action' => 'index' ), array('escape' => false, 'title' => __('Payments')))?>
        
        <?php if (sizeof($payment_categories) > 0 ):?>
        <ul class="second level <?=sizeof( array_intersect_assoc(array('plugin' => 'expenses', 'controller' => 'payments'), $this->request->params) ) == 2? '' : 'hide'?>">
            <?php foreach($payment_categories as $category):?>
            <li>
                <?=$this->Html->link($category['Category']['name'] . ' <i class="icon-sort-down pull-right"></i>', array('plugin' => 'expenses', 'controller' => 'payments', 'action' => 'category', $category['Category']['id'] ), array('escape' => false, 'title' => $category['Category']['name']));?>
                
                <?php if ($category['ChildCategory']) echo '<ul class="third level '.(sizeof( array_intersect_assoc(array('plugin' => 'expenses', 'controller' => 'payments', 'action' => 'category'), $this->request->params) ) == 3 && (isset($this->request->params['pass'][0]) && $this->request->params['pass'][0] == $category['Category']['id'] )? '' : 'hide').'">';?>
                <?php foreach ($category['ChildCategory'] as $child):?>
                    <?='<li>'.$this->Html->link($child['name'], array('plugin' => 'expenses', 'controller' => 'payments', 'action' => 'subcategory', $child['id'] ), array('escape' => false, 'title' => $child['name'])).'</li>';?>    
                <?php endforeach?>
                <?php if ($category['ChildCategory']) echo '</ul>';?>
            </li>
            <?php endforeach?>
        </ul>
        <?php endif?>
    </li>
    
    <li class="receivables">
        <?=$this->Html->link('<i class="icon-signin"></i> ' . __('Receivables') . ' <i class="icon-sort-down pull-right"></i>', array('plugin' => 'expenses', 'controller' => 'receivables', 'action' => 'index' ), array('escape' => false, 'title' => __('Receivables')))?>
    
        <?php if (sizeof($receivable_categories) > 0 ):?>
        <ul class="second level <?=sizeof( array_intersect_assoc(array('plugin' => 'expenses', 'controller' => 'receivables'), $this->request->params) ) == 2? '' : 'hide'?>">
            <?php foreach($receivable_categories as $category):?>
            <li>
                <?php echo $this->Html->link($category['Category']['name'] . ' <i class="icon-sort-down pull-right"></i>', array('plugin' => 'expenses', 'controller' => 'receivables', 'action' => 'category', $category['Category']['id'] ), array('escape' => false, 'title' => $category['Category']['name']));?>
                
                <?php if ($category['ChildCategory']) echo '<ul class="third level hide">';?>
                <?php foreach ($category['ChildCategory'] as $child):?>
                    <li><?=$this->Html->link($child['name'], array('plugin' => 'expenses', 'controller' => 'receivables', 'action' => 'subcategory', $child['id'] ), array('escape' => false, 'title' => $child['name']));?></li>  
                <?php endforeach?>
                <?php if ($category['ChildCategory']) echo '</ul>';?>
            </li>
            <?php endforeach?>
        </ul>
        <?php endif?>
    </li>
    
    <li class="first level">
        <?=$this->Html->link('<i class="icon-bar-chart"></i> ' . __('Chart'), array('plugin' => 'high_charts', 'controller' => 'charts', 'action' => 'chart' ), array('escape' => false));?>
    </li>
</ul>

<div class="alert alert-info">
    <div class="row-fluid">
        <div class="span6"><i class="icon-signout"></i> <?=__('Payments')?></div>
        <div class="span6"><?=$statistics['payments']?></div>
    </div>
    <div class="row-fluid">
        <div class="span6"><i class="icon-signin"></i> <?=__('Receivables')?></div>
        <div class="span6"><?=$statistics['receivables']?></div>
    </div>
    <hr/>
    
    <div class="row-fluid">
        <div class="span6"><i class="icon-money"></i> <?=__('Cash')?></div>
        <div class="span6"><?=$statistics['cash']?></div>
    </div>
</div>