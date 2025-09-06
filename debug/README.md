# Fillable PDFs Debug Notes

## Inspected code
- `forgravity-fillablepdfs/includes/class-generator.php`
- `forgravity-fillablepdfs/includes/generator/field/class-base.php`
- `forgravity-fillablepdfs/includes/generator/field/class-fileupload.php`

## Sample logs
```
[FGFPDF] field=pet_photo mapperType=fileupload pdfFT=/Tx ff=0 file=/path/to/upload.jpg exists=1 readable=1 mime=image/jpeg size=12345 gd=1 imagick=0
[FGFPDF] field=pet_photo mapperType=fileupload pdfFT=/Btn ff=65536 file=/path/to/upload.jpg exists=1 readable=1 mime=image/jpeg size=12345 gd=1 imagick=0
```

First line shows failing field where `/FT` is `Tx` and push-button flag is missing. Second line is from working template with `/FT=Btn` and flag `65536`.

## Root cause
Production template fields are text fields (`/FT=Tx`) instead of push-button fields. Fillable PDFs only embeds images into push-button fields with the push-bit (65536) set.

## Proposed fix
Recreate the affected PDF fields as push-button fields (Icon Only) so they report `/FT=Btn` with flag `65536`.
