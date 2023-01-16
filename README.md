## このリポジトリについて

ショッピングサイトのAPIをLaravel×DDDで試しに作ってみるという練習リポジトリです

### プロファイラ
https://readouble.com/laravel/9.x/ja/telescope.html
テレスコープでパフォーマンスを見ながら開発を進める

### レスポンスデータの加工
https://readouble.com/laravel/8.x/ja/eloquent-resources.html
APIリソースを使う
JsonResource::withoutWrapping();を記述しdataのラップをなくす

### 例外設計
* ハンドリングはapp/Exceptions/Handler.phpで集中管理する
* ドメインレイヤとユースケースレイヤでは独自例外を投げる
    * コンテキストごとに作った方が良いかよく分からない
    * 一旦app/Packages/Shared配下に独自例外クラスを作った
    
### テストコード
* ドメインレイヤのユニットテスト
* ユースケースレイヤの機能テスト
* コントローラーの機能テスト(thephpleague/openapi-psr7-validatorを使う)

### DBの採番処理が絡むところ
Factoryパターンで実装