# Atopic labo
皮膚病・敏感肌で悩んでいるユーザー同士で「お肌にやさしいコスメ・化粧品」情報を共有し、悩みを解決するサービスです。  
サービスURL: https://atopic-labo.xyz<br>
 <img width="1400" alt="メインビジュアル" src="https://private-user-images.githubusercontent.com/141541659/281056233-2af7e67b-8f0a-4eb7-a39e-e0eb24c78028.jpg?jwt=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJnaXRodWIuY29tIiwiYXVkIjoicmF3LmdpdGh1YnVzZXJjb250ZW50LmNvbSIsImtleSI6ImtleTEiLCJleHAiOjE2OTkzNjY1NDcsIm5iZiI6MTY5OTM2NjI0NywicGF0aCI6Ii8xNDE1NDE2NTkvMjgxMDU2MjMzLTJhZjdlNjdiLThmMGEtNGViNy1hMzllLWUwZWIyNGM3ODAyOC5qcGc_WC1BbXotQWxnb3JpdGhtPUFXUzQtSE1BQy1TSEEyNTYmWC1BbXotQ3JlZGVudGlhbD1BS0lBSVdOSllBWDRDU1ZFSDUzQSUyRjIwMjMxMTA3JTJGdXMtZWFzdC0xJTJGczMlMkZhd3M0X3JlcXVlc3QmWC1BbXotRGF0ZT0yMDIzMTEwN1QxNDEwNDdaJlgtQW16LUV4cGlyZXM9MzAwJlgtQW16LVNpZ25hdHVyZT0yNzZhNjMyYzYxMmNhMGE5MzVhYTVmYWFjMDM0ZDc3YmIxNmRiY2Y5ZTFmMmVkMDgwOTlmNjYyMWRmMThkN2FhJlgtQW16LVNpZ25lZEhlYWRlcnM9aG9zdCZhY3Rvcl9pZD0wJmtleV9pZD0wJnJlcG9faWQ9MCJ9.Dn6BqwA1T13vaVC78gHjKs3iyEOtLdKnwHbyurltkrg">
 <img width="1002" height="546" alt="インデックスページ" src= "https://private-user-images.githubusercontent.com/141541659/281057272-a56a4870-91d9-4e3c-be02-ca4344e2beda.jpg?jwt=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJnaXRodWIuY29tIiwiYXVkIjoicmF3LmdpdGh1YnVzZXJjb250ZW50LmNvbSIsImtleSI6ImtleTEiLCJleHAiOjE2OTkzNjY1ODgsIm5iZiI6MTY5OTM2NjI4OCwicGF0aCI6Ii8xNDE1NDE2NTkvMjgxMDU3MjcyLWE1NmE0ODcwLTkxZDktNGUzYy1iZTAyLWNhNDM0NGUyYmVkYS5qcGc_WC1BbXotQWxnb3JpdGhtPUFXUzQtSE1BQy1TSEEyNTYmWC1BbXotQ3JlZGVudGlhbD1BS0lBSVdOSllBWDRDU1ZFSDUzQSUyRjIwMjMxMTA3JTJGdXMtZWFzdC0xJTJGczMlMkZhd3M0X3JlcXVlc3QmWC1BbXotRGF0ZT0yMDIzMTEwN1QxNDExMjhaJlgtQW16LUV4cGlyZXM9MzAwJlgtQW16LVNpZ25hdHVyZT0wYWQzMGE0ODUzNWJiODk2NDE1MzY3ZmNiYTZkYWQ4N2Y1NDRhZDgyNDVmMTlkY2E2ZjQ2MjFkYzdiYWYwOThlJlgtQW16LVNpZ25lZEhlYWRlcnM9aG9zdCZhY3Rvcl9pZD0wJmtleV9pZD0wJnJlcG9faWQ9MCJ9.n1lLp7cXLEYmsLUBvkeT417188RP4bPi7D4y4n2c1P8">

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
<img width="995" alt="インフラ" src="https://private-user-images.githubusercontent.com/141541659/281057653-b55ba36c-aabc-400e-bd1c-c7f5a904e23a.jpg?jwt=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJnaXRodWIuY29tIiwiYXVkIjoicmF3LmdpdGh1YnVzZXJjb250ZW50LmNvbSIsImtleSI6ImtleTEiLCJleHAiOjE2OTkzNjY2NTMsIm5iZiI6MTY5OTM2NjM1MywicGF0aCI6Ii8xNDE1NDE2NTkvMjgxMDU3NjUzLWI1NWJhMzZjLWFhYmMtNDAwZS1iZDFjLWM3ZjVhOTA0ZTIzYS5qcGc_WC1BbXotQWxnb3JpdGhtPUFXUzQtSE1BQy1TSEEyNTYmWC1BbXotQ3JlZGVudGlhbD1BS0lBSVdOSllBWDRDU1ZFSDUzQSUyRjIwMjMxMTA3JTJGdXMtZWFzdC0xJTJGczMlMkZhd3M0X3JlcXVlc3QmWC1BbXotRGF0ZT0yMDIzMTEwN1QxNDEyMzNaJlgtQW16LUV4cGlyZXM9MzAwJlgtQW16LVNpZ25hdHVyZT00MzIxOTUwYTQ2ZmIxODRlYzE1NTgzNTNjMjA4NTdjMmQ1NTc0NDRlMTMxNzgyZjJjODliMDNlMjRjNWU0NTZkJlgtQW16LVNpZ25lZEhlYWRlcnM9aG9zdCZhY3Rvcl9pZD0wJmtleV9pZD0wJnJlcG9faWQ9MCJ9.IHFLv2hkK6-KPZKmKXj2L_AnUb_UZTsxRfbKAW8EEjU">

# ER図
<img width="995" alt="ER図" src="https://private-user-images.githubusercontent.com/141541659/281062053-488b9e00-3ba6-4a43-b4af-8a791a4ce419.png?jwt=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJnaXRodWIuY29tIiwiYXVkIjoicmF3LmdpdGh1YnVzZXJjb250ZW50LmNvbSIsImtleSI6ImtleTEiLCJleHAiOjE2OTkzNjY2NjksIm5iZiI6MTY5OTM2NjM2OSwicGF0aCI6Ii8xNDE1NDE2NTkvMjgxMDYyMDUzLTQ4OGI5ZTAwLTNiYTYtNGE0My1iNGFmLThhNzkxYTRjZTQxOS5wbmc_WC1BbXotQWxnb3JpdGhtPUFXUzQtSE1BQy1TSEEyNTYmWC1BbXotQ3JlZGVudGlhbD1BS0lBSVdOSllBWDRDU1ZFSDUzQSUyRjIwMjMxMTA3JTJGdXMtZWFzdC0xJTJGczMlMkZhd3M0X3JlcXVlc3QmWC1BbXotRGF0ZT0yMDIzMTEwN1QxNDEyNDlaJlgtQW16LUV4cGlyZXM9MzAwJlgtQW16LVNpZ25hdHVyZT04Zjg4NTg5YWM5OWRkZDAzYzE2ZGZkOWZlZjIyYjMzMzg5NzhhNjgxOWI2NDg3NzE2Y2U5OTMyMjk1MzVkNDQ3JlgtQW16LVNpZ25lZEhlYWRlcnM9aG9zdCZhY3Rvcl9pZD0wJmtleV9pZD0wJnJlcG9faWQ9MCJ9.luigtKrqcE4VdZdN_jNHTmxaEAM1Sw30qwvdybkkqrM">
