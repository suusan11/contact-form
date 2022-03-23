<?php
    //セッション変数を有効にする
    session_start();
    $errMessage = []; //エラーメッセージ配列の初期化

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        //フォームの送信時にエラーをチェックする
        if($_POST['namae'] === '') {
            $errMessage['namae'] = 'blank';
        }
        if($_POST['kana'] === '') {
            $errMessage['kana'] = 'blank';
        }
        if($_POST['email'] === '') {
            $errMessage['email'] = 'blank';
        }else if(!filter_var(@$_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errMessage['email'] = 'checkEmail';
        }
        if($_POST['zipcode'] === '') {
            $errMessage['zipcode'] = 'blank';
        }
        if($_POST['address'] === '') {
            $errMessage['address'] = 'blank';
        }
        if($_POST['tel'] === '') {
            $errMessage['tel'] = 'blank';
        }
        if($_POST['select'] === 'default') { //selectの値がdefultだったら
            $errMessage['select'] = 'blank';
        }
        if(empty($_POST['check'])) { //配列が空だったら
            $errMessage['check'] = 'blank';
        }
        if(empty($_POST['radio'])) {
            $errMessage['radio'] = 'blank';
        }
        if($_POST['message'] === '') {
            $errMessage['message'] = 'blank';
        }

        if(count($errMessage) === 0) {
            //エラーメッセージの配列が空＝エラーがなかったら
            $_SESSION['form'] = $_POST; //セッション変数にPOSTの内容を渡す
            header('Location: confirm.php');
            exit();
        }
    }else {
        //confirmで戻るボタンを押した時に入力値を消さない処理
        if(isset($_SESSION['form'])) {
            $_POST = $_SESSION['form'];
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
            <form action="" method="POST" novalidate>
                <div class="form__item input__text required">
                    <div class="c-item-top">
                        <span class="required__txt">必須</span>
                        <label class="label" for="namae">お名前</label>
                        <p class="input__sample">（例）リトル ミィ</p>
                    </div>
                    <input type="text" name="namae" id="namae" value="<?php echo htmlspecialchars(isset($_POST['namae']) ? ($_POST['namae']) : null); ?>">
                    <?php if(!empty($errMessage['namae'])) : ?>
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
                    <input type="text" name="kana" id="kana" value="<?php echo htmlspecialchars(isset($_POST['kana']) ? ($_POST['kana']) : null); ?>">
                    <?php if(!empty($errMessage['kana'])) : ?>
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
                    <input type="email" name="email" id="email" value="<?php echo htmlspecialchars(isset($_POST['email']) ? ($_POST['email']) : null); ?>">
                    <?php if(!empty($errMessage['email'])) : ?>
                        <div class="input__error">
                            <p>Eメールアドレスを入力してください。</p>
                        </div>
                    <?php endif; ?>
                    <?php if(isset($errMessage['email']) === 'checkEmail') : ?>
                        <div class="input__error">
                            <p>正しいEメールアドレスを入力してください。</p>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="form__item input__text required">
                    <div class="c-item-top">
                        <span class="required__txt">必須</span>
                        <label class="label" for="zipcode">郵便番号</label>
                        <p class="input__sample">（例）4310431</p>
                    </div>
                    <input type="text" name="zipcode" id="zipcode" maxlength="8" onKeyUp="AjaxZip3.zip2addr(this,'','address','address');" value="<?php echo htmlspecialchars($_POST['zipcode']); ?>">
                    <?php if(!empty($errMessage['zipcode'])) : ?>
                        <div class="input__error">
                            <p>郵便番号を入力してください。</p>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="form__item input__text required">
                    <div class="c-item-top">
                        <span class="required__txt">必須</span>
                        <label class="label" for="address">ご住所</label>
                        <p class="input__sample">（例）ムーミンバレー 2814</p>
                    </div>
                    <input type="text" name="address" id="address" value="<?php echo htmlspecialchars(isset($_POST['address']) ? ($_POST['address']) : null); ?>">
                    <?php if(!empty($errMessage['address'])) : ?>
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
                    <input type="text" name="address2" id="address2" value="<?php echo htmlspecialchars(isset($_POST['address2']) ? ($_POST['address2']) : null); ?>">
                </div>
                <div class="form__item input__text required">
                    <div class="c-item-top">
                        <span class="required__txt">必須</span>
                        <label class="label" for="tel">電話番号</label>
                        <p class="input__sample">（例）000-000-0000</p>
                    </div>
                    <input type="tel" name="tel" id="tel" value="<?php echo htmlspecialchars(isset($_POST['tel']) ? ($_POST['tel']) : null); ?>">
                    <?php if(!empty($errMessage['tel'])) : ?>
                        <div class="input__error">
                            <p>電話番号を入力してください。</p>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="form__item form__select required">
                    <div class="c-item-top">
                        <span class="required__txt">必須</span>
                        <label for="select">好きな色</label>
                    </div>
                    <select name="select" id="select">
                        <option value="default">選択してください</option>
                        <option value="赤" <?php if(isset($_POST['select']) && $_POST['select'] === '赤') echo 'selected'; ?>>赤</option>
                        <option value="ピンク" <?php if(isset($_POST['select']) && $_POST['select'] === 'ピンク') echo 'selected'; ?>>ピンク</option>
                        <option value="青" <?php if(isset($_POST['select']) && $_POST['select'] === '青') echo 'selected'; ?>>青</option>
                        <option value="黄色" <?php if(isset($_POST['select']) && $_POST['select'] === '黄色') echo 'selected'; ?>>黄色</option>
                    </select>
                    <?php if(!empty($errMessage['select'])) : ?>
                        <div class="input__error">
                            <p>選択してください。</p>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="form__item form__check required">
                    <div class="c-item-top">
                        <span class="required__txt">必須</span>
                        <label>好きなお寿司</label>
                    </div>
                    <input type="checkbox" name="check[]" value="まぐろ" id="check1" <?php if(isset($_POST['check']) && in_array('まぐろ', (array)$_POST['check'])) echo 'checked'; ?>><label for="check1">まぐろ</label>
                    <input type="checkbox" name="check[]" value="たい" id="check2" <?php if(isset($_POST['check']) && in_array('たい', (array)$_POST['check'])) echo 'checked'; ?>><label for="check2">たい</label>
                    <input type="checkbox" name="check[]" value="たこ" id="check3" <?php if(isset($_POST['check']) && in_array('たこ', (array)$_POST['check'])) echo 'checked'; ?>><label for="check3">たこ</label>
                    <?php if(!empty($errMessage['check'])) : ?>
                        <div class="input__error">
                            <p>チェックしてください。</p>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="form__item form__radio required">
                    <div class="c-item-top">
                        <span class="required__txt">必須</span>
                        <label>今日の天気</label>
                    </div>
                    <input type="radio" name="radio" value="晴れ" id="radio1" <?php if(isset($_POST['radio']) && $_POST['radio'] === '晴れ') echo 'checked'; ?>><label for="radio1">晴れ</label>
                    <input type="radio" name="radio" value="くもり" id="radio2" <?php if(isset($_POST['radio']) && $_POST['radio'] === 'くもり') echo 'checked'; ?>><label for="radio2">くもり</label>
                    <input type="radio" name="radio" value="雨" id="radio3" <?php if(isset($_POST['radio']) && $_POST['radio'] === '雨') echo 'checked'; ?>><label for="radio3">雨</label>
                    <?php if(!empty($errMessage['radio'])) : ?>
                        <div class="input__error">
                            <p>チェックしてください。</p>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="form__item form__message required">
                    <div class="c-item-top">
                        <span class="required__txt">必須</span>
                        <label for="message">ミィへのメッセージ</label>
                    </div>
                    <textarea name="message" id="message"><?php echo nl2br(htmlspecialchars(isset($_POST['message']) ? ($_POST['message']) : null)); ?></textarea>
                    <?php if(!empty($errMessage['message'])) : ?>
                        <div class="input__error">
                            <p>お問い合わせの概要をご記入ください。</p>
                        </div>
                    <?php endif; ?>
                </div>
                <button type="submit" class="form__button button-blue">確認画面へ</button>
            </form>
        </div>
    </main>
    <script type="text/javascript" src="https://ajaxzip3.github.io/ajaxzip3.js"></script>
</body>
</html>