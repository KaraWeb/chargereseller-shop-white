<?php include '../config.php'; ?>
<!DOCTYPE html>
<html lang="fa">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="description" content="<?php echo $config['description']; ?>" />
	<meta name="keywords" content="<?php echo $config['keywords']; ?>" />
	<link href="css/favicon.ico" type="image/x-icon" rel="icon" />
	<link rel="stylesheet" type="text/css" href="css/jquery.qtip.css" />
	<link rel="stylesheet" type="text/css" href="css/style.css"/>
	<title><?php echo $config['title']; ?></title>
</head>
<body>
	<div class="bgs bgs-display">
        <?php
            $result = base64_decode(urldecode(htmlspecialchars($_GET['data'])));
            $result = json_decode($result, true);
            echo '<div class="container verify bgs-content ' . $result['Type'] . '">';
                if ($result['Status'] == 100) {
                    if ($result['Type'] == 'Bill') {
                        $billTypesPersian = array("آب", "بــرق", "گـــاز", "تلفن ثابت", "تلفن همراه", "عوارض شهرداری","","","جریمه راهنمایی و رانندگی");
                        $billTypesEnglish = array("water", "electricity", "gas", "telephone", "cellphone", "mayoralty","","","police");
        ?>
                        <div id="content" class="Bill">
                            <div class="bill"></div>
                            <table id="bill-info">
                                <tbody class="bill-info-td">
                                    <tr>
                                        <td>نوع قبض</td>
                                        <td>
                                            <span id="type" class="bill <?php echo $billTypesEnglish[$result['BillType']]; ?>"></span>
                                            <span id="type-title"><?php echo $billTypesPersian[$result['BillType']]; ?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>تاریخ</td>
                                        <td><?php echo $result['Date']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>مبلغ قبض</td>
                                        <td><?php echo $result['BillAmount'] . ' تومان'; ?></td>
                                    </tr>
                                    <tr>
                                        <td>شناسه قبض</td>
                                        <td><?php echo $result['BillId']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>شناسه پرداخت</td>
                                        <td><?php echo $result['PaymentId']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>کد پیگیری</td>
                                        <td><?php echo $result['TranId']; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="return">
                                <a class="mainpage" href="<?php echo str_replace('mobile', '', $root); ?>"><div class="return-mainpage"></div>صفحه اصلی فروشگاه</a>
                            </div>
                        </div>
                <?php
                    } elseif ($result['Type'] == 'TopUp') {
                        $operators = array('MCI' => 'همراه اول', 'MTN' => 'ایرانسل', 'RTL' => 'رایتل', 'TAL' => 'تالیا');
                ?>
                        <div id="content">
                            <div>
                                <div class="TopUp"></div>
                                <div>شارژ مستقیم</div>
                            </div>
                            <table>
                                <tbody>
                                    <tr>
                                        <td>تاریخ</td>
                                        <td><?php echo $result['Date']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>مبلغ شارژ</td>
                                        <td><?php echo $result['Amount'] . ' تومان'; ?></td>
                                    </tr>
                                    <tr>
                                        <td>اپراتور شارژ</td>
                                        <td><?php echo $operators[$result['Operator']]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>شماره تلفن همراه</td>
                                        <td><?php echo $result['Cellphone']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>کد پیگیری</td>
                                        <td><?php echo $result['TranId']; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="return">
                                <a class="mainpage" href="<?php echo str_replace('mobile', '', $root); ?>"><div class="return-mainpage"></div>صفحه اصلی فروشگاه</a>
                            </div>
                        </div>
                <?php
                    } elseif ($result['Type'] == 'PinProduct') {
                        $pinProductDescription = array(
                            'CC' => 'اکنون با وارد کردن کد شارژ از طریق صفحه کلید گوشی، تلفن همراه خود را شارژ نمایید.',
                            'GC' => 'با استفاده گیفت کارت خریداری شده می توانید از سرویس هایی همچون خرید نرم افزار، بازی، موسیقی، فیلم، کتاب و ... استفاده نمایید.',
                            'TC' => 'رمز مجوز را با اعداد انگلیسی به شماره 20001888 پیامک نمایید. پس از دریافت پیامک اعلام اعتبار می توانید پلاک خودرو خود را مطابق روال پیامک کنید.<br>در صورتی که برای نخستین بار از مجوز روزانه استفاده می کنید با شماره ندای ترافیک 87500-021 تماس بگیرید.',
                            'AN' => 'با وارد کردن رمز آنتی ویروس خود را فعال کنید.<br>جهت راهنمایی بیشتر به منوی «راهنما» مراجعه نمایید.'
                        );
                        $dataKeys = array('Serial' => 'سریال', 'Username' => 'نام کاربری', 'ExpireDate' => 'تاریخ انقضاء');
                        $productCount = count($result['BuyInfo']);
                        if ($productCount > 1) {
                ?>
                            <div id="content">
                                <div class="<?php echo substr($result['PinProductKind'], 0, 2); ?>"></div>
                                <div class="buy-details">
                                    <h2><?php echo $result['PinProductName']; ?></h2>
                                    <span>تاریخ:</span>
                                    <span><?php echo $result['Date']; ?></span>
                                    <span class="buy-details-pinproduct">کد پیگیری:</span>
                                    <span><?php echo $result['TranId']; ?></span>
                                    <br><span>قیمت واحد:</span>
                                    <span><?php echo $result['UnitAmount']; ?> تومان</span>
                                    <span class="buy-details-count">تعداد:</span>
                                    <span class="buy-details-number"><?php echo $result['Count']; ?> عدد</span><br>
                                    <span>قیمت کل:</span>
                                    <span><?php echo $result['UnitAmount'] * $result['Count']; ?> تومان</span>
                                </div>
                                <div class="products-info">
                                    <table>
                                        <thead>
                                            <th><?php 
                                                if (substr($result['PinProductKind'], 0, 2) != 'AN') {
                                                    echo 'رمز (پین)'; 
                                                } else { 
                                                    echo 'پسورد'; 
                                                }
                                            ?></th>
                                            <?php
                                                foreach ($result['BuyInfo'][0]['ExtraData'] as $key => $value) {
                                                    if (array_key_exists($key, $dataKeys)) {
                                                        echo '<th>' . $dataKeys[$key] . '</th>';
                                                    } else {
                                                        echo '<th>' . $key . '</th>';
                                                    }
                                                }
                                            ?>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                for ($i = 0; $i < $productCount; $i++) {
                                                    echo '<tr>'
                                                            . '<td class="ltr product-count">' . $result['BuyInfo'][$i]['Pin'] .'</td>';
                                                        foreach ($result['BuyInfo'][$i]['ExtraData'] as $key => $value) {
                                                            echo '<td class="ltr product-count">' . $value .'</td>';
                                                        }
                                                    echo '</tr>';
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="return">
                                    <a class="mainpage" href="<?php echo str_replace('mobile', '', $root); ?>"><div class="return-mainpage"></div>صفحه اصلی فروشگاه</a>
                                </div>
                            </div>
                    <?php
                        } else {
                            $operator = explode('-', $result['PinProductKind']);
                            $registerPinCode = '';
                            if (in_array($operator[1], array('MCI', 'TAL'))) {
                                $registerPinCode = '#رمزشارژ#*140*';
                            } elseif (in_array($operator[1], array('MTN', 'RTL'))) {
                                $registerPinCode = '#رمزشارژ*141*';
                            }
                    ?>
                            <div id="content">
                                <div class="<?php echo substr($result['PinProductKind'], 0, 2); ?>"></div>
                                <h1 class="PinName"><?php echo $result['PinProductName']; ?></h1>
                                <table class="PinProduct-table">
                                    <tbody>
                                        <tr>
                                            <td>تاریخ</td>
                                            <td><?php echo $result['Date']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>مبلغ</td>
                                            <td><?php echo $result['UnitAmount'] . ' تومان'; ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php 
                                                if (substr($result['PinProductKind'], 0, 2) != 'AN') {
                                                    echo 'رمز (پین)'; 
                                                } else { 
                                                    echo 'پسورد'; 
                                                }
                                            ?></td>
                                            <td class="ltr"><?php echo $result['BuyInfo'][0]['Pin']; ?></td>
                                        </tr>
                                        <?php if (!empty($registerPinCode)) { ?>
                                            <tr>
                                                <td>کد ورود شارژ</td>
                                                <td><?php echo $registerPinCode; ?></td>
                                            </tr>
                                    <?php
                                        }
                                        foreach ($result['BuyInfo'][0]['ExtraData'] as $key => $value) {
                                            echo '<tr>';
                                            if (array_key_exists($key, $dataKeys)) {
                                                echo '<td>' . $dataKeys[$key] . '</td>';
                                            } else {
                                                echo '<td>' . $key . '</td>';
                                            }
                                            echo '<td class="ltr">' . $value . '</td>' . '</tr>';
                                        }
                                    ?>
                                        <tr>
                                            <td>کد پیگیری</td>
                                            <td><?php echo $result['TranId']; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="return">
                                    <a class="mainpage" href="<?php echo str_replace('mobile', '', $root); ?>"><div class="return-mainpage"></div>صفحه اصلی فروشگاه</a>
                                </div>
                            </div>
            <?php
                        }
                    }
                } else {
            ?>
                    <div class="failed">
                        <div class="logo"></div>
                        <div class="explanation">
                            <h1>تراکنش ناموفق بود.</h1>
                            <?php
                                if ($result['Status'] == -11) {
                                    echo '<h2>خطا در اطلاعات دریافتی</h2>';
                                } elseif ($result['Status'] == -22) {
                                    echo '<h2>درگاه بانکی نامعتبر است.</h2>';
                                } elseif ($result['Status'] == -33) {
                                    echo '<h2>لغو درخواست توسط مشتری</h2>';
                                } elseif ($result['Status'] == -44) {
                                    echo '<h2>شماره درخواست نامعتبر است.</h2>';
                                } elseif ($result['Status'] == -55) {
                                    echo '<h2>تراکنش تائید نشد.</h2>';
                                }
                            ?>
                            <p>چنانچه وجه از حساب شما کسر شده است، طی 72 ساعت کاری آینده از طرف بانک وجه به حساب شما باز می گردد.</p>
                        </div>
                        <div class="return">
                            <a class="mainpage" href="<?php echo str_replace('mobile', '', $root); ?>"><div class="return-mainpage"></div> صفحه اصلی فروشگاه</a>
                        </div>
                        <div class="clear"></div>
                    </div>	
            <?php
                }
            ?>
			<div class="clear"></div>
		</div>
    </div>
	<script type="text/javascript" src="js/jquery-2.1.0.min.js"></script>
	<script type="text/javascript" src="js/jquery.qtip.min.js"></script>
</body>
</html>