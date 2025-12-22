<?php $base = '/ternak-tanjung-asih'; ?>
<aside class="w-64 bg-white shadow min-h-screen">
    <ul class="p-4 space-y-2 text-sm">

        <li>
            <a href="<?= $base ?>/admin/dashboard.php" class="flex items-center gap-2 p-2 rounded hover:bg-green-100">
                <i class="fa-solid fa-chart-line"></i> Dashboard
            </a>
        </li>

        <?php if ($_SESSION['role'] == 'admin') : ?>

        <li class="font-semibold text-gray-500 mt-4">MASTER DATA</li>

        <li>
            <a href="<?= $base ?>/admin/anggota.php" class="menu-item">
                <i class="fa-solid fa-users"></i> Data Anggota
            </a>
        </li>

        <li>
            <a href="user.php" class="menu-item">
                <i class="fa-solid fa-user-gear"></i> Data User
            </a>
        </li>

        <li class="font-semibold text-gray-500 mt-4">PETERNAKAN</li>

        <li>
            <a href="<?= $base ?>/sapi/index.php" class="menu-item">
                <i class="fa-solid fa-cow"></i> Data Sapi
            </a>
        </li>

        <li>
            <a href="<?= $base ?>/produksi_susu/index.php" class="menu-item">
                <i class="fa-solid fa-mug-hot"></i> Produksi Susu
            </a>

        </li>

        <li>
            <a href="<?= $base ?>/pakan/index.php" class="menu-item">
                <i class="fa-solid fa-wheat-awn"></i> Pakan Sapi
            </a>
        </li>

        <li>
            <a href="<?= $base ?>/kesehatan/index.php" class="menu-item">
                <i class="fa-solid fa-notes-medical"></i> Kesehatan Sapi
            </a>
        </li>

        <li>
            <a href="<?= $base ?>/olahan/index.php" class="menu-item">
                <i class="fa-solid fa-industry"></i> Produksi Olahan
            </a>
        </li>

        <li>
            <a href="<?= $base ?>/jadwal/index.php" class="menu-item">
                <i class="fa-solid fa-calendar-days"></i> Jadwal Kegiatan
            </a>
        </li>

        <li>
            <a href="<?= $base ?>/laporan/index.php" class="menu-item">
                <i class="fa-solid fa-file-lines"></i> Laporan
            </a>
        </li>

        <?php else : ?>

        <li class="font-semibold text-gray-500 mt-4">MENU PETERNAK</li>

        <li>
            <a href="<?= $base ?>/sapi/index.php" class="menu-item">
                <i class="fa-solid fa-cow"></i> Data Sapi Saya
            </a>
        </li>

        <li>
            <a href="<?= $base ?>/produksi_susu/index.php" class="menu-item">
                <i class="fa-solid fa-mug-hot"></i> Input Produksi Susu
            </a>
        </li>

        <li>
            <a href="input_pakan.php" class="menu-item">
                <i class="fa-solid fa-wheat-awn"></i> Input Pakan
            </a>
        </li>

        <li>
            <a href="input_kesehatan.php" class="menu-item">
                <i class="fa-solid fa-notes-medical"></i> Input Kesehatan
            </a>
        </li>

        <li>
            <a href="jadwal.php" class="menu-item">
                <i class="fa-solid fa-calendar-days"></i> Jadwal Kegiatan
            </a>
        </li>

        <li>
            <a href="laporan_saya.php" class="menu-item">
                <i class="fa-solid fa-file-lines"></i> Laporan Saya
            </a>
        </li>

        <?php endif; ?>

    </ul>
</aside>

<style>
.menu-item {
    display: flex;
    gap: 8px;
    padding: 8px;
    border-radius: 6px;
}

.menu-item:hover {
    background-color: #dcfce7;
}
</style>