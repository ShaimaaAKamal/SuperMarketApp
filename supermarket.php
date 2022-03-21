<!doctype html>
<html lang="en">

<head>
  <title>Super Market</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<?php
function getProductsValue($price, $quantity)
{
  return $price * $quantity;
}
function withoutSubtotal($i,$entry)
{
  $entry .= "<tr><td><input type='text' name='name_" . $i . "' required></td>";
  $entry .= "<td><input type='text' name='price_" . $i . "' required></td>";
  $entry .= "<td><input type='number' name='quantity_" . $i . "' required></td></tr>";
  return $entry;
}
function withSubtotal($subtotal, $name, $price, $quan,$entry)
{
  $entry .= "<tr><td>" . $_POST[$name] . "</td>";
  $entry .= "<td>" . $_POST[$price] . "</td>";
  $entry .= "<td>" . $_POST[$quan] . "</td>";
  $entry .= "<td>" . $subtotal . "</td></tr>";
  return $entry;
}
// function checkerrors($name, $price, $quan){
//   $error=[];
//   if (isset($name) and empty($_POST[$name]))
//   $error['price'] = '<div class="alert alert-danger text-center"> Please enter the name of the product</div>';
//   if (isset($quan) and empty($quan))
//   $error['quantity'] = '<div class="alert alert-danger text-center"> Please enter the quantity</div>';
//   if (isset($price) and empty($price))
//   $error['productname'] = '<div class="alert alert-danger text-center"> Please enter the price product.</div>';
//   return $error;
// }
function displayTable($input)
{
  if (isset($input)) {
    $entry = '';
    $total=[];
    for ($i = 0; $i < $input; $i++) {
      if (!isset($_POST['total']))
        $entry= (withoutSubtotal($i,$entry));
      else {
          $subtotal = getProductsValue($_POST["price_$i"], $_POST["quantity_$i"]);
          array_push($total,$subtotal);
          $entry= (withSubtotal($subtotal, "name_$i", "price_$i", "quantity_$i",$entry)); 
      }
    }
    return [$entry,$total];
  }
}
function discount($total){
  if($total < 1000)
  return 0;
  elseif ($total >=1000 and $total <3000)
  return 0.1;
  elseif ($total >=3000 and $total <4500)
  return 0.15;
  else 
  return 0.2;
}
function AmountAfterDISCOUNT($total,$discount){
  return $total-$discount;
}
function cal_delivery($city){
  switch($city){
    case 'cairo':
    return '0';
    break;
    case 'giza':
    return '30';
    break;
    case 'alex':
    return '50';
    break;
    default:
    return '100';
    break;
  }
}
function printInvoice($name,$city,$totalAmount,$discountAmount,$afterDiscount,$delivery,$paidmoney){
  $invoice="";
  $invoice.= "<tr><td colspan='2 '>Username</td><td colspan='2'>".ucfirst($name)."</td></tr>";
  $invoice.= "<tr><td colspan='2'>City</td><td colspan='2'>".ucfirst($city)."</td></tr>";
  $invoice.= "<tr><td colspan='2'>Total</td><td colspan='2'>".$totalAmount."</td></tr>";
  $invoice.= "<tr><td colspan='2'>Discount</td><td colspan='2'>".$discountAmount."</td></tr>";
  $invoice.= "<tr><td colspan='2'>Amount after discount</td><td colspan='2'>".$afterDiscount."</td></tr>";
  $invoice.= "<tr><td colspan='2'>Delivery</td><td colspan='2'>".$delivery."</td></tr>";
  $invoice.= "<tr><td colspan='2'>Paid Money</td><td colspan='2'>".$paidmoney."</td></tr>";

  echo($invoice);
}


if ($_POST) {
  if (isset($_POST['name']) and empty($_POST['name']))
    $errors['name'] = '<div class="alert alert-danger text-center"> Please enter your name</div>';
  if (isset($_POST['city']) and empty($_POST['city']))
    $errors['city'] = '<div class="alert alert-danger text-center"> Please please select a city</div>';
  if (isset($_POST['products']) and empty($_POST['products']))
    $errors['products'] = '<div class="alert alert-danger text-center"> Please enter products number</div>';

}
?>

<body style='background:linear-gradient(#e66465, #9198e5) ;height:100vh;'>
  <div class='container mt-5'>
    <div class='row'>
      <h1 class='col-lg-12 text-center'>Super market</h1>
      <div class='col-lg-6 offset-lg-3'>
        <form method='POST'>
          <div class="form-group">
            <label for="input1">Username</label>
            <input type="text" class="form-control" id="input1" name='name' value='<?= isset($_POST['name']) ? $_POST["name"] : ""; ?>'>
          </div>
          <?= isset($errors['name']) ? $errors['name'] : ""; ?>
          <div class="form-group">
            <label for="Select1">Select city</label>
            <select class="form-control" id="Select1" name='city'>
              <option value='cairo' <?= (isset($_POST['city']) and $_POST['city'] == 'cairo') ? 'selected' : ""; ?>>Cairo</option>
              <option value='giza' <?= (isset($_POST['city']) and $_POST['city'] == 'giza')  ? 'selected' : ""; ?>>Giza</option>
              <option value='alex' <?= (isset($_POST['city']) and $_POST['city'] == 'alex')  ? 'selected' : ""; ?>>Alex</option>
              <option value='others' <?= (isset($_POST['city']) and $_POST['city'] == 'others') ? 'selected' : ""; ?>>Others</option>
            </select>
          </div>
          <?= isset($errors['city']) ? $errors['city'] : ""; ?>
          <div class="form-group">
            <label for="input1">Number of Products</label>
            <input type="number" class="form-control" id="input1" name='products' value='<?= isset($_POST['products']) ? $_POST["products"] : ""; ?>'>
          </div>
          <?= isset($errors['products']) ? $errors['products'] : ""; ?>
          <div class="form-group">
            <button type="submit" class="btn btn-danger form-control">Enter products</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- ***************************************************************************************** -->
  <div class='container mt-5'>
    <div class='row'>
      <div class='col-lg-6 offset-lg-3'>
        <form method="POST" style='display:<?= ($_POST and empty($errors)) ? "block" : "none" ?>'>
          <table class="table table-striped text-center">
            <thead>
              <tr>
                <th scope="col" class='text-center'>Product Name</th>
                <th scope="col" class='text-center'>Price</th>
                <th scope="col" class='text-center'>Quantities</th>
                <?= isset($_POST['total']) ? "<th scope='col' class='text-center'>Subtotal</th>" : ""; ?>
              </tr>
            </thead>
            <tbody>
              <?php
              echo (displayTable($_POST['products'])[0]);
              $totalAmount=array_sum(displayTable($_POST['products'])[1]);
              $discountAmount=$totalAmount*discount($totalAmount);
              $afterDiscount=AmountAfterDISCOUNT($totalAmount,$discountAmount);
              $delivery=cal_delivery($_POST['city']);
              $paidmoney=$afterDiscount+$delivery;
              if(isset($_POST['total'])){
                ( printInvoice($_POST['name'],$_POST['city'],$totalAmount,$discountAmount,$afterDiscount,$delivery,$paidmoney));
              }
              ?>
            </tbody>
          </table>
          <input type='hidden' name='name' value="<?= $_POST['name'] ?>">
          <input type='hidden' name='city' value="<?= $_POST['city'] ?>">
          <input type='hidden' name='products' value="<?= $_POST['products'] ?>">
          <input type='hidden' name='total' value="true">
          <div>
            <button type="submit" class="btn btn-danger form-control" style='display:<?= ($_POST and empty($_POST['total'])) ? "inline-block" : "none" ?>'>Invoice</button>
          </div>
        </form>
      </div>
    </div>
  </div>


  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>