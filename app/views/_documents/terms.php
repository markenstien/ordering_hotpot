<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div style="width: 500px; padding:10px; margin:0px auto;">
        <img src="<?php echo _path_upload_get('hotpotlogo.png');?>" alt="<?php echo COMPANY_NAME?> Logo"
        style="width:300px; margin:0px auto; display:block">

        <h1>[<?php echo COMPANY_NAME?>] Terms of Service</h1>
        <h4>Introduction</h4>
        <?php
            $introductions = [
                'Purpose' => [
                    'Welcome to '. COMPANY_NAME.' ! Our mission is to delivery delicious and affordable meals and topping the standards customer experience. Your use of our platform constitutes acceptance of these terms.'
                ],
                'Acceptance' => [
                    'By using our services, you acknowledge and agree to abide by the terms outlined herein.
                User Rights and Responsibilities'
                ],
                'User Conduct:' => [
                    'Users must engage in respectful and lawful behavior on our platform. Any violation may result in consequences outlined in Section 7.'
                ],
                'Account Responsibility' => [
                    'Users are responsible for maintaining the security of their accounts and ensuring responsible use.
                S   ervice Description'
                ],
                'Overview' => [
                    'At '.COMPANY_NAME.', we provide restaurant services. Our commitment is to deliver quality meal and customer experience.'
                ],
                'Modifications' => [
                    'We reserve the right to modify or discontinue services for enhancement and evolution. Users will be duly notified of significant changes.
        Payment Terms.'
                ],
                'Fees' => [
                    'Users agree to pay the specified fees for our services. Details on fees are available on our pricing page.'
                ],
                'Payment Methods' => [
                    'We accept payments through [list of accepted payment methods]. Ensure your account has sufficient funds to avoid disruptions. Privacy Policy'
                ],
                'Data Collection' => [
                    'We collect and use user data as outlined in our Privacy Policy. Your privacy is paramount to us—please review our detailed policy.'
                ],

                'Dispute Resolution' => [
                    'Arbitration or Mediation: Disputes will be resolved through [arbitration/mediation process]. We believe in fair and efficient conflict resolution.',
                    'Jurisdiction: The governing law for disputes is the law of [your jurisdiction]. We aim for transparency and legal compliance.'
                ]
            ];
        ?>

        <?php foreach($introductions as $key => $items) :?>
            <h3><?php echo $key?></h3>
            <?php foreach($items as $key => $intro) :?>
                <p><?php echo $intro?></p>
            <?php endforeach?>
        <?php endforeach?>
        <p> By using our services, you acknowledge that you have read and agreed to these terms. </p>

        <img src="<?php echo _path_upload_get('hotpotlogo.png');?>" alt="<?php echo COMPANY_NAME?> Logo"
        style="width:150px; margin:0px auto; display:block">

        <p>06/24/2024</p>

        <br>
        <div style="margin: 0px auto;">
            <a href="<?php echo _route('home:terms-agree')?>" style="padding: 12px; text-align:center; background-color:orange; display:block; text-decoration:none; color:#fff">Agree and Continue</a>
        </div>
    </div>
</body>
</html>