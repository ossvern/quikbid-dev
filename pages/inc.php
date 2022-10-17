<div class="py-5 text-center">
    <img class="o-logo" src="<?= $url ?>/img/logo.png" alt="">
    <h2>Order your professionally performed takeoff today.</h2>
    <p class="lead">Contact Us with any questions. Quality backed by a “money
        back” guarantee.</p>
</div>


<?php
$arr = [
  'uCompany' => 'Company Name',
  'uMail' => 'Email',
  'uProjectId' => 'Project ID Number',
  'uTtype' => 'Takeoff Type',
  'uCardName' => 'Name on Card',
  'uCardNumber' => 'Card Number',
  'uCardExp' => 'Expiration Date',
  'uSecCode' => 'Security Code',
  'uZip' => 'ZIP / Postal Code',

]
?>

<div class="container page-register">
    <div class="row">
      <?
      $i = 0;
      foreach ($arr as $key => $value) {
        $i++;

        if ($i == 1) {
          $ret .= '<div class="col-12 col-md-6"><div class="b-header">USER DETAILS</div>';
        }
        if ($i == 5) {
          $ret .= '</div><div class="col-12 col-md-6"><div class="b-header">CREDIT CARD <div><i class="icon icon-ae"></i><i class="icon icon-di"></i><i class="icon icon-mc"></i><i class="icon icon-visa"></i></div></div>';
        }

        $ret .= "<input name='{$key}' id='{$key}' placeholder='{$value}' class='form-control mb-4 rounded-pill o-$key'>";

        if ($i == 9) {
          $ret .= "</div>";
        }
      }
      echo $ret;
      ?>
    </div>
    <div class="row mt-5">
        <div class="col-12 text-center">
            <button type="submit" class="btn rounded-pill">PURCHASE
                ($125)
            </button>

            <p class="mt-4 align-center">
                By making this purchase, you agree to the associated <a
                        href="#">terms and conditions</a>.
            </p>

        </div>

    </div>
</div>