# Stampede - Generate Multiple Page PDF from Template SVG, Words Excel and Images

README.md is an automatic translation of README_ja.md.

## Directory structure

	bin/
		create_project.php - Generate project directory
		create_makefile.php - Generate Makefile
		render_svg.php - Rendering SVG
		copy_svg.php - Generate SVG for manual adjustment as copy
		export_pdf.php - Export PDF
		unite_pdf.php - Combining PDFs

	projects/
		(Project directory)/
			input/ - Source file directory
				index.xlsx - Page configuration file
				config.xlsx - Configuration file
				*.svg - Template SVG
				*.xlsx - Words Excel
				*.jpg, *.png, etc. - Images

			work/ - Manual adjustment directory
				*.svg - SVG for manual adjustment

			output/ - Product output directory
				*.svg - Auto-generated SVG
				*.pdf - Auto-generated PDF
				output.pdf - Multiple page PDF

			Makefile - Auto-generated Makefile

## Operating procedure
1. Generate project directory (ex: Planets)  
By the following command:  
```stampede $ bin/create_project.php Planets```  
Source file directory ```stampede/projects/Planets/input/```, Manual adjustment directory ```stampede/projects/Planets/work/```, Product output directory ```stampede/projects/Planets/output/``` and Auto-generated Makefile ```stampede/projects/Planets/Makefile``` is generated.

1. Installation of source files  
Set up Page configuration file, Configuration file, Template SVG, Words Excel, Image in ```stampede/projects/Planets/input```.

1. Running Make  
By the following command:  
```stampede $ cd projects/Planets```  
```stampede/projects/Planets $ make```  
 1. If there is an update in the Page configuration file, the Auto-generated Makefile is regenerated.
 1. If there is an update in the Auto-generated Makefile, Configuration file, Template SVG, Words Excel or Dependent files, the Auto-generated SVG is regenerated.
 1. If there is an update in the Auto-generated SVG, the SVG for manual adjustment is regenerated.
 1. If there is an update in the SVG for manual adjustment, the Auto-generated PDF is regenerated.
 1. If there is an update in the Auto-generated PDF, the Multiple page PDF is regenerated.

1. Automatic execution  
By the following command:  
```stampede $ cd projects/Planets```  
```stampede/projects/Planets $ ./daemon.sh```  
Update of the source file directory is monitored, and make is automatically executed.
