<html>
<head>
    <title>Scraping Website</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
    <h1>Scraping Website</h1>

    <button id="scrapeButton">Scrape Website</button>
    <div id="result">
        <!-- The scraped data will be displayed here -->
        
    </div>

    <script>
        $(document).ready(function() {
            $('#scrapeButton').click(function() {
                $.ajax({
                    url: '/scrape',
                    type: 'GET',
                    success: function(response) {
                        // Display the scraped data
                        var resultHtml = '';
                        $.each(response, function(index, book) {
                            resultHtml += '<p>' + book.book_title + ' --- ' + book.book_author + '</p>';
                        });
                        $('#result').html(resultHtml);
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });
            });
        });
    </script>
</body>
</html>

