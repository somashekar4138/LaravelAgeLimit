
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Dashboard</title>
</head>
<body>
    <h1>Hello, {{session('user')}}</h1>
    <h1>Hello, {{session('age')}}</h1>

    <a href="/logout">Logout</a>
    <a href="/list">List</a>
</body>
</html>