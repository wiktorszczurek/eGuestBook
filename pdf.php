<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Download PDF</title>
    <script src="https://rawgit.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <button id="download-pdf">Pobierz zawartość view.php jako PDF</button>
    
    <script>
        $('#download-pdf').click(function(e) {
            e.preventDefault();
            var serverId = '<?php echo $_GET['id']; ?>'; // pobiera id serwera z parametrów URL
            $.get('view.php?id=' + serverId, function(data) {
                var element = $(data).find('body')[0]; // znajduje element body w pobranej zawartości
                html2pdf(element);
            });
        });
    </script>
</body>
</html>
