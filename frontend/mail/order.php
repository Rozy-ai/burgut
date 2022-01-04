<div class="table-responsive">
	<table class="table table-hover table-striped">
		<thead>
			<tr>
				<th>Surat</th>
				<th>Ady</th>
				<th>Sany</th>
				<th>Bahasy</th>
				<th>Jemi</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($session['cart'] as $id => $item): ?>
				<tr>
					<td><?= \yii\helpers\Html::img("@web/images/products/{$item['img']}", ['alt' => $item['name'], 'height' => 50])  ?></td>
					<td><?= $item['name'] ?></td>
					<td><?= $item['qty'] ?></td>
					<td><?= $item['price'] ?></td>
					<td><?= $item['qty'] * $item['price'] ?></td>
					</tr>
			 <?php endforeach ?>
			 <tr>
			 	<td colspan="3">Jemi: </td>
			 	<td><?= $session['cart.qty'] ?></td>
			 </tr>
			 <tr>
			 	<td colspan="3">Bahasy: </td>
			 	<td><?= $session['cart.sum'] ?></td>
			 </tr>
		</tbody>
	</table>
</div>

