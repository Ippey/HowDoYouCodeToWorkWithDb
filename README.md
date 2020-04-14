# How do you code to work with DB?

## 趣旨
DBを操作するサービスをSymfonyでを作る際、DBのデータ取得や保存をどのようにコーディングしていますか？
ControllerでRepositoryを使う、ServiceでRepositoryを使うなど、みなさんが普段どのように開発をしているかを知りたいと思い、このリポジトリを作成しました。

- DB操作の書き方
- トランザクションを扱う書き方

をメインに、みなさんがどのようにコーディングしているか見せていただけますでしょうか？

## プロジェクト概要
このプロジェクトでは、フォームから記事を登録し、一覧表示します。記事を登録する際、登録件数を別テーブルに保存しています。
（別テーブルに持たなくても件数は取得できますが、トランザクションを使いたいため、わざと保存しています。）  

### プロジェクト構成
- PHP 7.3
- Symfony 5.0
- SQLite 3.2以上
- yarn 1.9以上 もしくは npm 6.13以上
- Symfony CLI 4.0以上

### インストール〜ローカルサーバ起動
```shell
composer install
yarn install # もしくは npm install
yarn encore dev # もしくは npm run dev
bin/console doctrine:database:create
bin/console doctrine:schema:update --force
symfony local:server:start
```

URL: http://localhost:8000/articles

### このプロジェクトの構築について
このプロジェクトでは、Symfony公式ドキュメントと同様のやり方で、ControllerでEntityManager、RepositoryをgetしてDB操作を行っています。

## 公開方法
このリポジトリをフォークし、みなさんのコーディングをPull Requestとして公開してください。
その際、Pull Requestのコメントで

- どのようにコーディングしたか
- このコーディングのメリット
- 主に注意している点

などを記入してください。

## ライセンス
MIT


