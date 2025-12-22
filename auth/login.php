<?php
session_start();
if (isset($_SESSION['login'])) {
    header("Location: ../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login - Sistem Kelompok Tani</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md">
        <h2 class="text-2xl font-bold text-center mb-6">
            <i class="fa-solid fa-cow"></i> Login Sistem
        </h2>

        <?php if (isset($_GET['error'])) : ?>
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm">
            <?= htmlspecialchars($_GET['error']); ?>
        </div>
        <?php endif; ?>

        <form action="login_process.php" method="POST" class="space-y-4">
            <div>
                <label class="block text-sm font-medium">Username</label>
                <input type="text" name="username" required
                    class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring">
            </div>

            <div>
                <label class="block text-sm font-medium">Password</label>
                <input type="password" name="password" required
                    class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring">
            </div>

            <button type="submit" class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700">
                <i class="fa-solid fa-right-to-bracket"></i> Login
            </button>
        </form>
    </div>

</body>

</html>