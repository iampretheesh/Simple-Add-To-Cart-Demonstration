<?php

/* step 1 : https://phppot.com/php/simple-php-shopping-cart/ 

   step 2 : https://phppot.com/php/php-shopping-cart-with-paypal-payment-gateway-integration/

*/

session_start();
require_once("dbcontroller.php");
$db_handle = new DBController();

?>

<HTML>
<HEAD>
<TITLE>Simple PHP Shopping Cart</TITLE>


 <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://fonts.googleapis.com/css?family=Michroma&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Lato:300&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Roboto+Mono&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="css/jquery.ui.css" />


    <link rel="stylesheet" href="../line-awesome/css/line-awesome.css" />
  <link rel="stylesheet" href="../line-awesome/css/line-awesome.min.css" />

  <link href="https://fonts.googleapis.com/css?family=Abel|Geo|Oswald&display=swap" rel="stylesheet">

<link href="https://fonts.googleapis.com/css?family=Archivo+Narrow|BenchNine:300|IBM+Plex+Mono:300|Quattrocento+Sans|Wire+One&display=swap" rel="stylesheet">

<link href="https://fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet">

<link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;700&family=Oswald:wght@700&display=swap" rel="stylesheet">




    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-1.12.4.js"></script>
    <script src="js/jquery.ui.js"></script>


<script type="text/javascript">
	
let totQty=0;
						$(document).ready(function(){


										for(let i=1; i<=$('.allProducts').length;i++){


													$('#form_'+i).submit(function(){


																console.log('form_'+i);


																totQty = Number(totQty)+Number($('#qty_'+i).val());

																$('#b').html('CART['+totQty+']');


																let name  = $('#name_'+i).html();
																let qty   = $('#qty_'+i).val();
																let price = $('#price_'+i).html(); 

																price = price.replace('$','');


																let totalPrice  = Number(qty)*Number(price);

																let prodId   = $('#proId_'+i).val();

																let imgSrc = $('#image_'+i).attr('src');

																alert(imgSrc);


																let ajax = $.ajax({


																		data: {prodId: prodId, imgSrc: imgSrc,totalPrice: totalPrice, price: price, qty: qty, name: name},
																		method: 'POST',
																		dataType: 'json',
																		url: '404.php',
																		success: function(returned){

																						$('.in-my-cart').animate({width:'20%'},{duration: 500});
																						$('.in-my-cart').html(returned.rows);

																						$('.tQty').html(returned.tQty);
																						$('.tPrice').html(returned.tPrice);

																						$('.in-my-cart').animate({width:'100%'},{duration: 500});



																		}




																});
													});

										}


						});		



function removeProduct(prodId){


					$.ajax({


								data: {prodId: prodId},
								url: 'remove.php',
								method: 'POST',
								dataType: 'json',
								success: function(res){



															$('.in-my-cart').animate({width:'20%'},{duration: 500});
															$('.in-my-cart').html(res.rows);

															$('.tQty').html(res.tQty);
															$('.tPrice').html(res.tPrice);

															$('.in-my-cart').animate({width:'100%'},{duration: 500});



								},
																		error: function( jqXHR, textStatus, errorThrown,) {


																				console.log('error:'+textStatus+errorThrown);


																		}




					});


}

</script>


</HEAD>
<BODY>
<div id="shopping-cart">

			Shopping Cart


</div>



<div id="myCart">
	

				<div id="line1">
					

									<div class="line1">My Cart Status</div>
									<div class="line1">Empty</div>


				</div>

				<div class="in-my-cart" id="line2">



						<div id="row" class="line2">
							
								<div class="row" id="less">SL.NO</div>
								<div class="row" id="less">IMAGE</div>
								<div class="row" id="more">NAME</div>
								<div class="row" id="less">CODE</div>
								<div class="row" id="less">QUANTITY</div>
								<div class="row" id="less">PRICE</div>
								<div class="row" id="more">TOTAL PRICE</div>
								<div class="row" id="less">REMOVE</div>



						</div>


<?php 
$count=1;
$totalQuantity = 0;
$totalPrice = 0;
if(isset($_SESSION['cart'])){


								foreach ($_SESSION['cart'] as $key => $value) {


								?>					

														<div id="row" class="line2">
															
																<div class="row" id="less"><?php echo $count;?></div>
																<div class="row" id="less"><?php echo $_SESSION['cart'][$key]['imgSrc'];?></div>
																<div class="row" id="more"><?php echo $_SESSION['cart'][$key]['name'];?></div>
																<div class="row" id="less"><?php echo 'CODE';?></div>
																<div class="row" id="less"><?php echo $_SESSION['cart'][$key]['qty'];?></div>
																<div class="row" id="less"><?php echo $_SESSION['cart'][$key]['price'];?></div>
																<div class="row" id="more"><?php echo $_SESSION['cart'][$key]['totalPrice'];?></div>
																<div onclick="removeProduct(<?php echo $_SESSION['cart'][$key]['prodId']; ?>)" class="row red" id="less">x</div>



														</div>
								<?php
								$count++;
								$totalQuantity+=$_SESSION['cart'][$key]['qty'];
								$totalPrice+=$_SESSION['cart'][$key]['totalPrice'];
								}

}

?>




				</div>


				<div id="line3">
					

									<div class="line3">


													<div id="text">TOT.QUANTITY</div><div class="tQty" id="value"><?php echo $totalQuantity; ?></div>

									</div>


									<div class="line3">


													<div id="text">TOT.PRICE</div><div class="tPrice" id="value"><?php echo $totalPrice; ?></div>

									</div>

				</div>				





</div>




<!-- basic display of products -->
	<?php
	$product_array = $db_handle->runQuery("SELECT * FROM tblproduct ORDER BY id ASC");
	if (!empty($product_array)) { 
		$count=1;
		foreach($product_array as $key=>$value){

			if($count == 1) { $gap=''; } else { $gap = "gap"; }
	?>

			<form onsubmit="return false;" id="form_<?php echo $count; ?>" class="allProducts <?php echo $gap; ?>" method="post" action="index.php?action=add&code=<?php echo $product_array[$key]["code"]; ?>">

			
			<div id="name_<?php echo $count; ?>" class="a product-title"><?php echo $product_array[$key]["name"]; ?></div>


			<div id="price_<?php echo $count; ?>" class="b product-price"><?php echo "$".$product_array[$key]["price"]; ?></div>

			<div id="images_<?php echo $count; ?>" class="c product-image"><img id="image_<?php echo $count; ?>" width="50%" height="95%" src="<?php echo "product-images/".$product_array[$key]["image"]; ?>"></div>

			<input id="qty_<?php echo $count; ?>" type="text" class="d product-quantity" name="quantity" value="1" size="2" />

			<input id="save_<?php echo $count; ?>" type="submit" value="Add to Cart" class="e btnAddAction" />


			<input type="hidden" id="proId_<?php echo $count; ?>" value="<?php echo $product_array[$key]['id']; ?>" />


			</form>
	<?php

		$count++;
		}
	}
	?>
</BODY>
</HTML>


