## このリポジトリについて

ショッピングサイトのAPIをLaravel×DDDで試しに作ってみるという練習リポジトリです

### アーキテクチャ
未着手

### ユースケース図
未着手

### クラス図
未着手

### コンテキストマップ
未着手


### プロファイラ
https://readouble.com/laravel/9.x/ja/telescope.html
テレスコープでパフォーマンスを見ながら開発を進める

### 例外設計
* ハンドリングはapp/Exceptions/Handler.phpで集中管理する
* ドメインレイヤとユースケースレイヤでは独自例外を投げる
    * app/Packages/Shared配下に独自例外クラスを作った
    * コンテキストごとに作った方が良いか?

