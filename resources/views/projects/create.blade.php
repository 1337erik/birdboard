<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h3>Create a Project</h3>

    <form method="POST" action="/projects">
        @csrf

        <input name="title" type="text" />
        <input name="description" type="text" />

        <button type="submit">Hello</button>
    </form>
</body>
</html>