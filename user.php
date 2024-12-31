<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>データ登録</title>
        <link href="css/styles.css" rel="stylesheet">
        <style>div{padding: 10px;font-size:16px;}</style>
    </head>
    <body>

        <!-- Head[Start] -->
        <header>
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <!--<div class="navbar-header"><a class="navbar-brand" href="select.php">データ一覧</a></div>-->
                </div>
            </nav>
        </header>
        <!-- Head[End] -->

        <!-- Main[Start] -->
        <form method="POST" action="userinsert.php">
            <div class="jumbotron">
            <h1>メンタルヘルスカウンセリング</h1>
            <p>登録して始めましょう</p>
                <fieldset>
                    <legend>ユーザー登録</legend>
                    <label>名前：<input type="varchar" name="name"></label><br>
                    <label>誕生日：<input type="date" name="birthday"></label><br>
                    <label>性別：
                    <select name="gender" required>
    <option value="">選択してください</option>
    <option value="male">男性</option>
    <option value="female">女性</option>
    <option value="other">その他</option>
</select>
                </label><br>
                    <label>職業：<input type="varchar" name="job"></label><br>
                    <label>メールアドレス：<input type="varchar" name="email"></label><br>
                    <label>パスワード：<input type="varchar" name="password"></label><br>
                    <!--<label><textArea name="naiyou" rows="4" cols="40"></textArea></label><br>-->
                    <input type="submit" value="送信">
                </fieldset>
            </div>
        </form>
        <!-- Main[End] -->


    </body>
</html>
