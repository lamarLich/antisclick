<style>
td {
	padding: 0 10px;
}
</style>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<h3>Выберите сайты:</h3>
    <?php foreach ($all_sites as $site):?>
    	<input type="checkbox" name='site-<?=$site['id'];?>'>  <?=$site['name'];?><br>
    <?php endforeach;?>
	<h3>Таблица плохих адресов</h3>
    <table>
    <?php foreach($bad_IP as $ip):?> 
		<tr>
			<td><?=$ip['IP'];?></td>
		</tr>
	<?php endforeach;?>	
    </table>
    <h3>Таблица всех адресов</h3>
    <table>
    <?php foreach($all_IP as $ip):?> 
		<tr>
			<td><?=$ip['IP'];?></td>
		</tr>
	<?php endforeach;?>	
    </table>
    
    

    <h3>Таблица всех кликов</h3>
    <table>
    <?php foreach($all_clicks as $item):?> 
		<tr class='site site-<?=$item['id_Site'];?>'>
			<td><?=$item['id'];?>			</td> 
			<td><?=$item['name'];?>			</td>
			<td><?=$item['IP'];?>			</td>
			<td><?=$item['points'];?>		</td>  
			<td><?=$item['width_screen'];?>	</td> 
			<td><?=$item['height_screen'];?></td> 
			<td><?=$item['city'];?>			</td> 
			<td><?=$item['region'];?>		</td> 
			<td><?=$item['country'];?>		</td> 
			<td><?=$item['platform'];?>		</td> 
			<td><?=$item['time_in'];?>		</td>
			<td><?=$item['time_out'];?>		</td>
		</tr>
	<?php endforeach;?>	
    </table>
    <h3>Таблица всех плохих кликов</h3>
    <table>
    <?php foreach($clicks_bad_ip as $item):?> 
		<tr class='site site-<?=$item['id_Site'];?>'>
			<td><?=$item['id'];?>			</td> 
			<td><?=$item['name'];?>			</td>
			<td><?=$item['IP'];?>			</td> 
			<td><?=$item['points'];?>		</td>  
			<td><?=$item['width_screen'];?>	</td> 
			<td><?=$item['height_screen'];?></td> 
			<td><?=$item['city'];?>			</td> 
			<td><?=$item['region'];?>		</td> 
			<td><?=$item['country'];?>		</td> 
			<td><?=$item['platform'];?>		</td> 
			<td><?=$item['time_in'];?>		</td>
			<td><?=$item['time_out'];?>		</td>
		</tr>
	<?php endforeach;?>	
    </table>
    <h3>Таблица всех подозрительных кликов</h3>
    <table>
    <?php foreach($clicks_strange_ip as $item):?> 
		<tr class='site site-<?=$item['id_Site'];?>'>
			<td><?=$item['id'];?>			</td> 
			<td><?=$item['IP'];?>			</td> 
			<td><?=$item['points'];?>		</td>  
			<td><?=$item['width_screen'];?>	</td> 
			<td><?=$item['height_screen'];?></td> 
			<td><?=$item['city'];?>			</td> 
			<td><?=$item['region'];?>		</td> 
			<td><?=$item['country'];?>		</td> 
			<td><?=$item['platform'];?>		</td> 
			<td><?=$item['time_in'];?>		</td>
			<td><?=$item['time_out'];?>		</td>
		</tr>
	<?php endforeach;?>	
    </table>
</div>