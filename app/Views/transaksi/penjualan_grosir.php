<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Download and Send to WhatsApp</title>
</head>

<body>
    <button id="downloadButton">Download and Send to WhatsApp</button>

    <script>
        document.getElementById('downloadButton').addEventListener('click', function() {
            // Data yang akan diunduh dan dikirim
            const data = "This is the content to be downloaded and sent to WhatsApp.";

            // Membuat elemen <a> untuk mengunduh data
            const downloadLink = document.createElement('a');
            const file = new Blob([data], {
                type: 'text/plain'
            });
            downloadLink.href = URL.createObjectURL(file);
            downloadLink.download = 'data.txt';
            document.body.appendChild(downloadLink);
            downloadLink.click();
            document.body.removeChild(downloadLink);

            // Mengirim pesan ke WhatsApp
            const phoneNumber = '087869187997'; // Ganti dengan nomor telepon tujuan
            const whatsappUrl = `https://api.whatsapp.com/send?phone=${phoneNumber}&text=123`;
            // const whatsappUrl = `https://api.whatsapp.com/send?phone=${phoneNumber}&text=${encodeURIComponent(data)}`;

            // Membuka WhatsApp di tab baru
            window.open(whatsappUrl, '_blank');
        });
    </script>
</body>

</html>
