<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Example</title>
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body>
    <div class="addContainer">
        <form id="contact_form" method="get">
            <p>
                <label for="name">选手编号：</label><input type="text" id="name" name="name">
            </p>
            <p>
                <label for="email">节点：</label><input type="email" id="email" name="email">
            </p>
            <p>
                <label for="email">子节点：</label><input type="email" id="email" name="email">
            </p>
            <input type="submit" id="submit" value="发送">
        </form>
    </div>
<script>

</script>
</body>
</html>

