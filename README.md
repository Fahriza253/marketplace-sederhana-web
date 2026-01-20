# Marketplace Sederhana

Project ini merupakan aplikasi berbasis web yang dikembangkan untuk memenuhi tugas akhir mata kuliah Sistem Operasi.

Aplikasi ini menyediakan platform bagi pengguna untuk mencari dan melihat produk yang dijual, dengan fokus utama pada kendaraan (mobil baru maupun bekas). Perlu diperhatikan bahwa seluruh proses transaksi dilakukan di luar sistem aplikasi. Dengan demikian, aplikasi ini berfungsi sebagai media perantara (listing platform) yang menghubungkan calon pembeli dengan penjual.

Selain itu, aplikasi ini juga ditujukan untuk mendukung kebutuhan penjual dalam mengelola produk yang mereka tawarkan. Secara fungsional, sistem ini berperan sebagai halaman manajemen (admin page) bagi penjual untuk melakukan pengelolaan data produk secara sederhana.

## Tips Laravel Project

Buat link storage, dan pastikan gambar ada untuk placeholder dummy data produk kita

```
php artisan storage:link
```

## Todo List

Lihat daftar tugas [di sini](docs/TODO.md)

## Kebutuhan Sistem

Analisis kebutuhan sistem

### Consument User

- [ ] Mencari produk yang diinginkan
- [ ] Membeli produk yang dipilih
- [ ] Menyimpan produk ke daftar simpanan

### Seller User

- [ ] Menjual produk ke publik
- [ ] Manajemen produk yang dijual
- [ ] Manajemen data hasil penjualan

## TODO List

### Listing Product
  
Bugs:

* [ ] Product image must fix

### Detail Product

Bugs: 

  * [ ] Preview product must fix

### Upload product feature

This feature is only for 'admin' and 'seller'. 

  * [*] Form
  * [*] Logic
  * [*] Test  

Bugs
  * [ ] Do the multiple image work
  * [ ] Add slider to view the multiple image uploaded
  * [ ] Create a button to select which is the primary image

Another option list that may be good
Edit Product

  * [ ] Approval Admin
  * [ ] Drag & Drop Image Order
  * [ ] Product Draft
  * [ ] Delete / Replace Image

### Product List

Menampilkan product yang tersedia dalam bentuk table. Fitur hanya untuk admin dan seller saja

- [*] Table views
- [ ] Action
- [*] Filter list
- [*] Pagination

### Actions Product

- [*] Form Edit
- [*] Save Changes
- [ ] Remove Product
- [ ] Edit Status

## Credits

- (CLicon)(https://www.figma.com/community/file/1271751279140741643)
- (Bokker)[https://www.figma.com/community/file/1141734879360095951]x`  
- (Mira Cars)[https://www.figma.com/community/file/1559941251203168177]
