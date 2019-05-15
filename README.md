PHP-sheet
--------

Very simplistic cli tool to push json data to a google sheet. The main
purpose is to push artifact data from CI build steps to google sheets in order 
to analyze project quality over time.

### Allow access to a sheet

 1. Create project on [google cloud platform](https://console.developers.google.com/apis/dashboard).
 2. Click Enable APIs and enable the Google Sheets API
 3. Go to Credentials, then click Create credentials, and select Service account key
 4. Choose New service account in the drop down. Give the account a name.
 5. For Role I selected Project -> Project -> Editor
 6. For Key type, choose JSON (the default) and download the file. This file contains a private key so be very careful with it
 7. Finally, edit the sharing permissions for the spreadsheet and give read/write access to the client_email address you can find in the JSON file

[credits to fillup.io](https://www.fillup.io/post/read-and-write-google-sheets-from-php/)

### Install

Download the phar

```bash
$ wget https://github.com/Trekels/php-sheet/releases/download/1.0.0/php-sheet.phar -O php-sheet
```

Make it executable and move to your bin folder.
```bash
$ sudo chmod a+x php-sheet.phar
$ sudo mv php-sheet /usr/local/bin/php-sheet
```

### Push the data.

```bash
bin/phpsheet data ./path/to/file.json -c path/to/creds.json -s sheet_id

# if env vars are set :)
bin/sheet data ./path/to/file.json
```

`--credentials | -c` can be omitted if the credentials json string is set as env var `GOOGLE_SHEET_AUTH`.
`--sheet | -s` can be omitted if env var `GOOGLE_SHEET_ID` is set.
