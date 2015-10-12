<?php foreach ($this->rows as $row):?>
<tr class="order_item" data_id=<?php echo $row->order_id?>>   
  <td><?php echo $row->order_id?></td>
  <td><?php echo $row->order_nums?></td>
  <td><?php echo date('Y-m-d H:i',$row->create_time)?></td>
  <td><?php echo $row->user_name?></td>
  <td><?php echo $row->user_mobile?></td>
  <td><?php echo $row->order_amount?></td>
  <td><?php echo $row->pay_status == 1 ? '是': '否'?></td>
  <td style="width:150px"><?php echo $row->address_area.$row->address_street?></td>
  <td><?php echo $row->hurry_status ? '是' : '否'?></td>
  <td><?php echo $row->total_amount?></td>
  <td><?php echo $row->get_status()?></td>
</tr>
<?php endforeach;?>