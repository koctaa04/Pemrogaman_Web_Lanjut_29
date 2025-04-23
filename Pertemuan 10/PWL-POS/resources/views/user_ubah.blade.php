<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Form Ubah Data User</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

</head>

<body>
    <h1>Form Ubah Data User</h1>
    <form action="/user/ubah_simpan/{{ $user->user_id }}" method="post">
        {{ csrf_field() }}
        {{ method_field('put') }}
        <label for="username">Username</label>
        <input type="text" name="username" id="username" placeholder="Masukkan username" value="{{ $user->username }}"> <br>
        <label for="nama">Nama</label>
        <input type="text" name="nama" id="nama" placeholder="Masukkan Nama" value="{{ $user->nama }}"> <br>
        <label for="password">Password</label>
        <input type="password" name="password" id="password" placeholder="Masukkan Password" value="{{ $user->password }}"> <br>
        <label for="level_id">Level ID</label>
        <input type="number" name="level_id" id="level_id" placeholder="Masukkan ID Level" value="{{ $user->level_id }}"> <br>
        <input type="submit" class="btn btn-success" value="Simpan" name="" id="">
    </form>
</body>

</html>
