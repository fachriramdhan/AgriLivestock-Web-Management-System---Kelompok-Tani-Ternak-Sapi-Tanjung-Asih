<nav class="bg-green-700 text-white px-6 py-4 flex justify-between items-center">
    <div class="flex items-center gap-2 text-lg font-semibold">
        <i class="fa-solid fa-cow"></i>
        <span>Kelompok Tani Ternak Tanjung Asih</span>
    </div>

    <div class="flex items-center gap-4">
        <span class="text-sm">
            <i class="fa-solid fa-user"></i>
            <?= htmlspecialchars($_SESSION['username']); ?>
        </span>

        <a href="../auth/logout.php" class="bg-red-600 hover:bg-red-700 px-3 py-1 rounded text-sm">
            <i class="fa-solid fa-right-from-bracket"></i> Logout
        </a>
    </div>
</nav>