# TODO: Fitur Search & Filter Halaman

## 1. Halaman Ticket (Index) — SELESAI

- [x] Perbarui `TicketController::index()`: search (judul, kode_ticket, client, category), filter status, kategori, jenis, per_page + withQueryString
- [x] Perbarui view `tickets/index.blade.php`: dropdown per-page, kolom pencarian, filter status/kategori/jenis, info data, pagination, fungsi JS
- [x] Samakan dropdown status dengan pola halaman Client (masukkan 'Semua Status' ke dalam array $statuses agar highlight aktif benar)

## 2. Halaman Index Category Ticket — SELESAI

- [x] Perbarui `TicketCategoryController::index()`: tambah search (hanya nama kategori) & per_page + withQueryString
- [x] Perbarui view `ticket_categories/index.blade.php`: tambah dropdown per-page, kolom pencarian, info data, pagination, fungsi JS

## 3. Halaman Index Ticket Rules / SLA Rules — SELESAI

- [x] Perbarui `TicketRuleController::index()`: tambah search (nama_rule & kategori) & per_page + withQueryString
- [x] Perbarui view `ticket_rules/index.blade.php`: tambah dropdown per-page, kolom pencarian, info data, pagination, fungsi JS

## 4. Halaman Monitoring SLA — SELESAI

- [x] Perbarui `TicketController::monitoringSla()`: tambah search (kode_ticket, judul, nama klien) & per_page + withQueryString
- [x] Perbarui view `tickets/monitoring_sla.blade.php`: tambah dropdown per-page, kolom pencarian, info data, pagination, fungsi JS (searchTable & updatePerPage)
- [x] Pertahankan filter sla_status yang sudah ada (On Time / Warning / Breach)
