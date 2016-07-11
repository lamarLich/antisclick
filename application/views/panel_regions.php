<style>
td {
	padding: 0 10px;
}
</style>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<table>
	<thead>
	<tr>
	<td>Сайт</td>
	<td>Регионы</td>
	<td></td></tr>
    </thead>
    <tbody>
    <?php foreach ($sites as $site):?>
    	<tr id='<?=$site['id'];?>'>
    		<td><?=$site['name'];?></td>
    		<td class="regions" id="<?=$site['id'];?>"></td>
    		<td><select id="<?=$site['id'];?>">
    			<option value="0">Выберите город...</option>
				<?php foreach ($cities as $city):?>
					<option value="<?=$city['id'];?>"><?=$city['name'];?></option>
				<?php endforeach;?>
    		</select></td>
    		<td><button class='but' id='<?=$site['id'];?>'>Добавить</button></td></td>    	
    	</tr>
    <?php endforeach;?>
    </tbody>
</table>
</div>