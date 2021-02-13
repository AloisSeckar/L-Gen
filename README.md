# L-Gen
 Simple watermark generator

## Features
Inserts `stamp.png` image into given input (JPG or PNG). The logo appears as square in bottom right corner scaled to 1/8 of input image height. Processed image is stored as `tmp/output.png` and displayed on the page. Output is not persistent, next run of the script overwrites it.

## Usage
Just deploy it on any PHP server and display `lgen.php`.

## Possible development
* persisting output images
* selecting logo source, location and dimensions (currently hardcoded)
* allowing other input formats (currently only JPG and PNG)
* translations