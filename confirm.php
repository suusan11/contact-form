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
        $post = $_SESSION['form'];
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        //送信ボタンが押されたら、問い合わせ確認メールを送信する

        //文字化け防止
        mb_language("Japanese");
        mb_internal_encoding("UTF-8");
        $from_name = mb_encode_mimeheader("株式会社〇〇〇〇");
        $from_address = 'info@example.com';

        //セパレートチェックボックスアイテム
        $check = implode( ', ', $post['check'] );

        //自動返信
        $to1 = $post['email'];
        $from1 = "From: ".$from_name.$from_address;
        $subject1 = 'お問い合わせありがとうございます';
        $body1 = <<<EOT
        ※このメールはシステムからの自動返信です。

        株式会社〇〇〇〇へのお問合せありがとうございました。
        以下の内容で送信いたしました。
        ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

        名前： {$post['name']}
        ふりがな： {$post['kana']}
        メールアドレス： {$post['email']}
        郵便番号： {$post['zipcode']}
        住所1： {$post['address']}
        住所2： {$post['address2']}
        電話番号： {$post['tel']}
        好きな色： {$post['select']}
        好きなお寿司： {$check}
        今日の天気： {$post['radio']}
        問い合わせ内容： {$post['message']}

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
        $to2 = 'info@example.com';
        $from2 = 'From: '.$post['email'];
        $subject2 = 'ホームページよりお問合せを受け付けました。';
        $body2 = <<<EOT
        お問い合わせ内容
        ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

        名前： {$post['name']}
        ふりがな： {$post['kana']}
        メールアドレス： {$post['email']}
        郵便番号： {$post['zipcode']}
        住所1： {$post['address']}
        住所2： {$post['address2']}
        電話番号： {$post['tel']}
        好きな色： {$post['select']}
        好きなお寿司： {$check}
        今日の天気： {$post['radio']}
        問い合わせ内容： {$post['message']}

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
                        <p><?php echo htmlspecialchars($post['name']); ?></p>
                    </div>
                    <div class="wrap__item">
                        <label>ふりがな</label>
                        <p><?php echo htmlspecialchars($post['kana']); ?></p>
                    </div>
                    <div class="wrap__item">
                        <label>Eメールアドレス</label>
                        <p><?php echo htmlspecialchars($post['email']); ?></p>
                    </div>
                    <div class="wrap__item">
                        <label>郵便番号</label>
                        <p><?php echo htmlspecialchars($post['zipcode']); ?></p>
                    </div>
                    <div class="wrap__item">
                        <label>ご住所</label>
                        <p><?php echo htmlspecialchars($post['address']); ?></p>
                    </div>
                    <div class="wrap__item">
                        <label>建物名</label>
                        <p><?php echo htmlspecialchars($post['address2']); ?></p>
                    </div>
                    <div class="wrap__item">
                        <label>電話番号</label>
                        <p><?php echo htmlspecialchars($post['tel']); ?></p>
                    </div>
                    <div class="wrap__item">
                        <label>好きな色</label>
                        <p><?php echo htmlspecialchars($post['select']); ?></p>
                    </div>
                    <div class="wrap__item">
                        <label>好きなお寿司</label>
                        <?php for($i = 0; $i < count($post['check']); $i++) : ?>
                        <p><?php echo htmlspecialchars($post['check'][$i]); ?></p>
                        <?php endfor;?>
                    </div>
                    <div class="wrap__item">
                        <label>今日の天気</label>
                        <p><?php echo htmlspecialchars($post['radio']); ?></p>
                    </div>
                    <div class="wrap__item">
                        <label>お問い合わせの概要</label>
                        <p><?php echo nl2br(htmlspecialchars($post['message'])); ?></p>
                    </div>
                </div>
                <a class="form__button button-gray" href="index.php">入力内容を変更する</a>
                <button type="submit" class="form__button button-blue">送信する</button>
            </form>
        </div>
    </main>
</body>
</html>