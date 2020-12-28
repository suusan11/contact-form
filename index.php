<?php
    //セッション変数を有効にする
    session_start();
    $errMessage = []; //エラーメッセージ配列の初期化

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        //フォームの送信時にエラーをチェックする
        if($post['name'] === '') {
            $errMessage['name'] = 'blank';
        }
        if($post['kana'] === '') {
            $errMessage['kana'] = 'blank';
        }
        if($post['email'] === '') {
            $errMessage['email'] = 'blank';
        }else if(!filter_var($post['email'], FILTER_VALIDATE_EMAIL)) {
            $errMessage['email'] = 'checkEmail';
        }
        if($post['address'] === '') {
            $errMessage['address'] = 'blank';
        }
        if($post['tel'] === '') {
            $errMessage['tel'] = 'blank';
        }
        if($post['message'] === '') {
            $errMessage['message'] = 'blank';
        }

        if(count($errMessage) === 0) {
            //エラーメッセージの配列が空＝エラーがなかったら
            $_SESSION['form'] = $post; //セッション変数にPOSTの内容を渡す
            header('Location: confirm.php');
            exit();
        }
    }else {
        //confirmで戻るボタンを押した時に入力値を消さない処理
        if(isset($_SESSION['form'])) {
            $post = $_SESSION['form'];
        }
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
        <h2 class="page__ttl">メールフォーム</h2>
        <div class="contact__form">
            <form action="" method="post" novalidate>
                <div class="form__item input__text required">
                    <div class="c-item-top">
                        <span class="required__txt">必須</span>
                        <label class="label" for="name">お名前</label>
                        <p class="input__sample">（例）リトル ミィ</p>
                    </div>
                    <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($post['name']); ?>">
                    <?php if($errMessage['name'] === 'blank') : ?>
                    <div class="input__error">
                        <p>名前を入力してください。</p>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="form__item input__text required">
                    <div class="c-item-top">
                        <span class="required__txt">必須</span>
                        <label class="label" for="kana">ふりがな</label>
                        <p class="input__sample">（例）りとる みぃ</p>
                    </div>
                    <input type="text" name="kana" id="kana" value="<?php echo htmlspecialchars($post['kana']); ?>">
                    <?php if($errMessage['kana'] === 'blank') : ?>
                    <div class="input__error">
                        <p>ふりがなを入力してください。</p>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="form__item input__text required">
                    <div class="c-item-top">
                        <span class="required__txt">必須</span>
                        <label class="label" for="email">Eメールアドレス</label>
                        <p class="input__sample">（例）xxxxx@xx.xx</p>
                    </div>
                    <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($post['email']); ?>">
                    <?php if($errMessage['email'] === 'blank') : ?>
                    <div class="input__error">
                        <p>Eメールアドレスを入力してください。</p>
                    </div>
                    <?php endif; ?>
                    <?php if($errMessage['email'] === 'checkEmail') : ?>
                    <div class="input__error">
                    <p>正しいEメールアドレスを入力してください。</p>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="form__item input__text required">
                    <div class="c-item-top">
                        <span class="required__txt">必須</span>
                        <label class="label" for="address">ご住所</label>
                        <p class="input__sample">（例）ムーミンバレー 2814</p>
                    </div>
                    <input type="text" name="address" id="address" value="<?php echo htmlspecialchars($post['address']); ?>">
                    <?php if($errMessage['address'] === 'blank') : ?>
                    <div class="input__error">
                        <p>住所を入力してください。</p>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="form__item input__text required">
                    <div class="c-item-top">
                        <span class="option__txt">任意</span>
                        <label class="label" for="address2">建物名</label>
                        <p class="input__sample">（例）ニョロニョロビルディング 301</p>
                    </div>
                    <input type="text" name="address2" id="address2" value="<?php echo htmlspecialchars($post['address2']); ?>">
                </div>
                <div class="form__item input__text required">
                    <div class="c-item-top">
                        <span class="required__txt">必須</span>
                        <label class="label" for="tel">電話番号</label>
                        <p class="input__sample">（例）000-000-0000</p>
                    </div>
                    <input type="tel" name="tel" id="tel" value="<?php echo htmlspecialchars($post['tel']); ?>">
                    <?php if($errMessage['tel'] === 'blank') : ?>
                    <div class="input__error">
                        <p>電話番号を入力してください。</p>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="form__item form__message required">
                    <div class="c-item-top">
                        <span class="required__txt">必須</span>
                        <label for="message">ミィへのメッセージ</label>
                    </div>
                    <textarea name="message" id="message"><?php echo htmlspecialchars($post['message']); ?></textarea>
                    <?php if($errMessage['message'] === 'blank') : ?>
                    <div class="input__error">
                        <p>お問い合わせの概要をご記入ください。</p>
                    </div>
                    <?php endif; ?>
                </div>
                <button type="submit" class="form__button button-blue" href="javascript:void(0)">確認画面へ</button>
            </form>
        </div>
    </main>
</body>
</html>