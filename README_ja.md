# Stampede - 複数ページPDFを、テンプレートSVG、文言Excel、画像から生成する

README.mdはREADME_ja.mdの自動翻訳です。

## ディレクトリ構成

	bin/
		create_project.php - プロジェクトディレクトリの生成
		create_makefile.php - Makefileの生成
		render_svg.php - SVGのレンダリング
		copy_svg.php - コピーとして手動調整用SVGの生成
		export_pdf.php - PDFのエクスポート
		unite_pdf.php - PDFの結合

	projects/
		(プロジェクトディレクトリ)/
			input/ - ソースファイルディレクトリ
				index.xlsx - ページ構成ファイル
				config.xlsx - 設定ファイル
				*.svg - テンプレートSVG
				*.xlsx - 文言Excel
				*.jpg, *.png, etc. - 画像

			work/ - 手動調整用ディレクトリ
				*.svg - 手動調整用SVG

			output/ - 成果物出力ディレクトリ
				*.svg - 自動生成SVG
				*.pdf - 自動生成PDF
				output.pdf - 複数ページPDF

			Makefile - 自動生成Makefile

## 操作手順
1. プロジェクトディレクトリ(例:Planets)を生成  
次のコマンドによって:  
```stampede $ bin/create_project.php Planets```  
ソースファイルディレクトリ ```stampede/projects/Planets/input/```、手動調整用ディレクトリ ```stampede/projects/Planets/work/```、成果物出力ディレクトリ ```stampede/projects/Planets/output/```、自動生成Makefile ```stampede/projects/Planets/Makefile``` が生成される。

1. ソースファイルの設置  
```stampede/projects/Planets/input```にページ構成ファイル、設定ファイル、テンプレートSVG、文言Excel、画像を設置する。

1. makeの実行  
次のコマンドによって:  
```stampede $ cd projects/Planets```  
```stampede/projects/Planets $ make```  

 1. ページ構成ファイルに更新があれば、自動生成Makefileが再生成される。
 1. 自動生成Makefile、設定ファイル、テンプレートSVG、文言Excel、依存ファイルに更新があれば、自動生成SVGが再生成される。
 1. 自動生成SVGに更新があれば、手動調整用SVGが再生成される。
 1. 手動調整用SVGに更新があれば、自動生成PDFが再生成される。
 1. 自動生成PDFに更新があれば、複数ページPDFが再生成される。

1. 自動実行 
次のコマンドによって:  
```stampede $ cd projects/Planets```  
```stampede/projects/Planets $ ./daemon.sh```  
ソースファイルディレクトリの更新が監視され、自動的にmakeの実行が行われます。
