<?php

if(isset($_POST['add_to_cart'])){

   if($user_id == ''){
      header('location:user_login.php');
   }else{

      $pid = $_POST['pid'];
      $pid = filter_var($pid, FILTER_SANITIZE_STRING);
      $name = $_POST['name'];
      $name = filter_var($name, FILTER_SANITIZE_STRING);
      $price = $_POST['price'];
      $price = filter_var($price, FILTER_SANITIZE_STRING);
      $image = $_POST['image'];
      $image = filter_var($image, FILTER_SANITIZE_STRING);
      $qty = $_POST['qty'];
      $qty = filter_var($qty, FILTER_SANITIZE_STRING);

      $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
      $check_cart_numbers->execute([$name, $user_id]);

      $select_p = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
      $select_p->execute([$pid]);
      $fetch_p = $select_p->fetch(PDO::FETCH_ASSOC);

      if($fetch_p['stock'] == 0){
         //bawasan yung lowest batch ng quantity 
         if($check_cart_numbers->rowCount() > 0){
            $warning_msg[] = 'Already added to cart!';
         }else{
            
            $select_batch = $conn->prepare("SELECT batch_price FROM `batch` WHERE pid = ? AND batch_stock != 0 ORDER BY batch_num ASC LIMIT 1");
            $select_batch->execute([$pid]);
            $res = $select_batch->fetch(PDO::FETCH_ASSOC);
            $price =  implode($res);

            $select_num = $conn->prepare("SELECT batch_num FROM `batch` WHERE pid = ? AND batch_stock != 0 ORDER BY batch_num ASC LIMIT 1");
            $select_num->execute([$pid]);
            $bnum = $select_num->fetch(PDO::FETCH_ASSOC);
            $batch =  implode($bnum);

            $select_qty = $conn->prepare("SELECT batch_stock FROM `batch` WHERE batch_price = ? AND pid = ? ORDER BY batch_num ASC LIMIT 1");
            $select_qty->execute([$price,$pid]);
            $resq = $select_qty->fetch(PDO::FETCH_ASSOC);
            $prevqty =  implode($resq);

            $total_stock =  (int)$prevqty - (int)$qty;
   
            $update_stock = $conn->prepare("UPDATE `batch` SET batch_stock = ? WHERE pid = ? AND batch_stock != 0 ORDER BY batch_num ASC LIMIT 1");
            $update_stock->execute([$total_stock, $pid]);
   
            $insert_cart = $conn->prepare("INSERT INTO `cart`(user_id, pid, name, price, quantity, image, batch) VALUES(?,?,?,?,?,?,?)");
            $insert_cart->execute([$user_id, $pid, $name, $price, $qty, $image, $batch]);
            $success_msg[] = 'Successfully added to the cart!';
            
         }

      }else{

         if($check_cart_numbers->rowCount() > 0){
            $warning_msg[] = 'Already added to cart!';
         }else{
            
            $total_stock = ($fetch_p['stock'] - (int)$qty);
            $update_stock = $conn->prepare("UPDATE `products` SET stock = ? WHERE id = ?");
            $update_stock->execute([$total_stock, $pid]);
   
            $insert_cart = $conn->prepare("INSERT INTO `cart`(user_id, pid, name, price, quantity, image) VALUES(?,?,?,?,?,?)");
            $insert_cart->execute([$user_id, $pid, $name, $price, $qty, $image]);
            $success_msg[] = 'Successfully added to the cart!';
            
         }
      }

   }

}

?>
