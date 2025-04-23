<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Form Tambah Data User</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

</head>

<body>
    <h1>Form Tambah Data User</h1>
    <form action="/user/tambah_simpan" method="post">
        {{ csrf_field() }}
        <label for="username">Username</label>
        <input type="text" name="username" id="username" placeholder="Masukkan username"> <br>
        <label for="nama">Nama</label>
        <input type="text" name="nama" id="nama" placeholder="Masukkan Nama"> <br>
        <label for="password">Password</label>
        <input type="password" name="password" id="password" placeholder="Masukkan Password"> <br>
        <label for="level_id">Level ID</label>
        <input type="number" name="level_id" id="level_id" placeholder="Masukkan ID Level"><br>
        <input type="submit" class="btn btn-success" value="Simpan" name="" id="">
    </form>
</body>

</html>
