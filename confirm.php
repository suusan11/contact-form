<?php
    //indexからのセッションを受け取る準備
    session_start();

    //入力画面からのアクセスでなければ、indexに戻す
    //（＝confirm.phpへの直接アクセスを防ぐ）
    if(!isset($_SESSION['form'])) {
        header('Location: index.php');
        exit();
    }else {
        //indexで渡されたフォームの内容を再度変数に入れる
        $_POST = $_SESSION['form'];
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        //送信ボタンが押されたら、問い合わせ確認メールを送信する

        //文字化け防止
        mb_language("Japanese");
        mb_internal_encoding("UTF-8");
        $from_name = mb_encode_mimeheader("株式会社〇〇〇〇");
        $from_address = 'info@example.com';

        //セパレートチェックボックスアイテム
        $check = implode( ', ', $_POST['check'] );

        //自動返信
        $to1 = $_POST['email'];
        $from1 = "From: ".$from_name.$from_address;
        $subject1 = 'お問い合わせありがとうございます';
        $body1 = <<<EOT
        ※このメールはシステムからの自動返信です。

        株式会社〇〇〇〇へのお問合せありがとうございました。
        以下の内容で送信いたしました。
        ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

        名前： {$_POST['namae']}
        ふりがな： {$_POST['kana']}
        メールアドレス： {$_POST['email']}
        郵便番号： {$_POST['zipcode']}
        住所1： {$_POST['address']}
        住所2： {$_POST['address2']}
        電話番号： {$_POST['tel']}
        好きな色： {$_POST['select']}
        好きなお寿司： {$check}
        今日の天気： {$_POST['radio']}
        問い合わせ内容： {$_POST['message']}

        ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

        後日担当者よりご連絡いたします。
        よろしくお願いいたします。

        ================================
        株式会社〇〇〇〇
        〒444-4444
        静岡県浜松市中区0000
        000-123-456
        ================================
        EOT;


        //受付メール
        $to2 = 'example@***.com';
        $from2 = 'From: '.$_POST['email'];
        $subject2 = 'ホームページよりお問合せを受け付けました。';
        $body2 = <<<EOT
        お問い合わせ内容
        ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

        名前： {$_POST['namae']}
        ふりがな： {$_POST['kana']}
        メールアドレス： {$_POST['email']}
        郵便番号： {$_POST['zipcode']}
        住所1： {$_POST['address']}
        住所2： {$_POST['address2']}
        電話番号： {$_POST['tel']}
        好きな色： {$_POST['select']}
        好きなお寿司： {$check}
        今日の天気： {$_POST['radio']}
        問い合わせ内容： {$_POST['message']}

        ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
        EOT;

        // var_dump($body);
        // exit();
        mb_language("Japanese");
        mb_internal_encoding("UTF-8");

        mb_send_mail($to1, $subject1, $body1, $from1);
        mb_send_mail($to2, $subject2, $body2, $from2);

        //セッションを消してお礼画面へ
        unset($_SESSION['form']);
        header('Location: thanks.html');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>メールフォーム</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <main>
        <h2 class="page__ttl">確認画面</h2>
        <div class="confirm__wrap">
            <form action="" method="POST">
                <p class="confirm__txt">以下の内容で予約を受付ます。<br class="min-only">よろしければ予約完了ボタンを押してください。</p>
                <div class="wrap__inner">
                    <div class="wrap__item">
                        <label>お名前</label>
                        <p><?php echo htmlspecialchars(@$_POST['namae']); ?></p>
                    </div>
                    <div class="wrap__item">
                        <label>ふりがな</label>
                        <p><?php echo htmlspecialchars(@$_POST['kana']); ?></p>
                    </div>
                    <div class="wrap__item">
                        <label>Eメールアドレス</label>
                        <p><?php echo htmlspecialchars(@$_POST['email']); ?></p>
                    </div>
                    <div class="wrap__item">
                        <label>郵便番号</label>
                        <p><?php echo htmlspecialchars(@$_POST['zipcode']); ?></p>
                    </div>
                    <div class="wrap__item">
                        <label>ご住所</label>
                        <p><?php echo htmlspecialchars(@$_POST['address']); ?></p>
                    </div>
                    <div class="wrap__item">
                        <label>建物名</label>
                        <p><?php echo htmlspecialchars(@$_POST['address2']); ?></p>
                    </div>
                    <div class="wrap__item">
                        <label>電話番号</label>
                        <p><?php echo htmlspecialchars(@$_POST['tel']); ?></p>
                    </div>
                    <div class="wrap__item">
                        <label>好きな色</label>
                        <p><?php echo htmlspecialchars(@$_POST['select']); ?></p>
                    </div>
                    <div class="wrap__item">
                        <label>好きなお寿司</label>
                        <?php for($i = 0; $i < count($_POST['check']); $i++) : ?>
                        <p><?php echo htmlspecialchars(@$_POST['check'][$i]); ?></p>
                        <?php endfor;?>
                    </div>
                    <div class="wrap__item">
                        <label>今日の天気</label>
                        <p><?php echo htmlspecialchars(@$_POST['radio']); ?></p>
                    </div>
                    <div class="wrap__item">
                        <label>お問い合わせの概要</label>
                        <p><?php echo nl2br(htmlspecialchars(@$_POST['message'])); ?></p>
                    </div>
                </div>
                <a class="form__button button-gray" href="index.php">入力内容を変更する</a>
                <button type="submit" class="form__button button-blue">送信する</button>
            </form>
        </div>
    </main>
</body>
</html>