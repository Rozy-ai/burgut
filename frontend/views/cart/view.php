<?php 

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
 ?>
 <div class="container">
 	<?php if(!empty($session['cart'])): ?>
<div class="table-responsive">
	<table class="table table-hover table-striped">
		<thead>
			<tr>
				<th>Surat</th>
				<th>Ady</th>
				<th>Sany</th>
				<th>Bahasy</th>
				<th>Jemi</th>
				<th><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($session['cart'] as $id => $item): ?>
				<tr>
					<td><?= \yii\helpers\Html::img($item['img'], ['alt' => $item['name'], 'height' => 50])  ?></td>
					<td><a href="<?= Url::to(['product/view','id'=>$id]) ?>"><?= $item['name'] ?></a></td>
					<td><?= $item['qty'] ?></td>
					<td><?= $item['price'] ?></td>
					<td><?= $item['qty'] * $item['price'] ?></td>
					<td><span data-id="<?= $id ?>" class="glyphicon glyphicon-remove text-danger del-item" aria-hidden="true"></span></td>
					</tr>
			 <?php endforeach ?>
			 <tr>
			 	<td colspan="5">Jemi: </td>
			 	<td><?= $session['cart.qty'] ?></td>
			 </tr>
			 <tr>
			 	<td colspan="5">Bahasy: </td>
			 	<td><?= $session['cart.sum'] ?></td>
			 </tr>
		</tbody>
	</table>
</div>
<hr>
<?php $form = ActiveForm::begin(); ?>
<?= $form->field($order, 'name') ?>
<?= $form->field($order, 'email') ?>
<?= $form->field($order, 'phone') ?>
<?= $form->field($order, 'address') ?>
<br>
<?= Html::submitButton('Sargamak',['class'=>'btn btn-success','style' => 'margin-bottom:10px; border-radius: 10px;'])  ?>
<br>
<?php ActiveForm::end(); ?>
<?php else: ?>
	<h3>Korzina bosh</h3>
<?php endif; ?>

 </div>