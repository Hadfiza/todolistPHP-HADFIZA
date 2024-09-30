<?php
session_start();

// Inisialisasi array tugas jika belum ada
if (!isset($_SESSION['tugas'])) {
    $_SESSION['tugas'] = [];
}

// Fungsi untuk menambah task
if (isset($_POST['action']) && $_POST['action'] === 'add') {
    $id = count($_SESSION['tugas']) + 1;
    $judul = $_POST['judul'];
    $prioritas = $_POST['prioritas'];
    $_SESSION['tugas'][$id] = ['id' => $id, 'judul' => $judul, 'prioritas' => $prioritas];
    header('Location: task_manager.php');
    exit();
}

// Fungsi untuk mengupdate task
if (isset($_POST['action']) && $_POST['action'] === 'edit') {
    $id = $_POST['id'];
    $judul = $_POST['judul'];
    $prioritas = $_POST['prioritas'];
    $_SESSION['tugas'][$id] = ['id' => $id, 'judul' => $judul, 'prioritas' => $prioritas];
    header('Location: task_manager.php');
    exit();
}

// Fungsi untuk menghapus task
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    unset($_SESSION['tugas'][$id]);
    header('Location: task_manager.php');
    exit();
}

// Mendapatkan task berdasarkan ID untuk proses edit
$taskToEdit = null;
if (isset($_GET['edit'])) {
    $taskToEdit = $_SESSION['tugas'][$_GET['edit']];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Task Manager Sederhana</title>
    <link rel="stylesheet" href="styles.css">

</head>
<body>
    <div class="container">
    <h2>Daftar Tugas</h2>
    <br>
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Tugas</th>
            <th>Prioritas</th>
            <th>Aksi</th>
        </tr>
        <?php foreach ($_SESSION['tugas'] as $task): ?>
        <tr>
            <td><?php echo $task['id']; ?></td>
            <td><?php echo $task['judul']; ?></td>
            <td><?php echo $task['prioritas']; ?></td>
            <td>
                <a href="task_manager.php?edit=<?php echo $task['id']; ?>">Edit</a> |
                <a href="task_manager.php?delete=<?php echo $task['id']; ?>">Hapus</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    </div>

    <div class="conten2">
    <h2><?php echo $taskToEdit ? 'Edit Task' : 'Tambah Task'; ?></h2>
    <form method="POST">
        <input type="hidden" name="id" value="<?php echo $taskToEdit['id'] ?? ''; ?>">
        <label for="title">Task:</label>
        <input type="text" name="judul" id="judul" value="<?php echo $taskToEdit['judul'] ?? ''; ?>" required>
        <br><br>
        <label for="prioritas">Prioritas:</label>
        <input type="text" name="prioritas" id="prioritas" value="<?php echo $taskToEdit['prioritas'] ?? ''; ?>" required>
        <br><br>
        <input type="hidden" name="action" value="<?php echo $taskToEdit ? 'edit' : 'add'; ?>">
        <button type="submit"><?php echo $taskToEdit ? 'Update' : 'Tambah'; ?></button>
    </form>
    </div>
</body>
</html>
