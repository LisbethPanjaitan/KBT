# Git Workflow - KBT Project

## Branch Strategy

### Main Branch (`main`)
- **Tujuan:** Production-ready code, stable version
- **Fungsi:** Backup dan cadangan utama
- **Aturan:** Hanya menerima merge dari `development` branch
- **Status:** ✅ Protected - Code yang sudah stabil dan tested

### Development Branch (`development`)
- **Tujuan:** Active development branch
- **Fungsi:** Tempat development dan testing fitur baru
- **Aturan:** Semua perubahan baru dilakukan di sini
- **Status:** 🚧 Active Development

---

## Workflow Sehari-hari

### 1️⃣ Mulai Bekerja (Pastikan di branch development)
```bash
# Cek branch saat ini
git branch

# Jika belum di development, pindah ke development
git checkout development

# Update dari remote
git pull origin development
```

### 2️⃣ Buat Perubahan & Commit
```bash
# Cek status file yang berubah
git status

# Add semua perubahan
git add .

# Commit dengan pesan yang jelas
git commit -m "Feature: Deskripsi singkat perubahan"

# Push ke development branch
git push origin development
```

### 3️⃣ Merge ke Main (Setelah Testing)
**HANYA LAKUKAN INI JIKA CODE SUDAH STABIL & TESTED!**

```bash
# Pindah ke main branch
git checkout main

# Update main dari remote
git pull origin main

# Merge development ke main
git merge development

# Push ke main
git push origin main

# Kembali ke development untuk lanjut kerja
git checkout development
```

---

## Contoh Workflow Lengkap

### Skenario: Menambah fitur payment gateway

```bash
# 1. Pastikan di development
git checkout development
git pull origin development

# 2. Buat perubahan (edit files, add code)
# ... coding ...

# 3. Commit perubahan
git add .
git commit -m "Feature: Add payment gateway integration with Midtrans"
git push origin development

# 4. Test fitur di development
# ... testing ...

# 5. Jika sudah OK, merge ke main
git checkout main
git pull origin main
git merge development
git push origin main

# 6. Kembali ke development
git checkout development
```

---

## Commands Quick Reference

```bash
# Lihat branch aktif
git branch

# Pindah branch
git checkout [nama-branch]

# Cek status
git status

# Add & Commit
git add .
git commit -m "Pesan commit"

# Push ke current branch
git push

# Pull dari remote
git pull

# Merge branch lain ke current branch
git merge [nama-branch]

# Lihat history commit
git log --oneline

# Batalkan perubahan yang belum di-commit
git restore [nama-file]

# Lihat perbedaan
git diff
```

---

## Emergency: Rollback ke Commit Sebelumnya

### Jika ada masalah di development:
```bash
# Lihat history
git log --oneline

# Rollback ke commit tertentu (soft - keep changes)
git reset --soft [commit-hash]

# Atau hard reset (HATI-HATI: hapus semua perubahan)
git reset --hard [commit-hash]
```

### Jika main branch bermasalah:
```bash
git checkout main
git log --oneline
git reset --hard [commit-hash-yang-stabil]
git push -f origin main  # Force push (HATI-HATI!)
```

---

## Best Practices

✅ **DO:**
- Selalu bekerja di `development` branch
- Commit dengan pesan yang jelas dan deskriptif
- Pull sebelum push untuk menghindari conflict
- Test code sebelum merge ke `main`
- Merge ke `main` hanya saat fitur sudah stabil

❌ **DON'T:**
- Jangan langsung coding di `main` branch
- Jangan force push ke `main` kecuali emergency
- Jangan commit tanpa testing dulu
- Jangan lupa pull sebelum mulai kerja

---

## Current Branch Status

**Main Branch:**
- Status: ✅ Stable
- Last Commit: Feature - Complete booking system
- Files: 62 files, 10,243 lines

**Development Branch:**
- Status: 🚧 Active
- Synced with: main
- Ready for: New features

---

## Tips

1. **Commit Often:** Lebih baik banyak commit kecil daripada satu commit besar
2. **Descriptive Messages:** Gunakan format "Feature:", "Fix:", "Update:", "Refactor:"
3. **Pull Before Push:** Selalu pull dulu sebelum push
4. **Test First:** Test di development sebelum merge ke main
5. **Backup:** Main branch adalah backup, jangan rusak!

---

## Kontak
Jika ada pertanyaan tentang Git workflow, tanya AI assistant! 🤖
