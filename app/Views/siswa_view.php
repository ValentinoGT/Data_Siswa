<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa RPL</title>

    <!-- CDN CSS Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?= base_url('siswa.css') ?>">
</head>
<body>
    <nav class="navbar app-navbar">
        <div class="container">
            <a class="navbar-brand" href="<?= site_url('siswa') ?>">DATA SISWA XI RPL</a>
            <div class="admin-profile" aria-label="Pengguna aktif: RPL Admin">
                <span class="admin-avatar" aria-hidden="true">R</span>
                <span>RPL ADMIN</span>
            </div>
        </div>
    </nav>

    <main class="container page-container">
        <div class="page-heading">
            <div>
                <h1>Daftar Siswa Terdaftar</h1>
                <p>Kelola data master siswa kelas XI Rekayasa Perangkat Lunak.</p>
            </div>
            <button type="button" class="btn btn-primary add-student-button"
                    data-bs-toggle="modal" data-bs-target="#modalTambah">
                <i class="bi bi-plus-lg" aria-hidden="true"></i>
                <span>Tambah Siswa Baru</span>
            </button>
        </div>

        <section class="card dashboard-card" aria-label="Data siswa">
            <div class="table-toolbar">
                <div class="search-control">
                    <i class="bi bi-search" aria-hidden="true"></i>
                    <input type="search" class="form-control" id="studentSearch"
                           placeholder="Cari berdasarkan Nama atau NIS..."
                           aria-label="Cari berdasarkan nama atau NIS">
                </div>
                <div class="filter-controls">
                    <label class="visually-hidden" for="sortColumnSelect">Urutkan data</label>
                    <select id="sortColumnSelect" class="form-select" aria-label="Urutkan data">
                        <option value="nama-asc">Urutkan Data: A - Z</option>
                        <option value="nama-desc">Urutkan Data: Z - A</option>
                        <option value="nis-asc">NIS Terkecil</option>
                        <option value="nis-desc">NIS Terbesar</option>
                    </select>
                    <label class="filter-label" for="genderFilter">Jenis Kelamin</label>
                    <select id="genderFilter" class="form-select" aria-label="Filter jenis kelamin">
                        <option value="">Semua</option>
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table align-middle" id="siswaTable">
                    <thead>
                        <tr>
                            <th scope="col" class="text-center">No</th>
                            <th scope="col" class="text-center">NIS</th>
                            <th scope="col">Nama Lengkap</th>
                            <th scope="col">Jenis Kelamin</th>
                            <th scope="col">Kelas</th>
                            <th scope="col" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="siswaTableBody">
                        <?php if (!empty($siswa)): ?>
                            <?php foreach ($siswa as $row): ?>
                                <?php
                                $nameParts = preg_split('/\s+/', trim((string) $row['nama']), -1, PREG_SPLIT_NO_EMPTY);
                                $initials = '';
                                foreach (array_slice($nameParts ?: [], 0, 2) as $part) {
                                    $initials .= strtoupper(substr($part, 0, 1));
                                }
                                $gender = strtoupper((string) ($row['jenis_kelamin'] ?? ''));
                                ?>
                                <tr class="siswa-row" data-gender="<?= esc($gender) ?>">
                                    <td class="row-number text-center"></td>
                                    <td class="nis-cell text-center"><?= esc($row['nis']) ?></td>
                                    <td>
                                        <div class="student-name">
                                            <span class="student-avatar avatar-color-<?= (int) $row['id'] % 5 ?>"
                                                  aria-hidden="true"><?= esc($initials) ?></span>
                                            <span><?= esc($row['nama']) ?></span>
                                        </div>
                                    </td>
                                    <td>
                                        <?php if ($gender === 'L' || $gender === 'LAKI-LAKI'): ?>
                                            <span class="gender-badge gender-male">Laki-laki</span>
                                        <?php elseif ($gender === 'P' || $gender === 'PEREMPUAN'): ?>
                                            <span class="gender-badge gender-female">Perempuan</span>
                                        <?php else: ?>
                                            <span class="gender-unavailable" title="Belum tersedia pada data siswa">—</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><span class="class-badge"><?= esc($row['kelas']) ?></span></td>
                                    <td class="text-center action-cell">
                                        <button type="button" class="btn btn-warning btn-icon"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalEdit<?= (int) $row['id'] ?>"
                                                aria-label="Edit data <?= esc($row['nama']) ?>"
                                                title="Edit">
                                            <i class="bi bi-pencil-fill" aria-hidden="true"></i>
                                        </button>
                                        <form action="<?= site_url('siswa/hapus/' . (int) $row['id']) ?>"
                                              method="post" class="d-inline"
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus data siswa ini?')">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-danger btn-icon"
                                                    aria-label="Hapus data <?= esc($row['nama']) ?>"
                                                    title="Hapus">
                                                <i class="bi bi-trash-fill" aria-hidden="true"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <tr id="emptySiswaMessage" <?= !empty($siswa) ? 'hidden' : '' ?>>
                            <td colspan="6" class="empty-state">Tidak ada data siswa yang cocok.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="table-footer">
                <span id="tableStatus" aria-live="polite"></span>
                <nav aria-label="Navigasi halaman data siswa">
                    <ul class="pagination mb-0" id="siswaPagination"></ul>
                </nav>
            </div>
        </section>
    </main>

    <?php
    $successMessage = session()->getFlashdata('success');
    $errorMessage = session()->getFlashdata('error');
    ?>

    <?php
    $editErrors = session()->getFlashdata('edit_errors') ?? [];
    $editId = session()->getFlashdata('edit_id');
    $editInput = session()->getFlashdata('edit_input') ?? [];
    ?>
    <?php foreach (($siswa ?? []) as $row): ?>
        <div class="modal fade" id="modalEdit<?= (int) $row['id'] ?>" tabindex="-1"
             aria-labelledby="modalEditLabel<?= (int) $row['id'] ?>" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-warning text-white">
                        <h5 class="modal-title" id="modalEditLabel<?= (int) $row['id'] ?>">
                            Edit Data Siswa
                        </h5>
                        <button type="button" class="btn-close btn-close-white"
                                data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="formEdit<?= (int) $row['id'] ?>"
                          action="<?= site_url('siswa/edit/' . (int) $row['id']) ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="modal-body">
                            <?php if ((int) $editId === (int) $row['id'] && $editErrors): ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php foreach ($editErrors as $error): ?>
                                        <div><?= esc($error) ?></div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            <div class="mb-3">
                                <label for="nis<?= (int) $row['id'] ?>" class="form-label">NIS</label>
                                <input type="text" class="form-control" id="nis<?= (int) $row['id'] ?>"
                                       name="nis"
                                       value="<?= esc((int) $editId === (int) $row['id'] ? ($editInput['nis'] ?? $row['nis']) : $row['nis']) ?>"
                                       required>
                            </div>
                            <div class="mb-3">
                                <label for="nama<?= (int) $row['id'] ?>" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="nama<?= (int) $row['id'] ?>"
                                       name="nama"
                                       value="<?= esc((int) $editId === (int) $row['id'] ? ($editInput['nama'] ?? $row['nama']) : $row['nama']) ?>"
                                       required>
                            </div>
                            <?php
                            $editGender = (int) $editId === (int) $row['id']
                                ? ($editInput['jenis_kelamin'] ?? ($row['jenis_kelamin'] ?? ''))
                                : ($row['jenis_kelamin'] ?? '');
                            ?>
                            <div class="mb-3">
                                <label for="jenis_kelamin<?= (int) $row['id'] ?>" class="form-label">Jenis Kelamin</label>
                                <select class="form-select" id="jenis_kelamin<?= (int) $row['id'] ?>"
                                        name="jenis_kelamin" required>
                                    <option value="" disabled <?= $editGender === '' ? 'selected' : '' ?>>Pilih jenis kelamin</option>
                                    <option value="L" <?= in_array(strtoupper((string) $editGender), ['L', 'LAKI-LAKI'], true) ? 'selected' : '' ?>>Laki-laki</option>
                                    <option value="P" <?= in_array(strtoupper((string) $editGender), ['P', 'PEREMPUAN'], true) ? 'selected' : '' ?>>Perempuan</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="kelas<?= (int) $row['id'] ?>" class="form-label">Kelas</label>
                                <input type="text" class="form-control" id="kelas<?= (int) $row['id'] ?>"
                                       name="kelas"
                                       value="<?= esc((int) $editId === (int) $row['id'] ? ($editInput['kelas'] ?? $row['kelas']) : $row['kelas']) ?>"
                                       required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                Batal
                            </button>
                            <button type="submit" class="btn btn-warning text-white">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

<!-- Modal Tambah Data Siswa -->
<div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahLabel">Tambah Data Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <?php $errors = session()->getFlashdata('errors') ?? []; ?>
                <?php if ($errors): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php foreach ($errors as $error): ?>
                            <div><?= esc($error) ?></div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <form id="formTambah" action="<?= site_url('siswa/simpan') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle mb-0">
                            <tbody>
                                <tr>
                                    <th scope="row">
                                        <label for="nis" class="form-label mb-0">NIS</label>
                                    </th>
                                    <td>
                                        <input type="text" class="form-control" id="nis" name="nis" required>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">
                                        <label for="nama" class="form-label mb-0">Nama</label>
                                    </th>
                                    <td>
                                        <input type="text" class="form-control" id="nama" name="nama" required>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">
                                        <label for="jenis_kelamin" class="form-label mb-0">Jenis Kelamin</label>
                                    </th>
                                    <td>
                                        <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                                            <option value="" disabled <?= old('jenis_kelamin') ? '' : 'selected' ?>>Pilih jenis kelamin</option>
                                            <option value="L" <?= old('jenis_kelamin') === 'L' ? 'selected' : '' ?>>Laki-laki</option>
                                            <option value="P" <?= old('jenis_kelamin') === 'P' ? 'selected' : '' ?>>Perempuan</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">
                                        <label for="kelas" class="form-label mb-0">Kelas</label>
                                    </th>
                                    <td>
                                        <input type="text" class="form-control" id="kelas" name="kelas" required>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Batal
                </button>
                <button type="submit" form="formTambah" class="btn btn-primary">
                    Simpan Data
                </button>
            </div>

        </div>
    </div>
</div>

    <!-- CDN JS Bootstrap 5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <?php if ($successMessage || $errorMessage): ?>
        <script>
            alert(<?= json_encode(
                $errorMessage ?: $successMessage,
                JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT
            ) ?>);
        </script>
    <?php endif; ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tableBody = document.getElementById('siswaTableBody');
            const pagination = document.getElementById('siswaPagination');
            const sortColumnSelect = document.getElementById('sortColumnSelect');
            const searchInput = document.getElementById('studentSearch');
            const genderFilter = document.getElementById('genderFilter');
            const emptyState = document.getElementById('emptySiswaMessage');
            const tableStatus = document.getElementById('tableStatus');
            const rowsPerPage = 5;
            const rows = Array.from(tableBody.querySelectorAll('.siswa-row'));
            let currentPage = 1;

            function getFilteredRows() {
                const searchTerm = searchInput.value.trim().toLocaleLowerCase('id');
                const selectedGender = genderFilter.value;

                return rows.filter(function (row) {
                    const searchableText = row.cells[1].textContent + ' ' + row.cells[2].textContent;
                    const matchesSearch = searchableText.toLocaleLowerCase('id').includes(searchTerm);
                    const rowGender = row.dataset.gender === 'LAKI-LAKI' ? 'L'
                        : row.dataset.gender === 'PEREMPUAN' ? 'P'
                        : row.dataset.gender;
                    return matchesSearch && (!selectedGender || rowGender === selectedGender);
                });
            }

            function renderTable() {
                const filteredRows = getFilteredRows();
                const pageCount = Math.max(1, Math.ceil(filteredRows.length / rowsPerPage));
                currentPage = Math.min(Math.max(currentPage, 1), pageCount);
                const start = (currentPage - 1) * rowsPerPage;
                const end = Math.min(start + rowsPerPage, filteredRows.length);
                const visibleRows = new Set(filteredRows.slice(start, end));

                rows.forEach(function (row) {
                    row.hidden = !visibleRows.has(row);
                });
                filteredRows.slice(start, end).forEach(function (row, index) {
                    row.querySelector('.row-number').textContent = String(start + index + 1);
                });

                emptyState.hidden = filteredRows.length > 0;
                tableStatus.textContent = filteredRows.length
                    ? 'Menampilkan ' + (start + 1) + ' - ' + end + ' dari ' + filteredRows.length + ' siswa'
                    : 'Menampilkan 0 siswa';

                pagination.replaceChildren();

                function addPageButton(label, page, disabled, active, ariaLabel) {
                    const item = document.createElement('li');
                    item.className = 'page-item' + (disabled ? ' disabled' : '') + (active ? ' active' : '');
                    const button = document.createElement('button');
                    button.type = 'button';
                    button.className = 'page-link';
                    button.textContent = label;
                    if (ariaLabel) {
                        button.setAttribute('aria-label', ariaLabel);
                    }
                    button.disabled = disabled;
                    if (!disabled && !active) {
                        button.addEventListener('click', function () {
                            currentPage = page;
                            renderTable();
                        });
                    }
                    item.appendChild(button);
                    pagination.appendChild(item);
                }

                addPageButton('Prev', currentPage - 1, currentPage === 1, false, 'Halaman sebelumnya');
                for (let page = 1; page <= pageCount; page++) {
                    addPageButton(String(page), page, false, currentPage === page, 'Halaman ' + page);
                }
                addPageButton('Next', currentPage + 1, currentPage === pageCount, false, 'Halaman berikutnya');
            }

            sortColumnSelect.addEventListener('change', function () {
                const [field, direction] = sortColumnSelect.value.split('-');
                rows.sort(function (first, second) {
                    const column = field === 'nis' ? 1 : 2;
                    return first.cells[column].textContent.trim().localeCompare(
                        second.cells[column].textContent.trim(),
                        'id',
                        { numeric: true, sensitivity: 'base' }
                    ) * (direction === 'desc' ? -1 : 1);
                });
                rows.forEach(function (row) {
                    tableBody.insertBefore(row, emptyState);
                });
                currentPage = 1;
                renderTable();
            });
            searchInput.addEventListener('input', function () {
                currentPage = 1;
                renderTable();
            });
            genderFilter.addEventListener('change', function () {
                currentPage = 1;
                renderTable();
            });
            renderTable();
        });
    </script>
    <?php if ($errors): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                bootstrap.Modal.getOrCreateInstance(document.getElementById('modalTambah')).show();
            });
        </script>
    <?php endif; ?>
    <?php if ($editId !== null && $editErrors): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                bootstrap.Modal.getOrCreateInstance(
                    document.getElementById('modalEdit<?= (int) $editId ?>')
                ).show();
            });
        </script>
    <?php endif; ?>
</body>
</html>