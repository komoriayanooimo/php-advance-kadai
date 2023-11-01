<!DOCTYPE html>   <!-- 特に問題なし -->
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <!-- width=device-width 表示領域の幅で端末画面の幅に合わせる指定ができる　-->
    <!-- initial-scale=1.0 初期のズーム倍率  基本的な設定　-->
    <title>書籍管理アプリ</title>
    <link rel="stylesheet" href="css/style.css">

    <!-- Google Fontsの読み込み -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <nav>  <!-- ナビゲーションにしたい範囲をnavタグで囲う　a href使う-->
            <a href="index.php">書籍管理アプリ</a>
        </nav>
    </header>
    <main>
        <article class="home"> <!-- article 独立した意味のある記事に使う-->
            <h1>書籍管理アプリ</h1>
            <p>『PHPとデータベースを連携しよう』成果物</p>
            <a href="read.php" class="btn">書籍一覧</a>
        </article>
    </main>
    <footer>
        <p class="copyright">&copy; 書籍管理アプリ All rights reserved.</p>
    </footer>
</body>

</html><!-- 2FA -->