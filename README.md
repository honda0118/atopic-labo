# Atopic labo
皮膚病・敏感肌で悩んでいるユーザー同士で「お肌にやさしいコスメ・化粧品」情報を共有し、悩みを解決するサービスです。  
サービスURL: https://atopic-labo.xyz<br>
 <img width="1400" alt="メインビジュアル" src="https://user-images.githubusercontent.com/141541659/283321116-63302091-7bc3-408e-90d8-7f96124d5dbd.jpg">
 <img width="1002" height="546" alt="インデックスページ" src= "https://user-images.githubusercontent.com/141541659/283321077-0d23a9ff-8ff9-484c-8fa0-876251f71062.jpg">

# 開発背景
本サイト開発者はアトピー性皮膚炎の持病があります。  
皮膚病を改善するために、クチコミを参考にして保湿剤や入浴剤などを購入していました。  
その経験をもとに、皮膚病・敏感肌で悩んでいるユーザー同士で「お肌にやさしいコスメ・化粧品」情報を共有し、悩みを解決する目的で本サービスを開発しました。

# URL
サービスURL: https://atopic-labo.xyz  
ログインページ: https://atopic-labo.xyz/login  
※ログインページ下部にある「かんたんログイン」から、メールアドレスとパスワードを入力せずにログインできます。

# 機能一覧
## 商品関連
- 商品  
投稿 / 編集 / 削除
- クチコミ  
投稿 / 編集 / 削除
- いいね！  
付与 / 削除
- お気に入り  
登録 / 削除
- クチコミランキング
- キーワード商品検索
- カテゴリー別商品検索
- ブランド別商品検索
- ページネーション

## 会員関連
- 会員  
登録 / 編集/ 削除

## 表示関連
レスポンシブデザイン

# 使用技術
## フロントエンド
- Vue.js 3.3.4
- Pinia
- vee-validate
- vue-star-rating
- swiper
- axios
- tailwindcss
- prettier-plugin-tailwindcss

## バックエンド
- PHP 8.0.29
- Laravel 9.52.15
- laravel/breeze
- league/flysystem-aws-s3-v3
- nunomaduro/larastan

## フロントエンドとバックエンドの連携
Inertia.js 1.0.11

## インフラ
- AWS
  - VPC
  - EC2
  - RDS  
  MySQL
  - S3
  - IAM
  - Route 53
  - ACM
- Docker

## Webサーバー
NGINX 1.18

## CI/CD
GitHub Actions  
mainブランチにプッシュした際にフロントエンド、バックエンドの自動テストをします。
自動テスト後はEC2インスタンスに自動デプロイします。

## テストフレームワーク
- PHPUnit
- Vitest

# 技術選定
- PHP  
PHPはクラウド、レンタルサーバーでも動作するプログラム言語で、幅広く使用されているので選択しました。 

- Laravel  
PHPフレームワークの中でシェアが高いので選択しました。

- Vue.js  
Laravelとフロントエンドの組み合わせではVue.jsが多いので選択しました。

- Inertia.js  
Laravelと連携するSPAを容易に実装できるので選択しました。

- AWS  
  クラウドの中でシェアが高いので選択しました。

- Docker  
ローカルとクラウドのプログラム実行環境の差分をなくすために選択しました。

# 設計でこだわったポイント
- UI・UX向上のためにSPA、レスポンシブデザインを導入しました。
- ソフトウェア品質向上のためにCI/CDを導入しました。
- フロントエンドではコンポーネント設計にAtomic Designを導入してAtoms、Moleculesを再利用できるようにしました。

# インフラ構成図
<img width="995" alt="インフラ" src="https://user-images.githubusercontent.com/141541659/283321031-194e1abc-a459-4aab-9704-8235b33fa65c.jpg">

# ER図
<img width="995" alt="ER図" src="https://user-images.githubusercontent.com/141541659/283320856-8808dbc5-d136-494e-ab40-730e85bc06ac.png">

# 学習で使用した教材
## 書籍
- PHPフレームワークLaravel入門
- PHPフレームワークLaravel実践開発
- PHP本格入門[上] ~プログラミングとオブジェクト指向の基礎からデータベース連携まで
- PHP本格入門[下] ~オブジェクト指向設計、セキュリティ、現場で使える実践ノウハウまで
- Vue 3　フロントエンド開発の教科書
- 改訂3版JavaScript本格入門　～モダンスタイルによる基礎から現場での応用まで
- 達人に学ぶDB設計 徹底指南書 ～初級者で終わりたくないあなたへ
- SQL 第2版: ゼロからはじめるデータベース操作
- 新しいLinuxの教科書
- リーダブルコード

## 動画(udemy)
- 【Laravel】【Vue.js3】で【CRM(顧客管理システム)】をつくってみよう【Breeze(Inertia)】
- 超Vue.js 2 完全パック (Vue Router, Vuex含む)
- AWS：ゼロから実践するAmazon Web Services。手を動かしながらインフラの基礎を習得