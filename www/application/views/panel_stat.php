<style>
td {
	padding: 0 10px;
}
</style>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<a href="./regions">Выставить регионы</a>
	<h3>Выберите сайты:</h3>
    <?php foreach ($all_sites as $site):?>
    	<input type="checkbox" name='site-<?=$site['id'];?>'>  <?=$site['name'];?><br>
    <?php endforeach;?>
	<h3>Таблица плохих адресов</h3>
    <table class="simple-little-table" cellspacing='0'>
    <?php foreach($clicks_bad_ip as $item):?>
		<?php 
			$arr[$item['id_Site']][] = $item['IP'];
		?> 	
	<?php endforeach;?>	
	<?php foreach($arr as $key =>$item):?>
		<?php 
		$item=array_unique($item);
			foreach($item as $value)
			{
				echo "<tr class='site site-$key'> <td>";
				echo "<div class='spoiler'><div class='spoiler-btn'>$value</div>";
				echo "<div class='spoiler-body collapse'></div></div>";
				echo "</td></tr>";
			}
		?> 	
	<?php endforeach;?>	
    </table>
    <h3>Таблица всех адресов</h3>
    <table class="simple-little-table" cellspacing='0'>
	<?php foreach($all_clicks as $item):?>
		<?php 
			$arra[$item['id_Site']][] = $item['IP'];
		?> 	
	<?php endforeach;?>	
	<?php foreach($arra as $key =>$item):?>
		<?php 
		$item=array_unique($item);
			foreach($item as $value)
			{
				echo "<tr class='site site-$key'>";
				echo "<td>$value</td>";
				echo "</tr>";
			}
		?> 	
	<?php endforeach;?>	
    </table>
    
    
<a href="http://landofbrand.ru/styles/alg.jpg">Схема алгоритма подсчета поинтов с пояснением и нумерацией</a>
    <h3>Таблица всех кликов</h3>
    <table class="simple-little-table" cellspacing='0'>
		<tr>
    		<th><b>id		</b></th> 
			<th><b>Домен	</b></th>
			<th><b>IP		</b></th>
			<th><b>points	</b></th>  
			<!--<th><b>Начисление поинтов</b></th>-->
			<th><b>Всего	</b></th>
			<th><b>Вход		</b></th>
			<th><b>Выход	</b></th>
			<th><b>Город	</b></th> 
			<th><b>Регион	</b></th> 
			<th><b>Страна	</b></th> 
			<th><b>Ширина	</b></th> 
			<th><b>Высота	</b></th> 
			<th><b>Платформа</b></th> 
			<th><b>userAgent</b></th>
    	</tr>
    <?php foreach($all_clicks as $item):?> 
		<tr class='site site-<?=$item['id_Site'];?>'>
			<td><?=$item['id_Click'];?>		</td> 
			<td><?=$item['name'];?>			</td>
			<td><?=$item['IP'];?>			</td>
			<td><?=$item['points'];?>		</td>  
			<!--<td><?=$item['history'];?>		</td>-->
			<td><?=$item['time_all'];?>		</td>
			<td><?=$item['time_in'];?>		</td>
			<td><?=$item['time_out'];?>		</td>
			<td><?=$item['city'];?>			</td> 
			<td><?=$item['region'];?>		</td> 
			<td><?=$item['country'];?>		</td> 
			<td><?=$item['width_screen'];?>	</td> 
			<td><?=$item['height_screen'];?></td> 
			<td><?=$item['platform'];?>		</td> 
			<td><?=$item['userAgent'];?>	</td>
		</tr>
	<?php endforeach;?>	
    </table>
    <h3>Таблица всех плохих кликов</h3>
    <table class="simple-little-table" cellspacing='0'>
	<tr>
    		<th><b>id		</b></th> 
			<th><b>Домен	</b></th>
			<th><b>IP		</b></th>
			<th><b>points	</b></th>  
			<!--<th><b>Начисление поинтов</b></th>-->
			<th><b>Всего	</b></th>
			<th><b>Вход		</b></th>
			<th><b>Выход	</b></th>
			<th><b>Город	</b></th> 
			<th><b>Регион	</b></th> 
			<th><b>Страна	</b></th> 
			<th><b>Ширина	</b></th> 
			<th><b>Высота	</b></th> 
			<th><b>Платформа</b></th> 
			<th><b>userAgent</b></th>
    	</tr>
    <?php foreach($clicks_bad_ip as $item):?> 
		<tr class='site site-<?=$item['id_Site'];?>'>
			<td><?=$item['id_Click'];?>		</td> 
			<td><?=$item['name'];?>			</td>
			<td><?=$item['IP'];?>			</td>
			<td><?=$item['points'];?>		</td>  
			<!--<td><?=$item['history'];?>		</td>-->
			<td><?=$item['time_all'];?>		</td>
			<td><?=$item['time_in'];?>		</td>
			<td><?=$item['time_out'];?>		</td>
			<td><?=$item['city'];?>			</td> 
			<td><?=$item['region'];?>		</td> 
			<td><?=$item['country'];?>		</td> 
			<td><?=$item['width_screen'];?>	</td> 
			<td><?=$item['height_screen'];?></td> 
			<td><?=$item['platform'];?>		</td> 
			<td><?=$item['userAgent'];?>	</td>
		</tr>
	<?php endforeach;?>	
    </table>
    <h3>Таблица всех подозрительных кликов</h3>
    <table class="simple-little-table" cellspacing='0'>
	<tr>
    		<th><b>id		</b></th> 
			<th><b>Домен	</b></th>
			<th><b>IP		</b></th>
			<th><b>points	</b></th>  
			<th><b>Начисление поинтов</b></th>
			<th><b>Всего	</b></th>
			<th><b>Вход		</b></th>
			<th><b>Выход	</b></th>
			<th><b>Город	</b></th> 
			<th><b>Регион	</b></th> 
			<th><b>Страна	</b></th> 
			<th><b>Ширина	</b></th> 
			<th><b>Высота	</b></th> 
			<th><b>Платформа</b></th> 
			<th><b>userAgent</b></th>
    	</tr>
    <?php foreach($clicks_strange_ip as $item):?> 
		<tr class='site site-<?=$item['id_Site'];?>'>
			<td><?=$item['id_Click'];?>		</td> 
			<td><?=$item['name'];?>			</td>
			<td><?=$item['IP'];?>			</td>
			<td><?=$item['points'];?>		</td>  
			<td><?=$item['history'];?>		</td>
			<td><?=$item['time_all'];?>		</td>
			<td><?=$item['time_in'];?>		</td>
			<td><?=$item['time_out'];?>		</td>
			<td><?=$item['city'];?>			</td> 
			<td><?=$item['region'];?>		</td> 
			<td><?=$item['country'];?>		</td> 
			<td><?=$item['width_screen'];?>	</td> 
			<td><?=$item['height_screen'];?></td> 
			<td><?=$item['platform'];?>		</td> 
			<td><?=$item['userAgent'];?>	</td>
		</tr>
	<?php endforeach;?>	
    </table>
</div>