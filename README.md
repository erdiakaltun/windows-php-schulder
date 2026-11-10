# PHP Zamanlanmış Görev Yöneticisi

PHP ve MySQL ile yazılmış, Windows Görev Zamanlayıcı üzerinden PHP betikleri çalıştıran bir görev yöneticisi. Görevleri web arayüzünden yönetebilirsiniz.

## Gereksinimler

- PHP 7.4+
- MySQL
- Apache veya başka bir PHP web sunucusu
- Windows Task Scheduler (çalıştırıcıyı zamanlamak için)

## Kurulum

1. `db.sql` dosyasını MySQL'e aktarın.
2. `config.php` içindeki veritabanı bağlantı bilgilerini ayarlayın.
3. Web sunucusunda `SCHULDER_ADMIN_PASSWORD_HASH` ortam değişkenini yapılandırın. Hash üretmek için:

   ```sh
   php -r "echo password_hash('GÜÇLÜ_BİR_PAROLA', PASSWORD_DEFAULT), PHP_EOL;"
   ```

   Üretilen değeri ortam değişkenine koyun; parolanın kendisini kaynak koduna eklemeyin. Hash yapılandırılmadan yönetim arayüzü kullanıma açılmaz.

4. Proje dosyalarını web sunucusuna kopyalayın ve `login.php` sayfasını açın.
5. Yeni görevleri `scripts/` klasöründeki dosyalarla sınırlandırın ve web sunucusunu yalnızca güvendiğiniz kullanıcılara açın.

## Zamanlanmış çalıştırma

`cron_runner.php` yalnızca PHP CLI üzerinden çalışır. Windows Görev Zamanlayıcı'da PHP çalıştırılabilir dosyasını eylem olarak seçin ve argümanlara tam dosya yolunu verin:

```text
Program: C:\\bin\\php\\php.exe
Arguments: C:\\path\\to\\schulder\\cron_runner.php
```

Örneğin her 5 dakikada bir çalışacak şekilde tetikleyici ekleyebilirsiniz. Bu dosya HTTP isteğiyle çalıştırılamaz.

## Güvenlik

- Yönetim oturumu `SCHULDER_ADMIN_PASSWORD_HASH` ile korunur.
- Görev ekleme, güncelleme, etkinleştirme ve silme formları CSRF token kullanır.
- Görev çalıştırıcıyı web sunucusundan açmayın; Windows Görev Zamanlayıcı ile CLI kullanın.
- Uygulama kod çalıştırabildiğinden, web arayüzüne erişimi sınırlandırın.
