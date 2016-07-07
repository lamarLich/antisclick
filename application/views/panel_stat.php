<style>
td {
	padding: 0 10px;
}
</style>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<h1>Таблица плохих адресов</h1>
    <table>
    <?php foreach($bad_IP as $ip):?> 
		<tr>
			<td><?=$ip['IP'];?></td>
		</tr>
	<?php endforeach;?>	
    </table>
    <h1>Таблица всех адресов</h1>
    <table>
    <?php foreach($all_IP as $ip):?> 
		<tr>
			<td><?=$ip['IP'];?></td>
		</tr>
	<?php endforeach;?>	
    </table>
    <h1>Таблица всех кликов</h1>
    <table>
    <?php foreach($all_clicks as $item):?> 
		<tr>
			<td><?=$item['id'];?>			</td> 
			<td><?=$item['name'];?>			</td>
			<td><?=$item['userAgent'];?>	</td> 
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
    <h1>Таблица всех плохих кликов</h1>
    <table>
    <?php foreach($clicks_bad_ip as $item):?> 
		<tr>
			<td><?=$item['id'];?>			</td> 
			<td><?=$item['name'];?>			</td>
			<td><?=$item['userAgent'];?>	</td> 
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
    <h1>Таблица всех подозрительных кликов</h1>
    <table>
    <?php foreach($clicks_strange_ip as $item):?> 
		<tr>
			<td><?=$item['id'];?>			</td> 
			<td><?=$item['userAgent'];?>	</td> 
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