<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OCR Image Upload</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 50px;
        }
        #preview {
            margin-top: 20px;
            max-width: 300px;
        }
    </style>
</head>
<body>
    <h2>Upload Image for OCR</h2>
    
    <form id="ocrForm">
        <input type="file" name="image" id="image" accept="image/*" required>
        <button type="submit">Upload & Extract Text</button>
    </form>

    <img id="preview" style="display: none;">
    
    <h3>Extracted Text:</h3>
    <pre id="extractedText"></pre>

    <script>
        $(document).ready(function () {
            $("#image").change(function () {
                let reader = new FileReader();
                reader.onload = function (e) {
                    $("#preview").attr("src", e.target.result).show();
                };
                reader.readAsDataURL(this.files[0]);
            });

            $("#ocrForm").submit(function (e) {
                e.preventDefault();
                
                let formData = new FormData();
                formData.append("image", $("#image")[0].files[0]);
                $.ajax({
                    url: "/ocr",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function () {
                        $("#extractedText").text("Processing...");
                    },
                    success: function (response) {
                        $("#extractedText").text(response.extracted_text);
                    },
                    error: function () {
                        $("#extractedText").text("Error processing image!");
                    }
                });
            });
        });
    </script>
</body>

</html>
