<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Hướng dẫn jQuery Ajax - Thienanblog.com</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>
<body>
<div>
    <a href="#" id="load-du-lieu">Load dữ liệu</a>
</div>
<div id="noidung">
    <div>
        abcdef
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#load-du-lieu').click(function(e) {
            e.preventDefault();
            $.get('vidu',function (data,status) {
                $('#noidung').html(data);
                $('#noidung').html($('#chuoi-can-lay').html());
            });
        });
    });
</script>
</body>
</html>
