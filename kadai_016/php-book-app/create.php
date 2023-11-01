<?php
$dsn = 'mysql:dbname=php_book_app;host=localhost;charset=utf8mb4';
$user = 'root';
$password = '';

// submitパラメータの値が存在するとき（「登録」ボタンを押したとき）の処理
if (isset($_POST['submit'])) {
    try {
        $pdo = new PDO($dsn, $user, $password);

        // 動的に変わる値をプレースホルダに置き換えたINSERT文（データを追加）をあらかじめ用意する　
        $sql_insert = '
            INSERT INTO books (book_code, book_name, price, stock_quantity, genre_code)
            VALUES (:book_code, :book_name, :price, :stock_quantity, :genre_code)
        ';
        $stmt_insert = $pdo->prepare($sql_insert); // ★★★->アロー演算子　プロパティやメソッドにアクセスするため　何のためにするのか？

        // bindValue()メソッドを使って実際の値をプレースホルダにバインドする（割り当てる）
        $stmt_insert->bindValue(':book_code', $_POST['book_code'], PDO::PARAM_INT);
        $stmt_insert->bindValue(':book_name', $_POST['book_name'], PDO::PARAM_STR);
        $stmt_insert->bindValue(':price', $_POST['price'], PDO::PARAM_INT);
        $stmt_insert->bindValue(':stock_quantity', $_POST['stock_quantity'], PDO::PARAM_INT);
        $stmt_insert->bindValue(':genre_code', $_POST['genre_code'], PDO::PARAM_INT);

        // SQL文を実行する
        $stmt_insert->execute();

        // 追加した件数を取得する
        $count = $stmt_insert->rowCount();

        $message = "商品を{$count}件登録しました。";

        // 商品一覧ページにリダイレクトさせる（同時にmessageパラメータも渡す）
        header("Location: read.php?message={$message}");
    } catch (PDOException $e) {
        exit($e->getMessage());
    }
}

// セレクトボックスの選択肢として設定するため、仕入先コードの配列を取得する
try {
    $pdo = new PDO($dsn, $user, $password);

    // genresテーブルからgenre_codeカラムのデータを取得するためのSQL文を変数$sql_selectに代入する
    $sql_select = 'SELECT genre_code FROM genres';

    // SQL文を実行する
    $stmt_select = $pdo->query($sql_select);

    // SQL文の実行結果を配列で取得する
    // 補足：PDO::FETCH_COLUMNは1つのカラムの値を1次元配列（多次元ではない普通の配列）で取得する設定である
    // ★★★　なんで今回１次元配列なのか。前との違いは何か。？
    $genre_codes = $stmt_select->fetchAll(PDO::FETCH_COLUMN);
} catch (PDOException $e) {
    exit($e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>書籍登録</title>
    <link rel="stylesheet" href="css/style.css">

    <!-- Google Fontsの読み込み -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <nav>
            <a href="index.php">書籍管理アプリ</a>
        </nav>
    </header>
    <main>
        <article class="registration">
            <h1>書籍登録</h1>
            <div class="back">
                <a href="read.php" class="btn">&lt; 戻る</a>
            </div>
            <form action="create.php" method="post" class="registration-form">
                <div>
                    <label for="book_code">書籍コード</label>
                    <input type="number" name="book_code" min="0" max="100000000" required> ? <!-- required必須 -->

                    <label for="book_name">書籍名</label>
                    <input type="text" name="book_name" maxlength="50" required>

                    <label for="price">単価</label>
                    <input type="number" name="price" min="0" max="100000000" required>

                    <label for="stock_quantity">在庫数</label>
                    <input type="number" name="stock_quantity" min="0" max="100000000" required>

                    <label for="genre_code">ジャンルコード</label>
                    <select name="genre_code" required>
                        <option disabled selected value>選択してください</option>
                        <?php
                        // 配列の中身を順番に取り出し、セレクトボックスの選択肢として出力する
                        foreach ($genre_codes as $genre_code) {
                            echo "<option value='{$genre_code}'>{$genre_code}</option>";
                        }
                        ?>
                    </select>
                </div>
                <button type="submit" class="submit-btn" name="submit" value="create">登録</button>
                <!-- type="submit"とはフォーム入力を送信するサブミットボタン（初期値）-->
                <!-- class="submit-btn"とはcssでひもづける-->
                <!-- name="submit"とはフォームデータの一部としてこのボタンのvalueとの組み合わせで送信される　-->
                <!-- value="create"とはフォームのデータと一緒に送信される際に、ボタンのnameに結び付けられる値を定義する。フォームを送信する際にサーバーに引数として渡される）-->
            </form>
        </article>
    </main>
    <footer>
        <p class="copyright">&copy; 書籍管理アプリ All rights reserved.</p>
    </footer>
</body>

</html>