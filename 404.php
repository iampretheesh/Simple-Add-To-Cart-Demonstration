<?php
session_start();


$post_array = $_POST;

$prodId = $post_array['prodId'];
$prodName = $post_array['name'];
$proQty = $post_array['qty']; 
$proPrice = $post_array['price'];
$proTotPrice = $post_array['totalPrice'];
$proImgSrc = $post_array['imgSrc'];

$cart_Array = array( $post_array['prodId'] => $post_array );


$update=0;






if(isset($_SESSION['cart'])){



								foreach($_SESSION['cart'] as $key => $val){



																	if($post_array['prodId']==$key){


																						$update=1;
																						break;
																	}



								}




								if($update == 1){







												$_SESSION['cart'][$prodId]['qty'] = $_SESSION['cart'][$prodId]['qty'] + $proQty;
												$_SESSION['cart'][$prodId]['totalPrice'] = $_SESSION['cart'][$prodId]['qty']*$_SESSION['cart'][$prodId]['price'];


								}

								else {

												$_SESSION['cart']=$_SESSION['cart']+$cart_Array;


								}
}


else{

$_SESSION['cart'] = $cart_Array;

}




$count=1;
$totalQuantity = 0;
$totalPrice = 0;
$mycart='<div id="row" class="line2">
							
								<div class="row" id="less">SL.NO</div>
								<div class="row" id="less">IMAGE</div>
								<div class="row" id="more">NAME</div>
								<div class="row" id="less">CODE</div>
								<div class="row" id="less">QUANTITY</div>
								<div class="row" id="less">PRICE</div>
								<div class="row" id="more">TOTAL PRICE</div>
								<div class="row" id="less">REMOVE</div>



		</div>';

foreach ($_SESSION['cart'] as $key => $value) {


				

		$mycart.=		'<div id="row" class="line2">
							
								<div class="row" id="less">'.$count.'</div>
								<div class="row" id="less">'.$_SESSION['cart'][$key]['imgSrc'].'</div>
								<div class="row" id="more">'.$_SESSION['cart'][$key]['name'].'</div>
								<div class="row" id="less">CODE</div>
								<div class="row" id="less">'.$_SESSION['cart'][$key]['qty'].'</div>
								<div class="row" id="less">'.$_SESSION['cart'][$key]['price'].'</div>
								<div class="row" id="more">'.$_SESSION['cart'][$key]['totalPrice'].'</div>
								<div onclick="removeProduct('.$_SESSION['cart'][$key]['prodId'].')" class="row red" id="less">x</div>



						</div>';

$count++;
$totalQuantity+=$_SESSION['cart'][$key]['qty'];
$totalPrice+=$_SESSION['cart'][$key]['totalPrice'];
}




$return_array = array("rows"=>$mycart, "tQty"=>$totalQuantity, "tPrice"=>$totalPrice);

echo json_encode($return_array);

?>