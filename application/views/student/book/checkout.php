<?php 
//Load model 
$CI = &get_instance();
$CI->load->model('actions/cart');
$cart = $CI->cart;

$id = $_SESSION['hostel_no'];
$hostel_name = $_SESSION['hostel_name'];
$type = $_SESSION['type'];
$_SESSION['room'] = $_GET['room'];

// redirect to home if cart is empty
if($cart->total_items() < 1){
    redirect('student/book?id='.$id.'&hostel_name='.$hostel_name.'&type='.$type);
}
?>

<div class="container checkout_container">
<br>
<br>
<h1 class="checkout_h">Hostel Booking Preview</h1>
    <form name="frmconfirm" action="payment_confirm.php" method="post">
    <table class="table">
    <thead>
        <tr>
            <th>Hostel</th>
            <th>No sharing</th>
            <th>Room No</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if($cart->total_items() > 0){
            //get cart items from session
            $cartItems = $cart->contents();
            foreach($cartItems as $item){
        ?>
        <tr>
            <td><?php echo $item["hostel_name"]; ?></td>
            <td><?php echo $item["no_sharing"]; ?></td>
            <td><?php echo $_GET['room']; ?></td>
            <td><?php echo 'Ksh'.$item["price"]; ?></td>
            <td><?php echo $item["qty"]; ?></td>
            <td><?php echo 'Ksh'.$item["subtotal"]; ?></td>
        </tr>
        <?php } }else{ ?>
        <tr>
            <td colspan="4"><p>No items in your cart</p></td>
        </tr>
        <?php } ?>
    </tbody>
<!--    <tfoot>
        <tr>
            <td colspan="3"></td>
            <?php if($cart->total_items() > 0){ ?>
            <td class="text-center"><strong>Grand Total</strong></td>
            <td><strong><?php echo 'Ksh'.$cart->total();?></strong></td>
            <?php } ?>
        </tr>
    </tfoot>-->
    </table>			        
    </form>
    <div class="footBtn">
        <?php echo '<a href="'.base_url('student/view_cart').'" class="btn btn-info">'
                        . '<i class="fa fa-arrow-alt-circle-left"></i> Edit cart'
                . '</a>';
        ?>
        <!--Modal content removed-->
        
    <a href="<?= base_url('student/place_order');?>" class="btn btn-success orderBtn">Confirm Booking
         <i class="fa fa-arrow-alt-circle-right"></i>
    </a>    
    </div>
</div>
</body>
</html>