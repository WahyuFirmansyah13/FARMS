<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= (isset($title) ? esc($title) . ' - ' : '') ?>FARMS 2.0</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="<?= base_url('css/custom.css?v=4.0') ?>">
    <script>
        const BASE_URL = '<?= base_url('/') ?>';
    </script>
</head>
<body class="<?= (isset($_COOKIE['farms_theme']) && $_COOKIE['farms_theme'] == 'dark') ? 'dark-mode' : '' ?>">
    <div class="d-flex">
        <?= $this->include('layout/sidebar') ?>
        <div class="page-container flex-grow-1">
            <?= $this->include('layout/topbar') ?>
            <main class="main-content">
