<?php
try {
// 	require('connection.php');

// 	//for rating = 5
// 	$rt5="SELECT * FROM Reviews WHERE Rating=5 AND ProductID=$id";
// 	$rat5=$db->query($rt5);
// 	$c5=0;
// 	foreach($rat5 as $r5){
// 		$c5++;
// 	}
// 	if($c5==0)
// 	$prog5=0;
// 	else
// 	$prog5=$c5/$count;
	
// 	$prog5=$prog5*100;
// } catch (PDOException $ex) {
// 	echo $ex->getMessage();
// 	exit;
// }
?>
		
			
			
	<ul class="rating">
		<li>
			<div class="rating-stars">
				<i class="fa fa-star"></i>
				<i class="fa fa-star"></i>
				<i class="fa fa-star"></i>
				<i class="fa fa-star"></i>
				<i class="fa fa-star"></i>
			</div>
			<div class="rating-progress">
				<div style="width: <?php echo $prog5; ?>%;"></div>
			</div>
			<span class="sum"><?php echo $c5; ?></span>
		</li>
		
	
		<?php
		
		//for rating = 4
		// $rt4='SELECT * FROM Reviews WHERE Rating=4 AND ProductID='.$id;
		// $rat4=$db->query($rt4);
		// $c4=0;
		// foreach($rat4 as $r4){
		// 	$c4++;
		// }
		// if($c4==0)
		// 	$prog4=0;
		// else
		// 	$prog4=$c4/$count;
			
		// $prog4=$prog4*100;
		?>
		
			
			
		<li>
			<div class="rating-stars">
				<i class="fa fa-star"></i>
				<i class="fa fa-star"></i>
				<i class="fa fa-star"></i>
				<i class="fa fa-star"></i>
				<i class="fa fa-star-o"></i>
			</div>
			<div class="rating-progress">
				<div style="width: <?php echo $prog4; ?>%;"></div>
			</div>
			<span class="sum"><?php echo $c4; ?></span>
		</li>
		
	
		<?php
		
		//for rating = 3
		// $rt3='SELECT * FROM Reviews WHERE Rating=3 AND ProductID='.$id;
		// $rat3=$db->query($rt3);
		// $c3=0;
		// foreach($rat3 as $r3){
		// 	$c3++;
		// }
		// if($c3==0)
		// 	$prog3=0;
		// else
		// 	$prog3=$c3/$count;
			
		// $prog3=$prog3*100;
		?>
		
			
			
		<li>
			<div class="rating-stars">
				<i class="fa fa-star"></i>
				<i class="fa fa-star"></i>
				<i class="fa fa-star"></i>
				<i class="fa fa-star-o"></i>
				<i class="fa fa-star-o"></i>
			</div>
			<div class="rating-progress">
				<div style="width: <?php echo $prog3; ?>%;"></div>
			</div>
			<span class="sum"><?php echo $c3; ?></span>
		</li>
		
	
		<?php
		
		//for rating = 2
		// $rt2='SELECT * FROM Reviews WHERE Rating=2 AND ProductID='.$id;
		// $rat2=$db->query($rt2);
		// $c2=0;
		// foreach($rat2 as $r2){
		// 	$c2++;
		// }
		
		// if($c2==0)
		// 	$prog2=0;
		// else
		// 	$prog2=$c2/$count;
			
		// $prog2=$prog2*100;
		?>
		
			
			
		<li>
			<div class="rating-stars">
				<i class="fa fa-star"></i>
				<i class="fa fa-star"></i>
				<i class="fa fa-star-o"></i>
				<i class="fa fa-star-o"></i>
				<i class="fa fa-star-o"></i>
			</div>
			<div class="rating-progress">
				<div style="width: <?php echo $prog2; ?>%;"></div>
			</div>
			<span class="sum"><?php echo $c2; ?></span>
		</li>
		
		
	
		<?php
		
		// //for rating = 1
		// $rt1='SELECT * FROM Reviews WHERE Rating=1 AND ProductID='.$id;
		// $rat1=$db->query($rt1);
		// $c1=0;
		// foreach($rat1 as $r1){
		// 	$c1++;
		// }
		// if($c1==0)
		// 	$prog1=0;
		// else
		// 	$prog1=$c1/$count;
			
		// $prog1=$prog1*100;
		?>
		
			
			
		<li>
			<div class="rating-stars">
				<i class="fa fa-star"></i>
				<i class="fa fa-star-o"></i>
				<i class="fa fa-star-o"></i>
				<i class="fa fa-star-o"></i>
				<i class="fa fa-star-o"></i>
			</div>
			<div class="rating-progress">
				<div style="width: <?php echo $prog1; ?>%;"></div>
			</div>
			<span class="sum"><?php echo $c1; ?></span>
		</li>
	</ul>
<!-- </div> -->
<!-- </div> -->
<!-- /Rating -->
