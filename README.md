# wp_theme-demo_site_design_restaurant

`wp_theme-demo_site_design_restaurant` は、レストラン向けデモサイトを想定した **WordPress テーマ** です。  
トップページ、アーカイブ、個別ページなどのテンプレートを含み、フロントエンド資産のビルドには Node.js ベースのツールを利用します。

<img alt="image" src="https://github.com/canvas-sapporo/wp_theme-demo_site_design_restaurant/blob/main/README.gif" />

## 前提環境

- WordPress が動作するローカル環境（例: Local）（
- PHP / MySQL が WordPress 要件を満たしていること
- Node.js / npm（フロントエンド資産をビルドする場合）

## インストール / 有効化

1. このテーマディレクトリを以下に配置
   - `wp-content/themes/wp_theme-demo_site_design_restaurant`
2. WordPress 管理画面にログイン
3. `外観 > テーマ` から `wp_theme-demo_site_design_restaurant` を有効化
4. `外観 > カスタマイズ` で以下を設定する
   - サイト基本情報：サイトのタイトル（店名）
   - フロントページ（ヒーロー）：ホーム画像・コンセプト
   - フロントページ（About・Gallery）
     - About：見出し・本文・画像
     - Gallery：見出し・サブテキスト・画像
   - フッター：住所・電話番号・メールアドレス・営業時間
   - メニューページ：画像・見出し・補足文・メニュー末尾の注記
   - 配色
5. `固定ページ` を以下の内容で2つ作成する
   - トップ用
     - タイトル：Home
     - 本文：空でOK。（テーマの front-page.php が表示するため）
     - 公開する
   - ブログ一覧用
     - タイトル：Blog
     - スラグ：blog（パーマリンク設定で「投稿名」などにしている前提。編集画面の右側でスラッグを変更）
     - 本文：空でOK。
     - 公開する
6. `設定 > 表示設定` で以下を設定する
   - ホームページの表示：「固定ページ」
   - ホームページ：Home
   - 投稿ページ：Blog
7. `レストランメニュー` で料理のメニューを設定する
8. `投稿` でブログの記事を追加する

## 開発時の使い方

テーマ直下で実行します。

```bash
npm install
npm run dev
```

本番向けビルド:

```bash
npm run build
```

ビルド済みファイルは `dist` 配下に出力されます（設定は `vite.config.ts` を参照）。

## 主なファイル構成

- `functions.php` : テーマ機能の定義、各種フック
- `front-page.php` : フロントページテンプレート
- `archive-menu_item.php` : メニュー投稿タイプのアーカイブ
- `single-menu_item.php` : メニュー投稿タイプの詳細
- `template-parts/` : 部分テンプレート
- `src/` : フロントエンド開発用ソース
- `dist/` : ビルド成果物

## カスタマイズの基本方針

- テンプレート編集時は、共通化できるパーツを `template-parts/` に切り出す
- スタイルやスクリプトは `src/` 側で管理し、`npm run build` で反映する
- WordPress のテンプレート階層に沿ってファイルを追加・調整する

## トラブルシューティング

### テーマが管理画面に表示されない

- テーマディレクトリ名が正しいか確認
- `style.css` のテーマヘッダー情報が有効か確認
- 配置先が `wp-content/themes/` 配下になっているか確認

### CSS / JS が反映されない

- `npm run build` を実行したか確認
- `dist/` が生成されているか確認
- ブラウザキャッシュを削除して再読み込み
- `functions.php` のアセット読み込みパスを確認

### レイアウトが崩れる / テンプレートが意図通りに切り替わらない

- 対象ページのテンプレート階層が正しいか確認
- カスタム投稿タイプ（例: `menu_item`）のスラッグ・登録内容を確認
- パーマリンク設定を保存し直してリライトルールを再生成

### npm コマンドが失敗する

- Node.js と npm のバージョンを確認
- 依存関係を再インストール（`node_modules` 削除後に `npm install`）
- `package-lock.json` と `package.json` の整合性を確認

## 補足

- この README は開発者向けの概要ドキュメントです。
- 実装が変わった場合は、運用しやすいように随時更新してください。
