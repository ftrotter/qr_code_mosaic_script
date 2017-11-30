# qr_code_mosaic_script
this is a php script that calls imagemagick a few times to create a QR code mosaic with any other picture

It is very simple to use. 

First, you need an image. Anything will do.

Then create the QR code you want to overlay, with full black and white contrast. I like qrcode monkey https://www.qrcode-monkey.com/, because it lets you make off-kilter shapes that still scan..

Then you install imagemagick https://www.imagemagick.org/
Use your package management system for this (i.e. use brew for OSX) https://brew.sh/ Or yum for RedHat or apt-get for Ubuntu, etc. You must have the convert and composite commands working from the command line for this to work...

Then run this command from the prompt

```
>php make_qr_code_mosaic.php your_qr_code_file.png your_image_file.jpg output_file_name.png
```

obviously replace 'your_qr_code_file.png' with the name of your qr code. 
replace 'your_image_file.jpg' with your image file... 
and change 'output_file_name.png' to the name of the file that you want to be newly created...

The php script will call a sequence of imagemagick convert and composite commands that will create a QR code mosaic. 

Enjoy.

-FT
