<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>No Internet Connection</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: #f8f9fa;
            font-family: sans-serif;
            text-align: center;
            color: #333;
        }
        .box {
            padding: 30px;
            border-radius: 12px;
            background: #f2f2f2;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        h1 {
            font-size: 36px;
            margin-bottom: 15px;
            color: #0B1061 !important;
        }
        p {
            font-size: 18px;
        }
    </style>
</head>
<body>
    <div class="box">
        <h1>😞 No Internet Connection</h1>
        <p>Please check your connection and try again.</p>
    </div>
</body>
</html>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function redirectOffline() {
        if (!navigator.onLine) {
            window.location.href = "{{ route('no_internet') }}";
        }
    }

    window.addEventListener('offline', redirectOffline);
    window.addEventListener('load', redirectOffline);
</script>
