# 🕒 PHP Zamanlanmış Görev Yöneticisi

Bu proje, PHP dili ile yazılmış basit bir **zamanlanmış görev (task scheduler)** uygulamasıdır.  
Web arayüzü üzerinden görev ekleyebilir, düzenleyebilir, aktif/pasif yapabilir ve silebilirsiniz.  
Eklenen görevler, **Windows Görev Zamanlayıcı (Task Scheduler)** ile belirli aralıklarla çalıştırılır.

## 📂 Proje Yapısı

assets/ # CSS, JS ve görseller
scripts/ # test script dosyası
add_task.php # Yeni görev ekleme
config.php # Veritabanı bağlantı ayarları
cron_runner.php # Zamanlanmış görevleri çalıştırır
db.sql # Veritabanı yapısı
delete_task.php # Görev silme
edit_task.php # Görev düzenleme
index.php # Görev listeleme ve yönetim
toggle_task.php # Görevi aktif/pasif yapma
README.md # Proje dökümantasyonu



## 🚀 Kurulum

1. **Veritabanını oluşturun**
   - `db.sql` dosyasını MySQL veritabanınıza import edin.

2. **Veritabanı ayarlarını yapın**
   - `config.php` dosyasındaki veritabanı bilgilerini kendi sunucunuza göre düzenleyin.

3. **Proje dosyalarını yükleyin**
   - Tüm proje dosyalarını web sunucunuza kopyalayın.

4. **Çalıştırma**
   - `index.php` üzerinden görevlerinizi ekleyin ve yönetin.

## ⏱ Windows Görev Zamanlayıcı Ayarı

Görevlerin otomatik çalışması için `cron_runner.php` dosyasını belirli aralıklarla çalıştıracak bir görev ekleyin.

**Adımlar:**
1. Windows'ta **Görev Zamanlayıcı** uygulamasını açın.
2. **Yeni Görev** oluşturun.
3. **Tetikleyici (Trigger)** ekleyerek çalışma aralığını belirleyin (örn: her 5 dakikada bir).
4. **Eylem (Action)** olarak `php.exe`'yi seçin.
5. Argüman olarak `C:\path\to\cron_runner.php` dosya yolunu ekleyin.
6. Kaydedin.

Örnek komut:
**C:\bin\php\php8.2.18\php.exe "C:\\schulder\\scripts\\test.php"**



## 📌 Notlar
- Uygulama **PHP 7.4+** ile uyumludur.
- `cron_runner.php` dosyası tarayıcıdan çalıştırılabilir, ancak otomasyon için **Görev Zamanlayıcı** kullanılması önerilir.
- Unix/Linux sistemlerinde `cron` kullanarak aynı mantıkla çalıştırabilirsiniz.





