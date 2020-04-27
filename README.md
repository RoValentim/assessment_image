# Prerequisite
- 10.4.12-MariaDB
- PHP 7.4.5 with extensions (eg.: fileInfo, pdo-mysql, php7-mysql)

# Setup
- Edit the file <b>config/database.php</b> and set your database connection information.
- In the main directory of the application, run <b>php -S localhost:8000 public/index.php</b>
- Access via browser or API

# Valid images MIME Type
- image/bmp
- image/gif
- image/jpeg
- image/png

# Commands
Upload an image as base64 or by link
<pre>
curl --location --request POST 'http://localhost:8000/upload-image' \
--header 'Content-Type: application/json' \
--data-raw '{
    "clientId": "client_id",
    "images": [
        {
            "originalName": "image_name",
            "base64": "data:MIME Type;base64,IMAGE_DATA"
        },
        {
            "link": "https://FULL_URL"
        }
    ]
}
'
</pre>

Search an image by name or hash
<pre>
curl --location --request POST 'http://localhost:8000/search-image' \
--header 'Content-Type: application/json' \
--data-raw '{
    "clientId": "client_id",
    "search": "pattern"
}
'
</pre>
